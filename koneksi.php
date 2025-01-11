<?php
// Konfigurasi database
$host = "103.171.161.6";      // Nama host (default: localhost)
$user = "asril";           // Username MySQL (default: root)
$pass = "Pass@1234";               // Password MySQL (kosongkan jika default)
$db   = "ti_a_asril";       // Nama database

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
