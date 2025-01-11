<?php
// tambah_barang.php
include 'koneksi.php';

// Ambil daftar distributor
$distributorQuery = "SELECT id_distributor, nama_distributor FROM distributor";
$distributors = mysqli_query($conn, $distributorQuery);

// Proses tambah barang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_barang'])) {
    $id_distributor = $_POST['id_distributor'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];

    // Handle upload gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar = file_get_contents($_FILES['gambar']['tmp_name']);
    } else {
        $gambar = null;
    }

    // Query tambah barang
    $query = "INSERT INTO barang (id_distributor, nama_barang, harga, gambar) VALUES (?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "isis", $id_distributor, $nama_barang, $harga, $gambar);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Barang berhasil ditambahkan!'); window.location.href = 'tes.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
         /* Add space between the buttons */
         .btn-secondary {
            margin-top: 10px;
        }
        
    </style>
</head>

<body>
    <div class="container">
        <h2>Tambah Barang</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="id_distributor" class="form-label">Distributor:</label>
                <select id="id_distributor" name="id_distributor" class="form-select" required>
                    <option value="">Pilih Distributor</option>
                    <?php while ($row = mysqli_fetch_assoc($distributors)): ?>
                        <option value="<?= $row['id_distributor']; ?>"><?= $row['nama_distributor']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang:</label>
                <input type="text" id="nama_barang" name="nama_barang" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga:</label>
                <input type="number" id="harga" name="harga" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar:</label>
                <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*">
            </div>

            <button type="submit" name="tambah_barang" class="btn btn-primary">Tambah</button>
            <a href="tes.php" class="btn btn-secondary ml-2">Kembali</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>