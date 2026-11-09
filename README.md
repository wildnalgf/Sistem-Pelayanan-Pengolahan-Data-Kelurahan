# 🏛️ Sistem Pelayanan & Pengolahan Data Kelurahan
> **Tugas Pengganti UTS - Mata Kuliah Strategi Algoritma**  
> **Universitas Tiga Serangkai (TSU)**

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-Theme%20TSU-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![Laragon](https://img.shields.io/badge/Environment-Laragon-0E83CD?style=for-the-badge)

Aplikasi web Sistem Pelayanan dan Pengolahan Data Kelurahan berbasis PHP Native yang dikembangkan untuk mengimplementasikan dua algoritma utama: **Algoritma Greedy** untuk optimasi alokasi dana Bantuan Sosial (Bansos) dan **Algoritma Merge Sort** (*Divide and Conquer*) untuk verifikasi pengurutan Data Pemilih Tetap (DPT).

---

## 📸 Antarmuka Aplikasi (Branding TSU)
Antarmuka didesain menggunakan identitas visual **Universitas Tiga Serangkai (TSU)** dengan kombinasi warna *Deep Ocean Teal* (`#116979`) dan *Gold* (`#f2a900`).

| Halaman Guest / Warga | Halaman Mode Admin |
| :---: | :---: |
| *Tampilan Read-Only data DPT & Bansos* | *Akses Edit Anggaran, Tambah & Hapus DPT* |

---

## 🚀 Fitur Utama & Algoritma

### 1. 💰 Optimasi Alokasi Dana Bansos (Algoritma Greedy)
* Mengalokasikan dana bansos berdasarkan prioritas tertinggi menggunakan kalkulasi rasio:
  $$\text{Rasio Prioritas } (R) = \frac{\text{Skor Kemiskinan } (P)}{\text{Kuota Bantuan } (K)}$$
* Mengurutkan seluruh KPM secara *greedy* dan memilih calon penerima hingga batas maksimal total anggaran yang tersedia.

### 2. 📋 Verifikasi Data DPT (Algoritma Merge Sort)
* Pengurutan data kependudukan DPT secara cepat menggunakan prinsip *Divide and Conquer* dengan kompleksitas waktu $\mathcal{O}(n \log n)$.
* Mendukung pengurutan dinamis berdasarkan 3 kriteria utama:
  * **NIK** (Default)
  * **Umur** (Termuda ke Tertua)
  * **Pendapatan** (Terkecil ke Terbesar)

### 3. 🔐 Multi-Role Access Control
* **Guest / Warga**: Akses *Read-Only* untuk pemantauan alokasi dana bansos dan daftar DPT.
* **Admin**: Hak akses penuh (*Full Access*) untuk mengedit total anggaran bansos, menambah warga baru, dan menghapus data DPT.

---

## 📂 Struktur Repositori

```text
uts_strategi_algoritma/
├── assets/
│   ├── css/
│   │   └── style.css          # Styling kustom identitas TSU (Teal & Gold)
│   └── Logo kampus.jpg        # Assets Logo Universitas Tiga Serangkai
├── includes/
│   ├── algorithms.php        # Algoritma Merge Sort & Greedy Bansos
│   ├── auth.php              # Kontrol Sesi & Autentikasi Multi-Role
│   ├── header.php            # Navigasi & Branding TSU
│   └── footer.php            # Footer Aplikasi
├── index.php                 # Dashboard Utama
├── login.php                 # Form Login Multi-Role (Admin/Warga)
└── logout.php                # Destruksi Sesi Login