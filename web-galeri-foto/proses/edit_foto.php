<?php
include "../koneksi.php";

$id_foto = $_POST['id_foto'];
$judul_foto = mysqli_real_escape_string($conn, $_POST['judul_foto']);
$deskripsi_foto = mysqli_real_escape_string($conn, $_POST['deskripsi_foto']);
$tanggal_update = date('Y-m-d H:i:s');

// Ambil data lama dari database
$query_lama = mysqli_query($conn, "SELECT * FROM foto WHERE id_foto = '$id_foto'");
$data_lama = mysqli_fetch_assoc($query_lama);
$file_lama = $data_lama['lokasi_file']; // kolom sesuai tabel kamu (bukan 'file_foto')

// Tentukan folder penyimpanan gambar
$folder_upload = "../img/";

// Jika user mengupload foto baru
if (!empty($_FILES['file_foto']['name'])) {
    $nama_file = $_FILES['file_foto']['name'];
    $tmp_file = $_FILES['file_foto']['tmp_name'];
    $size = $_FILES['file_foto']['size'];

    // Validasi format file
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_ext)) {
        echo "<script>alert('Format file tidak didukung! Gunakan JPG, JPEG, PNG, atau GIF'); history.back();</script>";
        exit;
    }

    // Validasi ukuran file (maks 10 MB)
    $max_size = 100 * 1024 * 1024;
    if ($size > $max_size) {
        echo "<script>alert('Ukuran file terlalu besar! Maksimal 10MB'); history.back();</script>";
        exit;
    }

    // Buat nama unik
    $nama_baru = time() . "" . preg_replace('/[^a-zA-Z0-9\.]/', '', $nama_file);
    $path_baru = $folder_upload . $nama_baru;

    // Upload file baru
    if (move_uploaded_file($tmp_file, $path_baru)) {
        // Hapus foto lama jika ada
        $path_lama = $folder_upload . $file_lama;
        if (file_exists($path_lama) && !empty($file_lama)) {
            unlink($path_lama);
        }

        // Update database dengan foto baru
        $query_update = "UPDATE foto SET 
                            judul_foto = '$judul_foto', 
                            deskripsi_foto = '$deskripsi_foto',
                            lokasi_file = '$nama_baru',
                            tanggal_upload = '$tanggal_update'
                         WHERE id_foto = '$id_foto'";
    } else {
        echo "<script>alert('Gagal mengupload file baru!'); history.back();</script>";
        exit;
    }
} else {
    // Update tanpa ubah foto
    $query_update = "UPDATE foto SET 
                        judul_foto = '$judul_foto', 
                        deskripsi_foto = '$deskripsi_foto',
                        tanggal_upload = '$tanggal_update'
                     WHERE id_foto = '$id_foto'";
}

// Jalankan query update
if (mysqli_query($conn, $query_update)) {
    echo "<script>alert('Data foto berhasil diupdate!'); window.location.href='../admin/d-admin.php';</script>";
} else {
    echo "<script>alert('Gagal mengupdate data foto!'); history.back();</script>";
}
?>