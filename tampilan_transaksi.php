<?php
include "koneksi.php";
session_start();

// Periksa sesi login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['hapus_id'])) {
    $id_transaksi = $_GET['hapus_id'];

    // Query untuk menghapus transaksi menggunakan prepared statement untuk keamanan
    $query_hapus = $conn->prepare("DELETE FROM transaksi WHERE id_transaksi = ?");
    $query_hapus->bind_param("i", $id_transaksi); // 'i' untuk integer
    if ($query_hapus->execute()) {
        header("Location: tampilan_transaksi.php?delete_success=1");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus data: " . $conn->error . "');</script>";
    }
}

// Ambil data transaksi dan metode pembayaran dari database
$query_transaksi = "SELECT t.id_transaksi, b.nama_barang, t.jumlah, t.harga, t.tanggal, t.harga_total, t.metode_pembayaran
                    FROM transaksi t 
                    JOIN barang b ON t.id_barang = b.id_barang
                    ORDER BY t.tanggal DESC";

$result_transaksi = mysqli_query($conn, $query_transaksi);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f9ff;
            /* Pastel Blue Background */
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .card {
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background-color: #f6fbff;
            /* Light pastel blue for card */
        }

        .table th {
            background-color: #80c7ff;
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: #e1efff;
            /* Light hover effect */
        }

        .btn-primary {
            background-color: #66aaff;
            /* Pastel blue for buttons */
            color: white;
        }

        .btn-primary:hover {
            background-color: #3388cc;
            /* Slightly darker blue on hover */
        }

        .btn-success {
            background-color: #66bb6a;
            /* Green button for 'Cetak' */
            color: black;
        }

        .btn-success:hover {
            background-color: #4cae4c;
        }

        .btn-danger {
            background-color: #c21807;
            /* Lighter Maroon for delete button */
            color: white;
        }

        .btn-danger:hover {
            background-color: #b71c1c;
            /* Darker maroon for hover effect */
        }

        .btn-primary {
            background-color: #4a90e2;
            /* Slightly darker blue */
        }

        .btn-primary:hover {
            background-color: #357ab7;
            /* Darker blue on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <h3 class="text-center mb-4">Daftar Transaksi</h3>

            <!-- Back Button -->
            <div class="mb-4">
                <a href="index.php" class="btn btn-primary">Kembali ke Menu</a>
            </div>

            <?php if (mysqli_num_rows($result_transaksi) > 0): ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            <th>Tanggal</th>
                            <th>Metode Pembayaran</th> <!-- Kolom baru untuk metode pembayaran -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result_transaksi)): ?>
                            <tr>
                                <td><?= $row['id_transaksi']; ?></td>
                                <td><?= htmlspecialchars($row['nama_barang']); ?></td>
                                <td><?= $row['jumlah']; ?></td>
                                <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td>Rp<?= number_format($row['harga_total'], 0, ',', '.'); ?></td>
                                <td><?= $row['tanggal']; ?></td>
                                <td><?= htmlspecialchars($row['metode_pembayaran']); ?></td> <!-- Menampilkan metode pembayaran -->
                                <td>
                                    <a href="cetak_transaksi.php?id=<?= $row['id_transaksi']; ?>" class="btn btn-success btn-sm">Cetak</a>
                                    <a href="tampilan_transaksi.php?hapus_id=<?= $row['id_transaksi']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Belum ada transaksi yang dilakukan.</p>
            <?php endif; ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>