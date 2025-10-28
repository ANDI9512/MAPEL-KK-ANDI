<?php
session_start();

// Daftar akun
$users = [
    "admin" => ["password" => "123", "role" => "admin"],
    "operator" => ["password" => "123", "role" => "operator"],
    "guest" => ["password" => "123", "role" => "guest"]
];

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

    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $users[$username]['role'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Username/password salah!";
    }
}

$loggedIn = isset($_SESSION['username']);
$role = $_SESSION['role'] ?? 'guest';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Galeri Foto Pesona Kalimantan Utara</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .login-container { max-width: 400px; margin: 100px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
    .gallery-item { margin-bottom: 30px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: 0.3s; }
    .gallery-item:hover { transform: scale(1.03); }
    .gallery-item img { width: 100%; height: 250px; object-fit: cover; }
    .image-caption { padding: 15px; background: #fff; text-align: center; }
    footer { background: #454b52; color: white; padding: 20px; margin-top: 40px; }
  </style>
</head>
<body>

<?php if (!$loggedIn): ?>
  <!-- Form Login -->
  <div class="login-container">
    <h2 class="text-center mb-4">Login</h2>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="post" novalidate>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required />
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </div>

<?php else: ?>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="#">Galeri Foto</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
            <span class="nav-link text-white">
              Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>
            </span>
          </li>
          <li class="nav-item">
            <a href="?logout=true" class="btn btn-outline-light btn-sm ms-2">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Galeri -->
  <div class="container gallery-container">
    <h1 class="text-center my-4">* Galeri Pesona Kalimantan Utara *</h1>
    <div class="row">

      <!-- Foto 1 -->
      <div class="col-md-4 col-sm-6 col-12">
        <div class="gallery-item">
          <img src="GUNUNG-RIAN.jpg" alt="Air Terjun Gunung Rian" class="img-fluid" />
          <div class="image-caption">
            <h5>Air Terjun Gunung Rian</h5>
            <p class="text-muted">Air terjun dengan formasi batuan unik.</p>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-primary btn-sm" onclick="showImageModal('GUNUNG-RIAN.jpg', 'Air Terjun Gunung Rian')">Lihat</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto 2 -->
      <div class="col-md-4 col-sm-6 col-12">
        <div class="gallery-item">
          <img src="GUNUNG-KRYAAN.jpg" alt="Air Terjun Krayan" class="img-fluid" />
          <div class="image-caption">
            <h5>Air Terjun Krayan</h5>
            <p class="text-muted">Aliran deras di tengah alam yang masih perawan.</p>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-primary btn-sm" onclick="showImageModal('GUNUNG-KRYAAN.jpg', 'Air Terjun Krayan')">Lihat</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto 3 -->
      <div class="col-md-4 col-sm-6 col-12">
        <div class="gallery-item">
          <img src="BATU-MAPAN.jpg" alt="Batu Mapan" class="img-fluid" />
          <div class="image-caption">
            <h5>Batu Mapan</h5>
            <p class="text-muted">Sungai jernih mengalir di tengah hutan hijau alami.</p>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-primary btn-sm" onclick="showImageModal('BATU-MAPAN.jpg', 'Batu Mapan')">Lihat</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto 4 -->
      <div class="col-md-4 col-sm-6 col-12">
        <div class="gallery-item">
          <img src="GUNUNG-PUTIH.jpg" alt="Gunung Putih" class="img-fluid" />
          <div class="image-caption">
            <h5>Gunung Putih</h5>
            <p class="text-muted">Formasi kapur seperti pahatan di tengah hutan tropis.</p>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-primary btn-sm" onclick="showImageModal('GUNUNG-PUTIH.jpg', 'Gunung Putih')">Lihat</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto 5 -->
      <div class="col-md-4 col-sm-6 col-12">
        <div class="gallery-item">
          <img src="TANAH-KUNING.jpg" alt="Pantai Tanah Kuning" class="img-fluid" />
          <div class="image-caption">
            <h5>Pantai Tanah Kuning</h5>
            <p class="text-muted">Pantai dengan pasir putih lembut dan air laut jernih yang menenangkan.</p>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-primary btn-sm" onclick="showImageModal('TANAH-KUNING.jpg', 'Pantai Tanah Kuning')">Lihat</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Foto 6 -->
      <div class="col-md-4 col-sm-6 col-12">
        <div class="gallery-item">
          <img src="PANTAI-AMAL.jpg" alt="Pantai Amal" class="img-fluid" />
          <div class="image-caption">
            <h5>Pantai Amal</h5>
            <p class="text-muted">Panorama pantai dengan batu besar, laut jernih, dan pasir putih eksotis.</p>
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-primary btn-sm" onclick="showImageModal('PANTAI-AMAL.jpg', 'Pantai Amal')">Lihat</button>

              <?php if ($role === "admin" || $role === "operator"): ?>
                <button class="btn btn-warning btn-sm">Edit</button>
                <button class="btn btn-success btn-sm">Tambah</button>
              <?php endif; ?>

              <?php if ($role === "admin"): ?>
                <button class="btn btn-danger btn-sm">Hapus</button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container text-center">
      <p>2025 ANDI RIZKI FARAWANSYA. All Rights Reserved.</p>
    </div>
  </footer>

  <!-- MODAL ZOOM GAMBAR -->
  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">Judul Gambar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body text-center">
          <img id="modalImage" src="" alt="" class="img-fluid rounded">
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>

<!-- Script Bootstrap & Modal Logic -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function showImageModal(src, title) {
    document.getElementById("modalImage").src = src;
    document.getElementById("imageModalLabel").textContent = title;
    var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
  }
</script>
</body>
</html>
