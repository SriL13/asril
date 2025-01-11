<?php
// Menghubungkan ke database
include 'koneksi.php';

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_karyawan'])) {
    $nama_karyawan = $_POST['nama_karyawan'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    // Query untuk menambahkan karyawan
    $query = "INSERT INTO karyawan (nama_karyawan, alamat, no_telp) 
              VALUES ('$nama_karyawan', '$alamat', '$no_telp')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Karyawan berhasil ditambahkan!'); window.location.href='tes.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Menutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f7ff; /* Lighter pastel baby blue */
            font-family: 'Arial', sans-serif;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin-top: 50px;
        }

        h2 {
            color: #01579b;
            /* Darker blue */
            font-weight: bold;
            text-align: center;
        }

        .btn-primary {
            background-color: #0097e6;
            border-color: #0097e6;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: bold;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #007bb5;
            border-color: #007bb5;
        }

        .btn-secondary {
            background-color: #777777; /* Lighter gray */
            border-color: #777777;
            padding: 12px 24px;
            border-radius: 8px;
            width: 100%;
            text-align: center;
        }

        .btn-secondary:hover {
            background-color: #555555; /* Darker gray on hover */
            border-color: #555555;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            font-size: 1rem;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 12px 15px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #0097e6;
            box-shadow: 0 0 5px rgba(0, 151, 230, 0.4);
        }

        .form-control::placeholder {
            color: #bbb;
        }

        .form-control,
        .btn-primary,
        .btn-secondary {
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus,
        .btn-primary:hover,
        .btn-secondary:hover {
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Tambah Karyawan</h2>

        <form method="POST">
            <div class="form-group">
                <label for="nama_karyawan">Nama Karyawan:</label>
                <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" placeholder="Masukkan nama karyawan" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat karyawan" required>
            </div>

            <div class="form-group">
                <label for="no_telp">No. Telepon:</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan nomor telepon" required>
            </div>

            <button type="submit" name="tambah_karyawan" class="btn btn-primary">Tambah Karyawan</button>
            <a href="tes.php" class="btn btn-secondary mt-3">Kembali</a>
        </form>
    </div>

    <!-- Bootstrap JS dan dependensi -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
