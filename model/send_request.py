import requests

url = "http://localhost:8001/predict"
headers = {"Content-Type": "application/json"}
data = {
    "Age": 30,
    "Gender": "Male",
    "SleepHours": 7.0,
    "PhysicalActivity": 2.0,
    "CaffeineIntake": 2,
    "WorkStressLevel": 5,
    "StressLevel": 4,
    "HeartRate": 75,
    "HeartRateVariability": 50,
    "CortisolLevel": 10,
    "TherapySessions": 1,
    "SleepQuality": 4,
    "Overthinking": 2,
    "LackofConfidence": 3,
    "LackofSleep": 2,
    "ExerciseFrequency": 3,
    "Loneliness": 1
}

response = requests.post(url, headers=headers, json=data)
print(response.json())  # Menampilkan respon dari FastAPI
