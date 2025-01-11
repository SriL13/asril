<?php
session_start();

// Periksa apakah sesi admin ada
if (isset($_SESSION['admin'])) {
    // Jika admin yang logout
    unset($_SESSION['admins']); // Hapus sesi admin
} elseif (isset($_SESSION['username'])) {
    // Jika user yang logout
    unset($_SESSION['username']); // Hapus sesi user
}

// Hancurkan sesi secara keseluruhan
session_destroy();

// Arahkan ke halaman index setelah logout
header("Location: index.php");
exit;
