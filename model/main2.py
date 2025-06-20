from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import joblib
import numpy as np
import pandas as pd

app = FastAPI()

# Load model, scaler, encoder, dan selector
model = joblib.load("stacked_model.pkl")
scaler = joblib.load("robust_scaler.pkl")
selector = joblib.load("feature_selector.pkl")
label_encoder = joblib.load("ordinal_encoder.pkl")

print("Label Encoder Classes:", label_encoder.categories_)

# Struktur input dari user
class AnxietyInput(BaseModel):
    workStressLevel: int
    stressLevel: int
    heartRate: int
    heartRateVariability: int
    cortisolLevel: int
    therapySession: int
    sleepQuality: int
    overthinking: int
    lackOfConfidence: int
    lackOfSleep: int
    exerciseFrequency: int
    loneliness: int


def get_suggestion(anxiety_level: str) -> str:
    suggestions = {
        "Low": "Great job maintaining your mental well-being! Keep up healthy habits like regular exercise, good sleep, and social connections.",
        "Medium": "You might be experiencing some stress. Consider relaxation techniques, talking to someone you trust, or trying mindfulness or therapy.",
        "High": "Your anxiety level appears high. It’s important to seek professional help, practice stress-reducing habits, and avoid triggers where possible."
    }
    return suggestions.get(anxiety_level, "No suggestion available.")

@app.post("/predict")
def predict(input: AnxietyInput):
    try:
        # gender_map = {"Male": 1, "Female": 2, "Other": 3}

        # Menambahkan fitur yang hilang sebelum memprediksi
        data = {
            "WorkStressLevel": input.workStressLevel,
            "StressLevel": input.stressLevel,
            "HeartRate": input.heartRate,
            "HeartRateVariability": input.heartRateVariability,
            "CortisolLevel": input.cortisolLevel,
            "TherapySessions": input.therapySession,
            "SleepQuality": input.sleepQuality,
            "Overthinking": input.overthinking,
            "LackofConfidence": input.lackOfConfidence,
            "LackofSleep": input.lackOfSleep,
            "ExerciseFrequency": input.exerciseFrequency,
            "Loneliness": input.loneliness,
        }

        input_df = pd.DataFrame([data])

        input_df = input_df[[ 
                'WorkStressLevel',
                'StressLevel', 'HeartRate', 'HeartRateVariability', 'CortisolLevel', 'TherapySessions',
                'SleepQuality', 'Overthinking', 'LackofConfidence', 'LackofSleep', 'ExerciseFrequency',
                'Loneliness'
        ]]

        # Scaling
        input_scaled = scaler.transform(input_df)

        # Feature Selection
        input_selected = selector.transform(input_scaled)

        # Predict
        probs = model.predict_proba(input_selected)[0]
        classes = label_encoder.categories_[0]
        prob_dict = dict(zip(classes, probs))

        pred_class_index = np.argmax(probs)
        label = label_encoder.inverse_transform([[pred_class_index]])[0][0]

        suggestion = get_suggestion(label)

        return {
            "prediction": label,
            "probabilities": prob_dict,
            "suggestion": suggestion
        }

    except Exception as e:
        print(f"Error occurred: {str(e)}")
        raise HTTPException(status_code=500, detail=str(e))
