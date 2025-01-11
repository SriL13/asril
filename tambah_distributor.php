<?php
// Koneksi ke database
include 'koneksi.php';
// Logika untuk insert data
if (isset($_POST['tambah_distributor'])) {
    $nama_distributor = $conn->real_escape_string($_POST['nama_distributor']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $no_telp = $conn->real_escape_string($_POST['no_telp']);
    $tanggal = $conn->real_escape_string($_POST['tanggal']);

    // Query insert data
    $sql = "INSERT INTO distributor (nama_distributor, alamat, no_telp, tanggal) 
            VALUES ('$nama_distributor', '$alamat', '$no_telp', '$tanggal')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data distributor berhasil ditambahkan!');</script>";
        header('Location: tes.php');
        exit(); // Pastikan skrip berhenti setelah redirect
    } else {
        echo "<script>alert('Gagal menambahkan data: " . $conn->error . "');</script>";
    }
}

// Tutup koneksi
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Distributor</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f7ff;
            /* Lighter pastel baby blue */
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
            background-color: #777777;
            /* Lighter gray */
            border-color: #777777;
            padding: 12px 24px;
            border-radius: 8px;
            width: 100%;
            text-align: center;
            margin-top: 15px;
            /* Menambahkan jarak antara tombol tambah dan tombol kembali */
        }

        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 12px;
        }

        .btn-secondary:hover {
            background-color: #555555;
            /* Darker gray on hover */
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
        <h2>Tambah Distributor</h2>

        <form method="POST">
            <div class="form-group">
                <label for="nama_distributor">Nama Distributor:</label>
                <input type="text" class="form-control" id="nama_distributor" name="nama_distributor" placeholder="Masukkan nama distributor" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat distributor" required>
            </div>

            <div class="form-group">
                <label for="no_telp">No. Telepon:</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan nomor telepon" required>
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Bergabung:</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>

            <button type="submit" name="tambah_distributor" class="btn btn-primary">Tambah Distributor</button>

            <div class="btn-container">
                <a href="tes.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS dan dependensi -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>