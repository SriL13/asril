<?php
session_start();
include 'koneksi.php';

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Tambah barang ke keranjang
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $id_barang = $_GET['id'];

    // Periksa apakah barang sudah ada di keranjang
    if (isset($_SESSION['keranjang'][$id_barang])) {
        $_SESSION['keranjang'][$id_barang]++;
    } else {
        $_SESSION['keranjang'][$id_barang] = 1;
    }

    header("Location: keranjang.php");
    exit;
}

// Hapus barang dari keranjang
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $id_barang = $_GET['id'];
    unset($_SESSION['keranjang'][$id_barang]);

    header("Location: keranjang.php");
    exit;
}

// Tangani tombol tambah/kurang jumlah barang
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && isset($_POST['id_barang'])) {
    $id_barang = $_POST['id_barang'];

    if ($_POST['action'] == 'increase') {
        $_SESSION['keranjang'][$id_barang]++;
    } elseif ($_POST['action'] == 'decrease') {
        if ($_SESSION['keranjang'][$id_barang] > 1) {
            $_SESSION['keranjang'][$id_barang]--;
        } else {
            unset($_SESSION['keranjang'][$id_barang]); // Hapus jika jumlah menjadi 0
        }
    }

    header("Location: keranjang.php");
    exit;
}


// Ambil detail barang dari database
$keranjang = [];
if (!empty($_SESSION['keranjang'])) {
    $ids = implode(',', array_keys($_SESSION['keranjang']));
    $query = "SELECT id_barang, nama_barang, harga FROM barang WHERE id_barang IN ($ids)";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $row['jumlah'] = $_SESSION['keranjang'][$row['id_barang']];
        $keranjang[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f9ff;
            /* Soft pastel blue background */
        }

        .container {
            margin-top: 50px;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table th {
            background-color: #c6e7ff;
            /* Pastel blue header */
            color: #0056b3;
        }

        .table td {
            font-size: 14px;
        }

        .btn-custom {
            background-color: #66aaff;
            /* Pastel blue */
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #3388cc;
        }

        .btn-secondary {
            background-color: #b0c9d7;
            /* Light grayish blue */
            color: black;
        }

        .btn-secondary:hover {
            background-color: #8faebc;
            color: black;
        }

        .form-select,
        .form-control {
            font-size: 14px;
            border-radius: 0.375rem;
        }

        .form-label {
            font-weight: bold;
            color: #0056b3;
            /* Blue color for labels */
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-control,
        .form-select {
            border-radius: 5px;
        }

        .mb-3 {
            margin-bottom: 1.5rem !important;
        }

        .btn-success {
            background-color: #66bb6a;
            /* Green button for update */
            color: black;
            /* Set text color to black */
        }

        .btn-success:hover {
            background-color: #4cae4c;
        }

        .btn-primary {
            background-color: #66aaff;
            color: black;
            /* Set text color to black */
        }

        .btn-primary:hover {
            background-color: #3388cc;
        }

        /* Lighter Maroon Color */
        .btn-danger {
            background-color: #c21807;
            /* Lighter maroon button for 'Hapus' */
            color: white;
        }

        .btn-danger:hover {
            background-color: #b71c1c;
            /* Slightly darker maroon for hover effect */
        }

        h2 {
            color: #0056b3;
        }

        .card-body {
            background-color: #f6fbff;
            /* Light pastel blue background for the card */
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Keranjang Belanja</h2>
        <?php if (!empty($keranjang)): ?>
            <form method="post" action="keranjang.php">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($keranjang as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['nama_barang']); ?></td>
                                        <td>Rp<?= number_format($item['harga'], 0, ',', '.'); ?></td>
                                        <td>
                                            <form method="POST" action="keranjang.php">
                                                <input type="hidden" name="id_barang" value="<?= $item['id_barang']; ?>">
                                                <button type="submit" name="action" value="decrease" class="btn btn-sm btn-danger">-</button>
                                                <input type="number" class="form-control d-inline-block w-25" name="jumlah" value="<?= $item['jumlah']; ?>" min="1" style="text-align: center;">
                                                <button type="submit" name="action" value="increase" class="btn btn-sm btn-success">+</button>
                                            </form>
                                        </td>


                                        <td>Rp<?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></td>
                                        <td>
                                            <a href="keranjang.php?action=remove&id=<?= $item['id_barang']; ?>" class="btn btn-danger">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <a href="checkout.php" class="btn btn-primary">Lanjutkan ke Checkout</a>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <p>Keranjang Anda kosong.</p>
        <?php endif; ?>
        <a href="index.php" class="btn btn-secondary mt-3">Kembali ke Halaman Utama</a>
    </div>
</body>

</html>