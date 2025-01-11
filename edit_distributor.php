<?php
// Menghubungkan ke database
include 'koneksi.php';

// Cek jika ada ID di URL
if (isset($_GET['id'])) {
    $id_distributor = $_GET['id'];

    // Query untuk mengambil data distributor berdasarkan ID
    $query = "SELECT * FROM distributor WHERE id_distributor = '$id_distributor'";
    $result = mysqli_query($conn, $query);
    $distributor = mysqli_fetch_assoc($result);

    if (!$distributor) {
        die("Distributor tidak ditemukan!");
    }

    // Proses update data jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_distributor'])) {
        $nama_distributor = $_POST['nama_distributor'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];
        $tanggal = $_POST['tanggal'];

        // Query untuk mengupdate data distributor
        $updateQuery = "UPDATE distributor SET 
                        nama_distributor = '$nama_distributor', 
                        alamat = '$alamat', 
                        no_telp = '$no_telp', 
                        tanggal = '$tanggal' 
                        WHERE id_distributor = '$id_distributor'";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Distributor berhasil diupdate!'); window.location.href='tes.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Menutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Distributor</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f7ff; /* Lighter pastel blue */
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        h2 {
            color: #01579b;
            font-weight: bold;
            text-align: center;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            background-color: #ffffff !important; /* Force white background */
            border-radius: 10px;
            border: 1px solid #ccc; /* Light border for contrast */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            color: #333; /* Dark text for readability */
        }

        .form-control:focus {
            box-shadow: 0 0 5px rgba(78, 154, 232, 0.5); /* Light blue glow on focus */
            border-color: #0097e6; /* Add color to border when focused */
        }


        .btn {
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: bold;
            transition: background-color 0.3s ease;
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
            justify-content: center;
            border-color: #777777;
            padding: 10px 24px;
            border-radius: 10px;
            width: 99%;
            text-align: center;
            margin-top: 20px;
        }

        .btn-secondary:hover {
            background-color: #555555; /* Darker gray on hover */
            border-color: #555555;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 10px; /* Space between buttons */
            margin-top: 20px; /* Space above the buttons */
        }



        .mt-2 {
            margin-top: 10px;
        }

        .form-group label {
            font-weight: 600;
            color: #5f9ea0;
        }

        .form-group input[type="text"],
        .form-group input[type="date"] {
            background-color: #f0f8ff;
        }
        

    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Distributor</h2>
        <form method="POST" class="shadow p-4 rounded bg-white">
            <div class="form-group">
                <label for="nama_distributor">Nama Distributor:</label>
                <input type="text" class="form-control" id="nama_distributor" name="nama_distributor" value="<?= htmlspecialchars($distributor['nama_distributor']); ?>" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= htmlspecialchars($distributor['alamat']); ?>" required>
            </div>

            <div class="form-group">
                <label for="no_telp">No. Telepon:</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= htmlspecialchars($distributor['no_telp']); ?>" required>
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Bergabung:</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $distributor['tanggal']; ?>" required>
            </div>

            <button type="submit" name="edit_distributor" class="btn btn-primary">Update Distributor</button>
            <a href="tes.php" class="btn btn-secondary ml-2">Kembali</a>
        </form>
    </div>

    <!-- Bootstrap JS dan dependensi -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
