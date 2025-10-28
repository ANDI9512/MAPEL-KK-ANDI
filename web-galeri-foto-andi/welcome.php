<?php
session_start();

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === '1111' && $password === '123') {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Username/password salah!";
    }
}

$loggedIn = isset($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Galeri Foto Pesona Kalimantan Utara</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-container {
      max-width: 400px;
      margin: 100px auto;
      padding: 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .gallery-container {
      padding: 20px 0;
    }

    .gallery-title {
      text-align: center;
      margin: 30px 0;
      color: #303d43;
    }

    .gallery-item {
      margin-bottom: 30px;
      overflow: hidden;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }

    .gallery-item:hover {
      transform: scale(1.03);
    }

    .gallery-item img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      transition: opacity 0.3s ease;
    }

    .gallery-item:hover img {
      opacity: 0.9;
    }

    .image-caption {
      padding: 15px;
      background-color: white;
      text-align: center;
    }

    footer {
      background-color: #454b52;
      color: white;
      padding: 20px 0;
      margin-top: 40px;
    }
  </style>
</head>
<body>

<?php if (!$loggedIn): ?>
  <!-- Login Form -->
  <div class="login-container">
    <h2 class="text-center mb-4">Login</h2>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </div>

<?php else: ?>
  <!-- Dashboard / Galeri -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Galeri Foto</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Menu kiri -->
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="#">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Tentang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Kontak</a>
        </li>
      </ul>

      <!-- Kanan: Selamat datang + Logout -->
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <span class="nav-link text-white">Selamat datang, <strong><?php echo $_SESSION['username']; ?></strong></span>
        </li>
        <li class="nav-item">
          <a href="?logout=true" class="btn btn-outline-light btn-sm ms-2">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


  <div class="container gallery-container">
    <h1 class="gallery-title">* Galeri Pesona Kalimantan Utara *</h1>
    <div class="row">

      <!-- Foto 1 -->
      <div class="col-md-4 col-sm-6 col-12">
        <div class="gallery-item">
          <img src="GUNUNG-RIAN.jpg" alt="Air Terjun Gunung Rian" class="img-fluid">
          <div class="image-caption">
            <h5>Air Terjun Gunung Rian<br>(Kec. Sesayap, Kab. Tana Tidung)</h5>
            <p class="text-muted">Air terjun dengan formasi batuan unik dan air yang jernih.</p>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-primary btn-sm">Lihat</button>
              <button class="btn btn-success btn-sm">Tambah</button>
              <button class="btn btn-warning btn-sm text-white">Edit</button>
              <button class="btn btn-danger btn-sm">Hapus</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto 2 -->
      <div class="col-md-4 col-sm-6 col-12">
        <div class="gallery-item">
          <img src="GUNUNG-KRYAAN.jpg" alt="Air Terjun Krayan" class="img-fluid">
          <div class="image-caption">
            <h5>Air Terjun Krayan<br>(Pa Kemut, Krayan, Kab. Nunukan)</h5>
            <p class="text-muted">Aliran deras di tengah alam yang masih perawan.</p>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-primary btn-sm">Lihat</button>
              <button class="btn btn-success btn-sm">Tambah</button>
              <button class="btn btn-warning btn-sm text-white">Edit</button>
              <button class="btn btn-danger btn-sm">Hapus</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto 3 -->
      <div class="col-md-4 col-sm-6 col-12">
        <div class="gallery-item">
          <img src="BATU-MAPAN.jpg" alt="Batu Mapan" class="img-fluid">
          <div class="image-caption">
            <h5>Batu Mapan<br>(Mamburungan, Kec. Tarakan Timur)</h5>
            <p class="text-muted">Sungai jernih mengalir di tengah hutan hijau alami.</p>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-primary btn-sm">Lihat</button>
              <button class="btn btn-success btn-sm">Tambah</button>
              <button class="btn btn-warning btn-sm text-white">Edit</button>
              <button class="btn btn-danger btn-sm">Hapus</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto 4 -->
      <div class="col-md-4 col-sm-6 col-12">
        <div class="gallery-item">
          <img src="GUNUNG-PUTIH.jpg" alt="Gunung Putih" class="img-fluid">
          <div class="image-caption">
            <h5>Gunung Putih<br>(Tj. Palas Tengah, Kab. Bulungan)</h5>
            <p class="text-muted">Formasi kapur seperti pahatan di tengah hutan tropis.</p>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-primary btn-sm">Lihat</button>
              <button class="btn btn-success btn-sm">Tambah</button>
              <button class="btn btn-warning btn-sm text-white">Edit</button>
              <button class="btn btn-danger btn-sm">Hapus</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto 5 -->
      <div class="col-md-4 col-sm-6 col-12">
        <div class="gallery-item">
          <img src="TANAH-KUNING.jpg" alt="Pantai Tanah Kuning" class="img-fluid">
          <div class="image-caption">
            <h5>Pantai Tanah Kuning<br>(Kec. Tj. Palas Timur, Kab. Bulungan)</h5>
            <
            <p class="text-muted">Pantai dengan pasir putih lembut dan air laut jernih yang menenangkan.</p>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-primary btn-sm">Lihat</button>
              <button class="btn btn-success btn-sm">Tambah</button>
              <button class="btn btn-warning btn-sm text-white">Edit</button>
              <button class="btn btn-danger btn-sm">Hapus</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto 6 -->
      <div class="col-md-4 col-sm-6 col-12">
        <div class="gallery-item">
          <img src="PANTAI-AMAL.jpg" alt="Pantai Amal" class="img-fluid">
          <div class="image-caption">
            <h5>Pantai Amal<br>(Tanjung Karang, Kota Tarakan)</h5>
            <p class="text-muted">Panorama pantai dengan batu besar, laut jernih, dan pasir putih eksotis.</p>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-primary btn-sm">Lihat</button>
              <button class="btn btn-success btn-sm">Tambah</button>
              <button class="btn btn-warning btn-sm text-white">Edit</button>
              <button class="btn btn-danger btn-sm">Hapus</button>
            </div>
          </div>
        </div>
      </div>

    </div> <!-- /.row -->
  </div> <!-- /.gallery-container -->

  <!-- Footer -->
  <footer>
    <div class="container text-center">
      <p>2025 ANDI RIZKI FARAWANSYA. All Rights Reserved.</p>
    </div>
  </footer>

<?php endif; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
