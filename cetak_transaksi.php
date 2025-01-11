<?php
include "koneksi.php";
session_start();

// Periksa apakah ada ID transaksi yang diterima
if (!isset($_GET['id'])) {
    echo "Transaksi tidak ditemukan!";
    exit;
}

$id_transaksi = $_GET['id'];

// Ambil data transaksi berdasarkan ID
$query = "SELECT t.id_transaksi, b.nama_barang, t.jumlah, t.harga, t.tanggal, t.harga_total
          FROM transaksi t 
          JOIN barang b ON t.id_barang = b.id_barang
          WHERE t.id_transaksi = '$id_transaksi'";

$result = mysqli_query($conn, $query);
$transaksi = mysqli_fetch_assoc($result);

if (!$transaksi) {
    echo "Transaksi tidak ditemukan!";
    exit;
}

// Mulai cetak
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Transaksi</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e3f2fd;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 700px;
            width: 100%;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px 40px;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            font-size: 2rem;
            color: #1565c0;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 0.9rem;
            color: #555;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            padding: 10px 15px;
            text-align: left;
        }

        .table th {
            background-color: #bbdefb;
            color: #1565c0;
            font-weight: 600;
            border-bottom: 2px solid #90caf9;
        }

        .table tr:nth-child(odd) {
            background-color: #f1f8ff;
        }

        .table tr:nth-child(even) {
            background-color: #ffffff;
        }

        /* Buttons */
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            text-transform: uppercase;
            font-size: 0.9rem;
            font-weight: bold;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #42a5f5;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #1e88e5;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background-color: #90caf9;
            color: #1565c0;
        }

        .btn-secondary:hover {
            background-color: #64b5f6;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn:focus {
            outline: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Detail Transaksi</h2>
        <table class="table">
            <tr>
                <th>ID Transaksi</th>
                <td><?= $transaksi['id_transaksi']; ?></td>
            </tr>
            <tr>
                <th>Nama Barang</th>
                <td><?= htmlspecialchars($transaksi['nama_barang']); ?></td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td><?= $transaksi['jumlah']; ?></td>
            </tr>
            <tr>
                <th>Harga Satuan</th>
                <td>Rp<?= number_format($transaksi['harga'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th>Total Harga</th>
                <td>Rp<?= number_format($transaksi['harga_total'], 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td><?= $transaksi['tanggal']; ?></td>
            </tr>
        </table>
        <div class="btn-container">
            <a href="tampilan_transaksi.php" class="btn btn-primary">🔙 Kembali</a>
            <button onclick="window.print()" class="btn btn-secondary">🖨️ Print</button>
        </div>
    </div>
</body>

</html>