<?php
// Menghubungkan ke database
include 'koneksi.php';

// Cek jika ada ID di URL
if (isset($_GET['id'])) {
    $id_karyawan = $_GET['id'];

    // Query untuk mengambil data karyawan berdasarkan ID
    $query = "SELECT * FROM karyawan WHERE id_karyawan = '$id_karyawan'";
    $result = mysqli_query($conn, $query);
    $karyawan = mysqli_fetch_assoc($result);

    if (!$karyawan) {
        die("Karyawan tidak ditemukan!");
    }

    // Proses update data jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_karyawan'])) {
        $nama_karyawan = $_POST['nama_karyawan'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];

        // Query untuk mengupdate data karyawan
        $updateQuery = "UPDATE karyawan SET 
                        nama_karyawan = '$nama_karyawan', 
                        alamat = '$alamat', 
                        no_telp = '$no_telp' 
                        WHERE id_karyawan = '$id_karyawan'";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Karyawan berhasil diupdate!'); window.location.href='tes.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
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
    <title>Edit Karyawan</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f7ff; /* Lighter pastel blue */
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 80px;
            max-width: 600px;
        }

        h2 {
            color: #01579b;
            /* Darker blue */
            font-weight: bold;
            text-align: center;
        }


        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 15px;
            font-size: 1rem;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: inset 0 2px 5px rgba(0, 123, 255, 0.3);
        }

        .btn-primary {
            background-color: #0097e6;
            border-color: #0097e6;
            border-radius: 8px;
            padding: 10px 24px;
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
            padding: 10px 24px;
            border-radius: 8px;
            width: 100%;
            text-align: center;
        }

        .btn-secondary:hover {
            background-color: #555555; /* Darker gray on hover */
            border-color: #555555;
        }

        /* Add space between the buttons */
        .btn-secondary {
            margin-top: 10px;
        }

        .form-container,
        .btn-primary,
        .btn-secondary {
            transition: all 0.3s ease;
        }

        .form-container:focus,
        .btn-primary:hover,
        .btn-secondary:hover {
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Karyawan</h2>

        <form method="POST" class="form-container">
            <div class="form-group">
                <label for="nama_karyawan">Nama Karyawan:</label>
                <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" value="<?= htmlspecialchars($karyawan['nama_karyawan']); ?>" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= htmlspecialchars($karyawan['alamat']); ?>" required>
            </div>

            <div class="form-group">
                <label for="no_telp">No. Telepon:</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= htmlspecialchars($karyawan['no_telp']); ?>" required>
            </div>

            <button type="submit" name="edit_karyawan" class="btn btn-primary">Update Karyawan</button>
            <a href="tes.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Bootstrap JS dan dependensi -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
