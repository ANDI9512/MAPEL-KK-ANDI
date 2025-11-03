<?php
session_start();
include '../koneksi.php'; // pastikan koneksi.php berada di folder induk
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galeri Pesona Kalimantan Utara</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #dce6f5;
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .gallery-title {
      text-align: center;
      margin: 40px 0;
      color: #1e3a5f;
      font-weight: 700;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
      animation: fadeIn 1s ease-in-out;
    }
    .btn-tambah {
      display: block;
      margin: 0 auto 30px;
      padding: 10px 25px;
      font-weight: 600;
    }
    .btn-tambah:hover {
      transform: scale(1.05);
      box-shadow: 0 5px 10px rgba(0,0,0,0.3);
    }
    .gallery-item {
      border-radius: 15px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      transition: transform 0.4s ease, box-shadow 0.4s ease;
      animation: fadeIn 0.8s ease-in-out;
    }
    .gallery-item:hover {
      transform: scale(1.03);
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
    .gallery-item img {
      width: 100%;
      height: 230px;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    .gallery-item:hover img {
      transform: scale(1.08);
    }
    .image-caption {
      padding: 15px;
      text-align: center;
      background: #ffffff;
    }
    .image-caption h5 {
      margin: 5px 0;
      font-weight: 600;
      color: #000;
    }
    .image-caption p {
      color: #6c757d;
      font-size: 14px;
      margin-bottom: 10px;
    }
    .btn-warna a, .btn-warna button {
      margin: 0 3px;
      border: none;
      color: white;
      border-radius: 5px;
      padding: 5px 10px;
      font-size: 13px;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.3s, transform 0.3s;
    }
    .btn-warna .lihat { background-color: #0d6efd; }
    .btn-warna .lihat:hover { background-color: #0056b3; transform: scale(1.1); }
    .btn-warna .edit { background-color: #f0ad4e; }
    .btn-warna .edit:hover { background-color: #ec971f; transform: scale(1.1); }
    .btn-warna .hapus { background-color: #dc3545; }
    .btn-warna .hapus:hover { background-color: #a71d2a; transform: scale(1.1); }
    footer {
      background: #343a40;
      color: #fff;
      text-align: center;
      padding: 15px 0;
      margin-top: 60px;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">Galeri Foto</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Tentang</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Kontak</a></li>
        </ul>
        <span class="navbar-text text-white me-3">
          Selamat datang, <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? $_SESSION['username'] ?? 'Tamu') ?>!
        </span>
        <a href="../logout.php" class="btn btn-outline-light">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Konten Galeri -->
  <div class="container my-4">
    <h1 class="gallery-title">GALERI PESONA KALIMANTAN UTARA</h1>
    <button type="button" class="btn btn-success btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah">
      + Tambah Foto
    </button>

    <div class="row justify-content-center">
      <?php
      $result = mysqli_query($conn, "SELECT * FROM foto ORDER BY id_foto DESC");
      if (mysqli_num_rows($result) == 0) {
          echo '<div class="text-center text-muted mt-3">Belum ada foto yang ditambahkan.</div>';
      } else {
          while ($row = mysqli_fetch_assoc($result)) {
              $id = $row['id_foto'];
      ?>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="gallery-item">
          <img src="../img/<?= htmlspecialchars($row['lokasi_file']) ?>" alt="<?= htmlspecialchars($row['judul_foto']) ?>" class="img-fluid rounded">
          <div class="image-caption mt-2">
            <h5><?= htmlspecialchars($row['judul_foto']) ?></h5>
            <p><?= htmlspecialchars($row['lokasi_foto']) ?></p>
            <div class="btn-warna">
              <a href="../img/<?= htmlspecialchars($row['lokasi_file']) ?>" target="_blank" class="btn btn-sm lihat">Lihat</a>
              <button class="btn btn-sm edit" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $id ?>">Edit</button>
              <a href="../proses/hapus_foto.php?id=<?= $id ?>" class="btn btn-sm hapus" onclick="return confirm('Yakin ingin menghapus foto ini?')">Hapus</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Edit -->
      <div class="modal fade" id="modalEdit<?= $id ?>" tabindex="-1" aria-labelledby="modalEditLabel<?= $id ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form action="../proses/edit_foto.php" method="POST" enctype="multipart/form-data">
              <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel<?= $id ?>">Edit Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id_foto" value="<?= $id ?>">
                <div class="text-center mb-3">
                  <label class="form-label fw-bold d-block">Foto Saat Ini:</label>
                  <img src="../img/<?= htmlspecialchars($row['lokasi_file']) ?>" alt="<?= htmlspecialchars($row['judul_foto']) ?>" class="img-thumbnail rounded shadow-sm" style="max-height: 180px; object-fit: cover;">
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Judul Foto</label>
                  <input type="text" class="form-control" name="judul_foto" value="<?= htmlspecialchars($row['judul_foto']) ?>" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Lokasi</label>
                  <input type="text" class="form-control" name="lokasi_foto" value="<?= htmlspecialchars($row['lokasi_foto']) ?>" required>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">Ganti Foto (opsional)</label>
                  <input type="file" class="form-control" name="file_foto" accept="image/*">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php
          }
      }
      ?>
    </div>
  </div>

  <!-- Modal Tambah Foto -->
  <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../proses/tambah_foto.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahLabel">Tambahkan Foto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Judul Foto</label>
              <input type="text" name="judul_foto" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Lokasi Foto</label>
              <input type="text" name="lokasi_foto" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Deskripsi Foto</label>
              <textarea name="deskripsi_foto" class="form-control" rows="2" required></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Upload Foto</label>
              <input type="file" name="lokasi_file" class="form-control" accept=".png,.jpg,.jpeg" required>
              <small class="text-muted">Ukuran gambar maksimal 10MB (.png, .jpg, .jpeg)</small>
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" required>
              <label class="form-check-label">Saya yakin ingin menambahkan foto.</label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <footer>
    <p>© 2025 Nama Lengkap Siswa. All Rights Reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>