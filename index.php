<?php
include 'koneksi.php';
session_start();

// Ambil data barang dari database
$query = "
SELECT
    barang.id_barang,
    distributor.nama_distributor,
    barang.nama_barang,
    barang.harga,
    barang.gambar
FROM barang
JOIN distributor ON barang.id_distributor = distributor.id_distributor
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kasir Azizilz - Daftar Barang</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Lobster&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #e1f5fe;
            font-family: 'Poppins', sans-serif;
            color: #0277bd;
            padding-top: 80px;
            margin: 0;
        }

        /* Navbar Style */
        .navbar {
            background-color: #81d4fa;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1 30px;
            /* Menambahkan padding horizontal agar navbar sedikit ke kanan */
        }

        .navbar .navbar-brand {
            font-family: 'Lobster', cursive;
            font-weight: 600;
            color: #01579b;
            font-size: 2.5rem;
            margin-right: 60px;
            /* Memberikan jarak antara "Toko Azizils" dan link berikutnya */
        }

        /* Menambahkan styling untuk navbar links */
        .navbar-nav {
            margin-left: auto;
            /* Menggeser navbar items ke kanan */

            /* Memberikan sedikit jarak antara navbar items dan tepi kanan */
        }

        .navbar-nav .nav-link {
            color: #01579b !important;
            font-weight: 500;
            font-size: 1.2rem;
            margin-left: 10px;
            /* Memberikan jarak antar link */
        }

        .navbar-nav .nav-link:hover {
            color: #0288d1;
            text-decoration: underline;
        }

        /* Style for Login Button */
        .navbar .nav-item .btn-primary {
            background-color: #01579b;
            border: none;
            font-weight: bold;
            border-radius: 20px;
            padding: 12px 24px;
            font-size: 1.2rem;
            transition: background-color 0.3s, transform 0.3s;
            margin-left: 5px;
            /* Memberikan jarak antara tombol dan link */
        }

        .navbar .nav-item .btn-primary:hover {
            background-color: #0288d1;
            transform: scale(1.05);
        }

        /* Style for Registrasi Button */
        .navbar .nav-item .btn-secondary {
            background-color: #0277bd;
            border: none;
            font-weight: bold;
            border-radius: 30px;
            padding: 12px 24px;
            font-size: 1.2rem;
            transition: background-color 0.3s, transform 0.3s;
            margin-left: 20px;
            /* Memberikan jarak antara tombol dan link */
        }

        .navbar .nav-item .btn-secondary:hover {
            background-color: #0288d1;
            transform: scale(1.05);
        }


        .navbar .nav-item button {
            margin-right: 10px;
            /* Tambahkan jarak antar tombol */
        }

        .hero {
            background-color: #b3e5fc;
            padding: 100px 0;
            text-align: center;
            border-bottom: 5px solid #0288d1;
        }

        .hero h1 {
            font-family: 'Lobster', cursive;
            font-size: 6rem;
            font-weight: 700;
            color: #01579b;
            margin-bottom: 30px;
        }

        .hero p {
            font-size: 1.5rem;
            font-weight: 300;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
            color: #01579b;
        }

        .hero .btn {
            margin-top: 20px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: transform 0.5s;
            margin-bottom: 30px;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #0056b3;
        }

        footer {
            background-color: #81d4fa;
            color: #01579b;
            padding: 20px 0;
            text-align: center;
            margin-top: 100px;
        }

        footer a {
            color: #01579b;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #0288d1;
        }

        h2 {
            color: #0056b3;
            font-weight: bold;
        }

        .text-center p {
            color: #555;
        }

        #about {
            margin-bottom: 150px;
            /* Tambahkan jarak lebih di bawah Tentang Kami */
            padding-top: 100px;
            /* Memberi sedikit padding di atas konten */
        }


        #about h2 {
            font-size: 2.5rem;
            /* Menambah ukuran font untuk judul */
            color: #0277bd;
            font-weight: 600;
            margin-bottom: 40px;
        }

        #about p {
            font-size: 1.2rem;
            /* Menambah ukuran font untuk deskripsi */
            color: #555;
            line-height: 1.5;
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
        }


        #barang {
            margin-top: 100px;
            /* Tambahkan jarak lebih di atas Daftar Menu */
        }



        #barang h2 {
            margin-bottom: 50px;
            /* Menambahkan jarak antara judul dan card */
        }

        footer {
            background-color: #81d4fa;
            color: #01579b;
            padding: 6px 0;
            text-align: center;
            margin-top: 80px;
            /* Menambahkan jarak antara bagian tentang kami dan footer */
        }

        .hero {
            background-color: #b3e5fc;
            padding: 180px 0;
            text-align: center;
            border-bottom: 5px solid #0288d1;
            position: relative;
            /* Make the hero section a positioning context for the icons */
            overflow: hidden;
        }

        .hero::before {
            content: "\f1b1";
            /* FontAwesome cupcake icon */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 6rem;
            color: rgba(255, 105, 180, 0.3);
            /* Pink color with some transparency */
            position: absolute;
            top: 10%;
            left: 10%;
            transform: translate(-50%, -50%);
        }

        .hero::after {
            content: "\f004";
            /* FontAwesome heart icon */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 4rem;
            color: rgba(255, 0, 0, 0.2);
            /* Red color with transparency */
            position: absolute;
            top: 40%;
            right: 20%;
            transform: translate(50%, -50%);
        }

        .hero h1 {
            font-family: 'Lobster', cursive;
            font-size: 6rem;
            font-weight: 700;
            color: #01579b;
            margin-bottom: 30px;
        }

        .hero p {
            font-size: 1.5rem;
            font-weight: 300;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
            color: #01579b;
        }

        .hero .btn {
            background: linear-gradient(135deg, #ffd54f, #ffcc80);
            /* Gradasi kuning pastel ke oranye pastel */
            border: none;
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 25px;
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.6);
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
        }

        .hero .btn:hover {
            background: linear-gradient(135deg, #ffcc80, #ffab40);
            /* Warna lebih cerah saat hover */
            box-shadow: 0 6px 15px rgba(255, 152, 0, 0.7);
            transform: scale(1.05);
        }

        .hero {
            background-color: #b3e5fc;
            padding: 180px 0;
            text-align: center;
            border-bottom: 5px solid #0288d1;
            position: relative;
            overflow: hidden;
        }

        .hero::before,
        .hero::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
        }

        /* Icon 1 - Cupcake */
        .hero::before {
            content: "\f1b1";
            /* FontAwesome cupcake icon */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 6rem;
            color: rgba(255, 105, 180, 0.3);
            /* Pink with transparency */
            position: absolute;
            top: 10%;
            left: 15%;
        }

        /* Icon 2 - Heart */
        .hero::after {
            content: "\f004";
            /* FontAwesome heart icon */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 5rem;
            color: rgba(255, 0, 0, 0.2);
            /* Red with transparency */
            position: absolute;
            top: 45%;
            right: 80%;
        }

        /* Add More Icons Using Additional Elements */
        .hero .background-icons {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .hero .background-icons i {
            position: absolute;
            font-size: 4rem;
            opacity: 0.2;
        }

        .hero .background-icons i.icon-1 {
            top: 20%;
            left: 30%;
            color: #ff9800;
            /* Orange */
            transform: rotate(15deg);
        }

        .hero .background-icons i.icon-2 {
            top: 50%;
            right: 20%;
            color: #ff5722;
            /* Deep Orange */
        }

        .hero .background-icons i.icon-3 {
            bottom: 10%;
            left: 10%;
            color: #8bc34a;
            /* Light Green */
            transform: rotate(-30deg);
        }

        .hero .background-icons i.icon-4 {
            bottom: 30%;
            right: 30%;
            color: #03a9f4;
            /* Light Blue */
            transform: scale(1.2);
        }

        .hero {
            background-color: #b3e5fc;
            padding: 180px 0;
            text-align: center;
            border-bottom: 5px solid #0288d1;
            position: relative;
            overflow: hidden;
        }

        .hero .background-icons {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .hero .background-icons i {
            position: absolute;
            font-size: 5rem;
            /* Ukuran lebih besar agar terlihat */
            opacity: 0.8;
            /* Lebih solid */
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
            /* Tambahkan bayangan */
            transition: transform 0.3s ease;
            /* Efek animasi saat scroll */
        }

        .hero .background-icons i:hover {
            transform: scale(1.2);
            /* Efek memperbesar saat hover */
        }

        /* Atur posisi dan warna untuk setiap ikon */
        .hero .background-icons i.icon-1 {
            top: 10%;
            left: 30%;
            color: #ff9800;
            /* Orange */
        }

        .hero .background-icons i.icon-2 {
            top: 50%;
            right: 20%;
            color: #e91e63;
            /* Pink */
        }

        .hero .background-icons i.icon-3 {
            bottom: 10%;
            left: 10%;
            color: #4caf50;
            /* Green */
        }

        .hero .background-icons i.icon-4 {
            bottom: 15%;
            right: 30%;
            color: #2196f3;
            /* Blue */
        }

        .hero .background-icons i.icon-5 {
            top: 10%;
            right: 15%;
            color: #ffeb3b;
            /* Yellow */
        }

        .hero {
            background: linear-gradient(135deg, #e0f7fa, #80d8ff);
            /* Gradasi biru pastel ke biru muda */
            padding: 180px 0;
            text-align: center;
            border-bottom: 5px solid #0288d1;
            position: relative;
            overflow: hidden;
        }

        .hero h1,
        .hero p,
        .hero .btn {
            position: relative;
            /* Supaya tidak terpengaruh elemen latar */
            z-index: 1;
            color: #01497c;
            /* Warna teks sedikit lebih gelap untuk kontras */
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0) 70%);
            z-index: 0;
            opacity: 0.6;
            /* Glow lebih jelas */
        }
    </style>
</head>

<!-- FontAwesome Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">


<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="b.png" alt="Logo" style="width: 50px; height: 50px; margin-right: 10px;"> Toko<span style="color: #0288d1;">Azizilz</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#barang">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tampilan_transaksi.php">Riwayat Pemesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminlog.php">Admin</a>
                    </li>
                    <!-- Cart Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="keranjang.php">
                            <i class="icon" data-feather="shopping-cart"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href=" register.php">Registrasi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="background-icons">
            <i class="fas fa-star icon-1"></i>
            <i class="fas fa-birthday-cake icon-2"></i>
            <i class="fas fa-coffee icon-3"></i>
            <i class="fas fa-cookie icon-4"></i>
            <i class="fas fa-ice-cream icon-5"></i> <!-- Tambahkan ikon es krim -->
        </div>
        <div class="container">
            <h1 data-aos="fade-up">Welcome to Toko Azizilz!</h1>
            <p data-aos="fade-up" data-aos-delay="200">Ngemil kue ini tuh kayak pelukan, hangat dan bkin senyum!</p>
            <p data-aos="fade-up" data-aos-delay="400">Makan kuenya nggak cukup sekali, efeknya bikin ketagihan parah!</p>
            <a href="#barang" class="btn btn-primary" data-aos="fade-up" data-aos-delay="600">Jelajahi Menu</a>
        </div>
    </section>

    <!-- About Us -->
    <section id="about" class="mt-5">
        <div class="container">
            <div class="card about-box p-4" style="border: 1px solid #81d4fa; border-radius: 10px; background-color: #e3f2fd; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <h2 class="text-center" data-aos="fade-down">Tentang Kami</h2>

                <!-- Kotak Card untuk About Us -->
                <p class="text-center" data-aos="fade-up" data-aos-delay="200">
                    "Kue Enak, Vibes Seru, Ya cuma di Toko Azizilz!" Toko Azizilz hadir dengan vibe yang gak cuma menyenangkan, tapi juga bikin kamu ketagihan. Setiap kue yang kami buat tuh bukan hanya tentang rasa, tapi tentang pengalaman. Kami tahu, kue yang enak bisa bikin momen lebih spesial. Makanya, di Toko Azizilz, kami terus berinovasi, supaya kamu bisa menikmati kue yang nggak hanya enak, tapi juga kekinian. Jadi, kalau kamu pengen ngerasain sensasi kue yang beda, wajib banget sih ke Toko Azizilz!
                </p>
            </div>
        </div>
        </div>
    </section>

    <!-- Daftar Barang -->
    <section id="barang">
        <div class="container mt-4">
            <h2 class="text-center" data-aos="fade-down">Daftar Menu</h2>
            <div class="row g-4">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="col-md-4 col-lg-3" data-aos="zoom-in">
                            <div class="card h-100">
                                <img src="data:image/jpeg;base64,<?= base64_encode($row['gambar']); ?>" alt="Gambar Barang" class="card-img-top">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= htmlspecialchars($row['nama_barang']); ?></h5>
                                    <p class="card-text">Harga: Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                                </div>
                                <div class="card-footer text-center">
                                    <?php if (isset($_SESSION['username'])): ?>
                                        <div class="d-flex justify-content-around">
                                            <a href="checkout.php?id=<?= $row['id_barang']; ?>&jumlah=1" class="btn btn-primary">Beli</a>
                                            <a href="keranjang.php?action=add&id=<?= $row['id_barang']; ?>" class="btn btn-success">
                                                <i class="icon" data-feather="shopping-cart"></i>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex justify-content-around">
                                            <a href="login.php" class="btn btn-primary">Beli</a>
                                            <a href="login.php" class="btn btn-success">
                                                <i class="icon" data-feather="shopping-cart"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center">Tidak ada data barang ditemukan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>






    <!-- Footer -->
    <footer>
        <div class="mb-3">
            <a href="https://www.instagram.com/rilsz_13/" class="me-3"><i class="icon" data-feather="instagram"></i></a>
        </div>
        <p>&copy; 2024 Kasir Azizilz</p>
    </footer>

    <!-- Feather Icons Initialization -->
    <script>
        feather.replace();
    </script>
    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php mysqli_close($conn); ?>