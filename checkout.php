<?php
session_start();
include 'koneksi.php';

// Proses perubahan jumlah barang di keranjang
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && isset($_POST['id_barang'])) {
    $id_barang = $_POST['id_barang'];
    $action = $_POST['action'];
    $jumlah = $_POST['jumlah'];

    // Pastikan jumlah tidak kurang dari 1
    if ($action == 'increase') {
        $jumlah++;
    } elseif ($action == 'decrease' && $jumlah > 1) {
        $jumlah--;
    }

    // Update jumlah barang di keranjang
    $_SESSION['keranjang'][$id_barang] = $jumlah;

    // Redirect kembali ke halaman checkout setelah perubahan
    header("Location: checkout.php");
    exit;
}

// Periksa apakah ada parameter id_barang dan jumlah
if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];
    $jumlah = isset($_GET['jumlah']) ? $_GET['jumlah'] : 1; // Menambahkan default jumlah = 1

    // Ambil data barang berdasarkan id
    $query = "SELECT id_barang, nama_barang, harga FROM barang WHERE id_barang = '$id_barang'";
    $result = mysqli_query($conn, $query);
    $barang = mysqli_fetch_assoc($result);

    // Jika barang ditemukan, tambahkan ke keranjang
    if ($barang) {
        $_SESSION['keranjang'][$id_barang] = $jumlah;
        echo "<script>alert('Barang berhasil ditambahkan ke keranjang!'); window.location='checkout.php';</script>";
    } else {
        echo "<script>alert('Barang tidak ditemukan!'); window.location='index.php';</script>";
    }
}

// Ambil data keranjang untuk ditampilkan
$keranjang = [];
if (!empty($_SESSION['keranjang'])) {
    $ids = implode(',', array_keys($_SESSION['keranjang']));
    $query_barang = "SELECT id_barang, nama_barang, harga FROM barang WHERE id_barang IN ($ids)";
    $result_barang = mysqli_query($conn, $query_barang);

    while ($row = mysqli_fetch_assoc($result_barang)) {
        $row['jumlah'] = $_SESSION['keranjang'][$row['id_barang']];
        $row['total'] = $row['harga'] * $row['jumlah'];
        $keranjang[] = $row;
    }
}

// Proses checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'checkout') {
    $tanggal = $_POST['tanggal'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    if (empty($tanggal) || empty($metode_pembayaran)) {
        echo "<script>alert('Semua data harus diisi!'); window.location='checkout.php';</script>";
        exit;
    }

    // Simpan transaksi
    foreach ($keranjang as $item) {
        $id_barang = $item['id_barang'];
        $jumlah = $item['jumlah'];
        $harga_satuan = $item['harga'];
        $total_harga = $item['total'];

        $query_insert = "INSERT INTO transaksi (id_barang, jumlah, harga, tanggal, harga_total, metode_pembayaran) 
                         VALUES ('$id_barang', '$jumlah', '$harga_satuan', '$tanggal', '$total_harga', '$metode_pembayaran')";

        if (!mysqli_query($conn, $query_insert)) {
            echo "Error: " . mysqli_error($conn);
            exit;
        }
    }

    // Hapus keranjang setelah transaksi selesai
    unset($_SESSION['keranjang']);

    echo "<script>alert('Checkout berhasil!'); window.location='tampilan_transaksi.php';</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f9ff;
            /* Soft pastel blue background */
        }

        .container {
            margin-top: 40px;
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
        }

        .btn-secondary:hover {
            background-color: #8faebc;
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

        /* Update button text color to black */
        .btn-custom,
        .btn-secondary {
            color: black;
            /* Set text color to black */
        }

        .btn-custom:hover,
        .btn-secondary:hover {
            color: black;
            /* Ensure text remains black on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <h3 class="text-center mb-4">Checkout</h3>
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($keranjang as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['nama_barang']); ?></td>
                                <td>Rp<?= number_format($item['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <form method="POST" action="checkout.php">
                                        <input type="hidden" name="id_barang" value="<?= $item['id_barang']; ?>">
                                        <button type="submit" name="action" value="decrease" class="btn btn-sm btn-danger">-</button>
                                        <input type="number" class="form-control d-inline-block w-25" name="jumlah" value="<?= $item['jumlah']; ?>" min="1" style="text-align: center;">
                                        <button type="submit" name="action" value="increase" class="btn btn-sm btn-success">+</button>
                                    </form>
                                </td>
                                <td>Rp<?= number_format($item['total'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Form untuk checkout -->
                <form method="POST" action="checkout.php">
                    <input type="hidden" name="action" value="checkout">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>

                    <div class="mb-3">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                            <option value="" selected>Pilih Metode Pembayaran</option>
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                        </select>
                    </div>
                    <div id="form-transfer-bank" style="display: none;">
                        <div class="mb-3">
                            <label for="nama_bank" class="form-label">Nama Bank</label>
                            <input type="text" class="form-control" id="nama_bank" name="nama_bank">
                        </div>
                        <div class="mb-3">
                            <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                            <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening">
                        </div>
                        <div class="mb-3">
                            <label for="nama_pemilik" class="form-label">Nama Pemilik Rekening</label>
                            <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-custom">Selesaikan Checkout</button>
                </form>

                <!-- Tombol Back ke Halaman Utama -->
                <a href="index.php" class="btn btn-secondary mt-3 w-100">Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('metode_pembayaran').addEventListener('change', function() {
            const formTransferBank = document.getElementById('form-transfer-bank');
            if (this.value === 'Transfer Bank') {
                formTransferBank.style.display = 'block';
            } else {
                formTransferBank.style.display = 'none';
            }
        });
    </script>
</body>

</html>

<?php mysqli_close($conn); ?>