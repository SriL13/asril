<?php
include "koneksi.php";
session_start();

// Periksa apakah sesi admin sudah ada
if (!isset($_SESSION['admins'])) {
    // Jika belum login sebagai admin, arahkan kembali ke halaman login admin
    header("Location: adminlog.php");
    exit;
}


// Hapus Barang
if (isset($_GET['hapus_barang']) && isset($_GET['hapus'])) {
    $id_barang = intval($_GET['hapus']); // Hindari SQL Injection
    $query_hapus_barang = "DELETE FROM barang WHERE id_barang = $id_barang";
    $result_hapus_barang = mysqli_query($conn, $query_hapus_barang);

    if ($result_hapus_barang) {
        header("Location: tes.php"); // Redirect setelah berhasil hapus
        exit();
    } else {
        echo "Error: " . mysqli_error($conn); // Debugging error
    }
}

// Hapus Distributor
if (isset($_GET['hapus_distributor']) && isset($_GET['hapus'])) {
    $id_distributor = intval($_GET['hapus']);
    $query_hapus_distributor = "DELETE FROM distributor WHERE id_distributor = $id_distributor";
    $result_hapus_distributor = mysqli_query($conn, $query_hapus_distributor);

    if ($result_hapus_distributor) {
        header("Location: tes.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Hapus Karyawan
if (isset($_GET['hapus_karyawan']) && isset($_GET['hapus'])) {
    $id_karyawan = intval($_GET['hapus']);
    $query_hapus_karyawan = "DELETE FROM karyawan WHERE id_karyawan = $id_karyawan";
    $result_hapus_karyawan = mysqli_query($conn, $query_hapus_karyawan);

    if ($result_hapus_karyawan) {
        header("Location: tes.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// Hapus Transaksi
if (isset($_GET['hapus_transaksi']) && isset($_GET['hapus'])) {
    $id_transaksi = intval($_GET['hapus']);
    $query_hapus_transaksi = "DELETE FROM transaksi WHERE id_transaksi = $id_transaksi";
    $result_hapus_transaksi = mysqli_query($conn, $query_hapus_transaksi);

    if ($result_hapus_transaksi) {
        header("Location: tes.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


// Query untuk data barang
$query_barang = "SELECT b.id_barang, d.nama_distributor, b.nama_barang, b.harga, b.gambar
FROM barang b
JOIN distributor d ON b.id_distributor = d.id_distributor";
$result_barang = mysqli_query($conn, $query_barang);
if (!$result_barang) {
    die("Query barang gagal: " . mysqli_error($conn));
}

// Query untuk data distributor
$query_distributor = "SELECT id_distributor, nama_distributor, alamat, no_telp, tanggal FROM distributor";
$result_distributor = mysqli_query($conn, $query_distributor);
if (!$result_distributor) {
    die("Query distributor gagal: " . mysqli_error($conn));
}

// Query untuk data karyawan
$query_karyawan = "SELECT id_karyawan, nama_karyawan, alamat, no_telp FROM karyawan";
$result_karyawan = mysqli_query($conn, $query_karyawan);
if (!$result_karyawan) {
    die("Query karyawan gagal: " . mysqli_error($conn));
}
// Query untuk data transaksi
$query_transaksi = "SELECT t.id_transaksi, b.nama_barang, t.jumlah, t.harga, t.tanggal, t.harga_total, k.nama_karyawan
FROM transaksi t
JOIN barang b ON t.id_barang = b.id_barang
JOIN karyawan k ON t.id_karyawan = k.id_karyawan";
$result_transaksi = mysqli_query($conn, $query_transaksi);
if (!$result_transaksi) {
    die("Query transaksi gagal: " . mysqli_error($conn));
}


// Query untuk menghitung jumlah barang
$query_jumlah_barang = "SELECT COUNT(*) AS jumlah_barang FROM barang";
$result_jumlah_barang = mysqli_query($conn, $query_jumlah_barang);
$jumlah_barang = mysqli_fetch_assoc($result_jumlah_barang)['jumlah_barang'];

// Query untuk menghitung jumlah distributor
$query_jumlah_distributor = "SELECT COUNT(*) AS jumlah_distributor FROM distributor";
$result_jumlah_distributor = mysqli_query($conn, $query_jumlah_distributor);
$jumlah_distributor = mysqli_fetch_assoc($result_jumlah_distributor)['jumlah_distributor'];

// Query untuk menghitung jumlah karyawan
$query_jumlah_karyawan = "SELECT COUNT(*) AS jumlah_karyawan FROM karyawan";
$result_jumlah_karyawan = mysqli_query($conn, $query_jumlah_karyawan);
$jumlah_karyawan = mysqli_fetch_assoc($result_jumlah_karyawan)['jumlah_karyawan'];

// Query untuk menghitung jumlah transaksi
$query_jumlah_transaksi = "SELECT COUNT(*) AS jumlah_transaksi FROM transaksi";
$result_jumlah_transaksi = mysqli_query($conn, $query_jumlah_transaksi);
$jumlah_transaksi = mysqli_fetch_assoc($result_jumlah_transaksi)['jumlah_transaksi'];
?>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(255, 255, 255);
        }

        .sidebar {
            height: 100vh;
            background-color: #a3d5f7;
            padding: 20px;
            color: #000000;
            position: fixed;
            width: 250px;
        }

        .sidebar h4 {
            color: #000000;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 2px solid #81c3f0;
            padding-bottom: 10px;
        }

        .sidebar a {
            color: #000000;
            text-decoration: none;
            display: block;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #81c3f0;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
        }

        .sidebar .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .sidebar h4 {
            display: flex;
            align-items: center;
        }

        .card {
            border: none;
            border-radius: 10px;
            background-color: #a3d5f7;
            color: #000000;
        }

        .card-header {
            background-color: #81c3f0;
            color: #000000;
            font-weight: bold;
        }

        .card-body {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        th {
            background-color: #a3d5f7 !important;
            color: #000000 !important;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .content {
                margin-left: 0;
                padding: 10px;
            }

            .hamburger-menu {
                display: block;
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 1000;
            }
        }

        @media (min-width: 769px) {
            .hamburger-menu {
                display: none;
            }
        }

        .table-responsive {
            overflow-x: auto;
        }

        .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Hamburger Menu -->
    <button class="btn btn-primary hamburger-menu" onclick="toggleSidebar()">☰</button>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>
            <img src="a.jpeg" alt="Logo" class="logo"> Admin kasir
        </h4>
        <a href="tambah_karyawan.php">Tambah Karyawan</a>
        <a href="tambah_barang.php">Tambah Barang</a>
        <a href="tambah_distributor.php">Tambah Distributor</a>
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>



    <!-- Konten Utama -->
    <br>
    <br>


    <div class="content">
        <div class="container-fluid">

            <!-- Cards -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-header">Jumlah Barang</div>
                        <div class="card-body"><?= $jumlah_barang; ?></div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-header">Jumlah Karyawan</div>
                        <div class="card-body"><?= $jumlah_karyawan; ?></div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-header">Jumlah Distributor</div>
                        <div class="card-body"><?= $jumlah_distributor; ?></div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-header">Jumlah Transaksi</div>
                        <div class="card-body"><?= $jumlah_transaksi; ?></div>
                    </div>
                </div>
            </div>
            <br>
            <!-- Tabel Barang -->
            <h5 style="color: black; font-weight: bold;">Data Barang</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" style="margin-bottom: 20px;">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Distributor</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result_barang) > 0): ?>
                            <?php $no = 1;
                            while ($row = mysqli_fetch_assoc($result_barang)): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nama_distributor']); ?></td>
                                    <td><?= htmlspecialchars($row['nama_barang']); ?></td>
                                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if ($row['gambar']): ?>
                                            <img src="data:image/jpeg;base64,<?= base64_encode($row['gambar']); ?>" alt="Gambar Barang" width="100">
                                        <?php else: ?>
                                            Tidak Ada Gambar
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="edit_barang.php?id=<?= $row['id_barang']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="?hapus=<?= $row['id_barang']; ?>&hapus_barang=true" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center;">Tidak ada data barang.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <br>
                <br>
                <br>
                <br>
                <hr>
                <br>

                <!-- Tabel Distributor -->
                <h5 style="color: black; font-weight: bold;">Data Distributor</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" style="margin-bottom: 20px;">
                        <thead>
                            <tr>
                                <th>ID Distributor</th>
                                <th>Nama Distributor</th>
                                <th>Alamat</th>
                                <th>No. Telepon</th>
                                <th>Tanggal Bergabung</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result_distributor) > 0): ?>
                                <?php while ($d = mysqli_fetch_assoc($result_distributor)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($d['id_distributor']); ?></td>
                                        <td><?= htmlspecialchars($d['nama_distributor']); ?></td>
                                        <td><?= htmlspecialchars($d['alamat']); ?></td>
                                        <td><?= htmlspecialchars($d['no_telp']); ?></td>
                                        <td><?= htmlspecialchars($d['tanggal']); ?></td>
                                        <td>
                                            <a href="edit_distributor.php?id=<?= $d['id_distributor']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="?hapus=<?= $d['id_distributor']; ?>&hapus_distributor=true" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus distributor ini?');">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;">Tidak ada data distributor ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <br>
                    <br>
                    <hr>
                    <br>

                    <!-- Tabel Transaksi -->
                    <h5 style="color: black; font-weight: bold;">Data Transaksi</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="margin-bottom: 20px;">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Tanggal</th>
                                    <th>Harga Total</th>
                                    <th>Nama Karyawan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result_transaksi) > 0): ?>
                                    <?php $no = 1;
                                    while ($k = mysqli_fetch_assoc($result_transaksi)): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($k['nama_barang']); ?></td>
                                            <td><?= htmlspecialchars($k['jumlah']); ?></td>
                                            <td>Rp <?= number_format($k['harga'], 0, ',', '.'); ?></td>
                                            <td><?= htmlspecialchars($k['tanggal']); ?></td>
                                            <td>Rp <?= number_format($k['harga_total'], 0, ',', '.'); ?></td>
                                            <td><?= htmlspecialchars($k['nama_karyawan']); ?></td>
                                            <td>
                                                <a href="edit_transaksi.php?id=<?= $k['id_transaksi']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="?hapus=<?= $k['id_transaksi']; ?>&hapus_transaksi=true" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus transaksi ini?');">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center;">Tidak ada data transaksi.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <br>
                        <br>
                        <hr>
                        <br>

                        <!-- Tabel Karyawan -->
                        <h5 style="color: black; font-weight: bold;">Data Karyawan</h5>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID Karyawan</th>
                                    <th>Nama Karyawan</th>
                                    <th>Alamat</th>
                                    <th>No. Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result_karyawan) > 0): ?>
                                    <?php while ($k = mysqli_fetch_assoc($result_karyawan)): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($k['id_karyawan']); ?></td>
                                            <td><?= htmlspecialchars($k['nama_karyawan']); ?></td>
                                            <td><?= htmlspecialchars($k['alamat']); ?></td>
                                            <td><?= htmlspecialchars($k['no_telp']); ?></td>
                                            <td>
                                                <a href="edit_karyawan.php?id=<?= $k['id_karyawan']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="?hapus=<?= $k['id_karyawan']; ?>&hapus_karyawan=true" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus karyawan ini?');">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center;">Tidak ada data karyawan ditemukan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <br>
                        <br>


                    </div>


                </div>
            </div>

            <!-- Script untuk Bootstrap -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                function toggleSidebar() {
                    const sidebar = document.getElementById('sidebar');
                    sidebar.classList.toggle('show');
                }
            </script>
</body>

</html>