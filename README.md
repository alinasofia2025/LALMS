# Letter Management System

Sistem ini dibina berdasarkan struktur sistem khairat/ReCRUD yang awak berikan. Modul khairat telah disesuaikan kepada **Letter Management System** untuk mengurus faculty, program, project, lecturer, subject dan appointment letter.

## Login Admin

- Email: `admin@lalms.edu.my`
- Password: `password`

## Requirements

- PHP 8.1 ke atas
- PHP extensions: `intl`, `dom`, `mbstring`, `pdo_mysql`
- MySQL/MariaDB
- XAMPP/WAMP/Laragon

## Cara Setup di XAMPP/WAMP

1. Extract folder `letter_management_system` ke dalam `htdocs`.
2. Buka phpMyAdmin dan create database bernama `letter_management_db`.
3. Import file SQL: `database/letter_management_system.sql`.
4. Semak `config/app_local.php` dan pastikan database ialah `letter_management_db`, username `root`, password kosong.
5. Buka browser: `http://localhost/letter_management_system` atau ikut nama folder yang awak letak.

## Modul Sistem

- Dashboard ringkasan rekod
- Faculty Management
- Program Management
- Project Management
- Lecturer Management
- Subject Management
- Appointment / Letter Management
- Print appointment letter
- Login admin dan user management asal daripada sistem khairat

## Nota Database

Database asal yang awak beri ada foreign key yang tersalah arah. Dalam SQL final, foreign key telah dibetulkan dan saya tambah table `projects` sebab table `appointments` ada field `projects_id`, tetapi database asal tiada table `projects`.

## Database Asal

Database asal yang awak upload disimpan semula dalam folder `database/original_letter_management_db.sql` untuk rujukan. Gunakan `database/letter_management_system.sql` sebagai database final yang sudah dibetulkan.
