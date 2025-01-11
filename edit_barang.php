<?php
// Menghubungkan ke database
include 'koneksi.php';

// Ambil ID Barang dari URL
$id_barang = $_GET['id'] ?? null;

// Jika ID Barang tidak ada, redirect ke halaman tampil_barang
if (!$id_barang) {
    header("Location: tampil_barang.php");
    exit;
}

// Ambil data barang berdasarkan ID
$query = "SELECT * FROM barang WHERE id_barang = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_barang);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$barang = mysqli_fetch_assoc($result);

// Jika data barang tidak ditemukan, redirect ke halaman tampil_barang
if (!$barang) {
    header("Location: tampil_barang.php");
    exit;
}

// Ambil daftar distributor
$distributorQuery = "SELECT id_distributor, nama_distributor FROM distributor";
$distributors = mysqli_query($conn, $distributorQuery);

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_distributor = $_POST['id_distributor'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];

    // Cek apakah ada gambar baru yang diunggah
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar = file_get_contents($_FILES['gambar']['tmp_name']);
        $updateQuery = "UPDATE barang SET id_distributor = ?, nama_barang = ?, harga = ?, gambar = ? WHERE id_barang = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, "isisi", $id_distributor, $nama_barang, $harga, $gambar, $id_barang);
    } else {
        $updateQuery = "UPDATE barang SET id_distributor = ?, nama_barang = ?, harga = ? WHERE id_barang = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, "isii", $id_distributor, $nama_barang, $harga, $id_barang);
    }

    // Eksekusi query update
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Barang berhasil diupdate!'); window.location.href='tes.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
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
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .form-control:focus {
            box-shadow: 0 0 5px rgba(78, 154, 232, 0.5); /* Light blue glow on focus */
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
            border-color: #777777;
            padding: 10px 24px;
            border-radius: 10px;
            width: 100%;
            text-align: center;
        }

        .btn-secondary:hover {
            background-color: #555555; /* Darker gray on hover */
            border-color: #555555;
        }

        /* Center the "Kembali" button */
        .btn-container {
            display: flex;
            justify-content: center;
            margin-top: 12px;
        }

        .image-preview {
            margin-top: 10px;
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .mt-2 {
            margin-top: 10px;
        }

        .form-group label {
            font-weight: 600;
            color: #5f9ea0;
        }

        .form-group select {
            background-color: #f0f8ff;
        }

        .form-group input[type="file"] {
            padding: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Barang</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="id_distributor">Distributor:</label>
                <select class="form-control" id="id_distributor" name="id_distributor" required>
                    <?php while ($row = mysqli_fetch_assoc($distributors)): ?>
                        <option value="<?= $row['id_distributor']; ?>"
                            <?= $row['id_distributor'] == $barang['id_distributor'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($row['nama_distributor']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                    value="<?= htmlspecialchars($barang['nama_barang']); ?>" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" class="form-control" id="harga" name="harga"
                    value="<?= htmlspecialchars($barang['harga']); ?>" required>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar (Opsional):</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                <?php if ($barang['gambar']): ?>
                    <div class="mt-2">
                        <p>Gambar Saat Ini:</p>
                        <img class="image-preview" src="data:image/jpeg;base64,<?= base64_encode($barang['gambar']); ?>" alt="Gambar Barang">
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Update Barang</button>
        </form>

        <!-- Center the "Kembali" button -->
        <div class="btn-container">
            <a href="tes.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <!-- Bootstrap JS dan dependensi -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
