<?php
// Konfigurasi database
$host = "localhost";      // Nama host (default: localhost)
$user = "root";           // Username MySQL (default: root)
$pass = "";               // Password MySQL (kosongkan jika default)
$db   = "db_admin";       // Nama database

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
