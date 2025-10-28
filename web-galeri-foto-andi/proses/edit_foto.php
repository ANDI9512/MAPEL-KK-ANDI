<?php
// session_start();
include "koneksi.php";

$id_foto = $_POST['id_foto'];
$judul_foto = mysqli_real_escape_string($conn, $_POST['judul_foto']);
$deskripsi_foto = mysqli_real_escape_string($conn, $_POST['deskripsi_foto']);
$tanggal_update = date('Y-m-d H:i:s');

// Ambil data lama dari database
$query_lama = mysqli_query($conn, "SELECT * FROM foto WHERE id_foto = '$id_foto'");
$data_lama = mysqli_fetch_array($query_lama);
$file_lama = $data_lama['file_foto'];

// Jika user mengupload foto baru
if(!empty($_FILES['file_foto']['name'])) {
    $nama_file = $_FILES['file_foto']['name'];
    $tmp_file = $_FILES['file_foto']['tmp_name'];

    // Validasi format dan ukuran
    $allowed_ext = array('png', 'jpg', 'jpeg', 'gif');
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    $max_size = 10 * 1024 * 1024; // 10 MB
    $size = $_FILES['file_foto']['size'];

    if(!in_array($ext, $allowed_ext)) {
        echo "<script>alert('Format file tidak didukung! Gunakan JPG, JPEG, PNG, atau GIF'); history.back();</script>";
        exit;
    }

    if($size > $max_size) {
        echo "<script>alert('Ukuran file terlalu besar! Maksimal 10MB'); history.back();</script>";
        exit;
    }

    // Buat nama unik dan simpan file baru
    $nama_baru = time() . "" . preg_replace('/[^a-zA-Z0-9\.]/', '', $nama_file);
    $path_baru = "uploads/" . $nama_baru;

    if(move_uploaded_file($tmp_file, $path_baru)) {
        // Hapus file lama jika ada
        if(file_exists($path_lama)) {
            unlink($path_lama);
        }

        // Update nama data terakhir foto baru
        $query_update = "UPDATE foto SET
            judul_foto = '$judul_foto',
            deskripsi_foto = '$deskripsi_foto',
            file_foto = '$nama_baru',
            tanggal_update = '$tanggal_update'
            WHERE id_foto = '$id_foto'";
    } else {
        echo "<script>alert('Gagal mengupload file!'); history.back();</script>";
        exit;
    }
} else {
    // Update data tanpa mengubah file foto
    $query_update = "UPDATE foto SET
        judul_foto = '$judul_foto',
        deskripsi_foto = '$deskripsi_foto',
        tanggal_update = '$tanggal_update'
        WHERE id_foto = '$id_foto'";
}

$result_update = mysqli_query($conn, $query_update);
if($result_update) {
    echo "<script>alert('Data foto berhasil diupdate!'); window.location.href='galeri.php';</script>";
} else {
    echo "<script>alert('Gagal mengupdate data foto!'); history.back();</script>";
}
}
} else{
    header("Location: ../admin/d-admin.php");
    exit;
}
?>