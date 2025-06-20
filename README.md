# 📊 Dashboard Anxiety Prediction

![Status](https://img.shields.io/badge/status-active-brightgreen)
![Laravel](https://img.shields.io/badge/laravel-10.x-red)
![Python](https://img.com/badge/python-3.8%2B-blue)
![FastAPI](https://img.shields.io/badge/api-FastAPI-teal)
![License](https://img.shields.io/badge/license-MIT-green)

Dashboard Anxiety Prediction adalah sebuah proyek Machine Learning yang bertujuan memprediksi tingkat kecemasan seseorang berdasarkan input tertentu. Proyek ini **mengintegrasikan dua teknologi utama**: **Laravel** (PHP) untuk backend dan frontend (menggunakan Blade dan Vite), serta **FastAPI** (Python) sebagai API yang menjalankan model Machine Learning.

Proses pelatihan model dilakukan menggunakan Jupyter Notebook, dan model yang telah dilatih kemudian disimpan dalam format `.joblib` untuk dipanggil oleh API FastAPI.

---

## Persyaratan Sistem

Untuk menjalankan proyek ini, kamu memerlukan beberapa software utama:

* **Git**
* **PHP 8.x**
* **Composer**
* **Python 3.8+**
* **Node.js**
* **Jupyter Notebook**
* **Uvicorn**
* **FastAPI**
* **Laravel installer** (opsional, jika ingin menggunakan perintah artisan secara global)

---

## Panduan Instalasi dan Menjalankan Proyek

Ikuti langkah-langkah di bawah ini untuk mengatur dan menjalankan proyek di lingkungan lokalmu:

### 1. Meng-clone Repositori

Mulai dengan meng-clone repositori ini ke mesin lokalmu:

```bash
git clone [https://github.com/yimeiw/dashboard-anxiety-prediction.git](https://github.com/yimeiw/dashboard-anxiety-prediction.git)
cd dashboard-anxiety-prediction
````

### 2\. Instalasi Dependensi Laravel

Setelah masuk ke direktori proyek, instal semua dependensi PHP yang diperlukan oleh Laravel menggunakan Composer:

```bash
composer install
```

### 3\. Pelatihan Model Machine Learning

Kamu perlu melatih model prediksi kecemasan terlebih dahulu:

1.  Buka file Jupyter Notebook yang terletak di `notebooks/training_model.ipynb`.

2.  Jalankan seluruh sel di dalam notebook untuk melatih model.

3.  Setelah selesai, simpan model yang sudah dilatih ke dalam file `.joblib` dengan kode berikut:

    ```python
    import joblib
    joblib.dump(model, 'anxiety_model.joblib')
    ```

4.  Pindahkan file hasil training (`anxiety_model.joblib`) ke dalam folder `model/` agar bisa digunakan oleh FastAPI.

### 4\. Menjalankan FastAPI (API Machine Learning)

Sebelum menjalankan FastAPI, pastikan kamu telah menginstal dependensi Python yang diperlukan:

```bash
pip install uvicorn fastapi joblib scikit-learn
```

Kemudian, jalankan FastAPI:

```bash
uvicorn main:app --reload --host 0.0.0.0 --port 8081
```

FastAPI akan tersedia di:

  * **Endpoint Utama:** [tautan mencurigakan telah dihapus]
  * **Dokumentasi Swagger UI:** [http://127.0.0.1:8081/docs](http://127.0.0.1:8081/docs)
  * **Dokumentasi ReDoc:** [http://127.0.0.1:8081/redoc](http://127.0.0.1:8081/redoc)

### 5\. Menjalankan Antarmuka Laravel

Setelah API FastAPI berjalan, kamu bisa menjalankan antarmuka pengguna Laravel:

1.  **Instal Dependensi Frontend:**

    ```bash
    npm install
    npm run dev
    ```

2.  **Jalankan Aplikasi Laravel:**

    ```bash
    php artisan serve
    ```


## Struktur Proyek

Berikut adalah gambaran umum struktur direktori proyek ini:

```
dashboard-anxiety-prediction/
├── app/                  # Logika aplikasi Laravel (controller, model, dll.)
├── model/
│   └── anxiety_model.joblib # Model ML yang telah dilatih
├── notebooks/
│   └── training_model.ipynb # Jupyter Notebook untuk pelatihan model
├── main.py               # Aplikasi FastAPI
├── public/               # File aset publik Laravel
├── resources/            # Sumber daya Laravel (views, assets, dll.)
├── routes/               # Definisi rute Laravel
├── package.json          # Dependensi Node.js (frontend)
├── composer.json         # Dependensi PHP (Laravel)
└── README.md             # Dokumen ini
```


## Pemecahan Masalah Umum

Jika kamu mengalami error saat menjalankan Laravel, coba perintahkan:

```bash
php artisan config:cache
php artisan migrate
```

## Lisensi

Proyek ini dilisensikan di bawah **Lisensi MIT**. Ini berarti kamu bebas menggunakannya, memodifikasi, dan menyebarluaskan dengan tetap menyertakan lisensi. Silakan lihat file `LICENSE` untuk detailnya.

## Kontribusi

Kami sangat terbuka terhadap **pull request**, **laporan bug**, dan **ide pengembangan lainnya**. Jika kamu tertarik untuk berkontribusi, jangan ragu untuk melakukannya\!

