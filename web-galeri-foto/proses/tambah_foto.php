<?php
session_start();
include '../koneksi.php';

if(isset($_POST['tambah'])){
    $judul_foto = mysqli_real_escape_string($conn, $_POST['judul_foto']);
    $lokasi_foto = mysqli_real_escape_string($conn, $_POST['lokasi_foto']);
    $deskripsi_foto = mysqli_real_escape_string($conn, $_POST['deskripsi_foto']);
    $tanggal_upload = date('Y-m-d');
    $id_user = $_SESSION['id_user'] ?? 1;
    $nama_file = $_FILES['lokasi_file']['name'];
    $tmp_file = $_FILES['lokasi_file'] ['tmp_name'];
    $ukuran = $_FILES['lokasi_file']['size'];
    $error = $_FILES['lokasi_file']['error'];
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];
    if(!in_array($ext, $allowed_ext)){
        echo "<script>alert('Format file tidak didukung! Gunakan JPG, JPEG, atau PNG.'); history.back();</script>";
        exit;
    }
    $max_size = 10 * 1024 * 1024;
    if($ukuran > $max_size){
        echo "<script>alert('Ukuran file terlalu besar! Maksimal 10MB.'); history.back();</script>";
        exit;
    }
    if ($error != 0){
        echo "<script>alert('Terjadi kesalahan saat upload (error code: $error).');history.back();</script>";
        exit;
    }
    if (!is_dir("../img")){
        mkdir("../img", 0777, true);
    }
    $nama_baru = time() . "" . preg_replace("/[^a-zA-Z0-9.]/", "", $nama_file);
    $path = "../img/" . $nama_baru;
    if (move_uploaded_file($tmp_file, $path)){
        $sql = "INSERT INTO foto (judul_foto, deskripsi_foto, lokasi_foto, lokasi_file, tanggal_upload, id_user)
        VALUES ('$judul_foto', '$deskripsi_foto', '$lokasi_foto', '$nama_baru', '$tanggal_upload', '$id_user')";
        if (mysqli_query($conn, $sql)){
            echo "<script>alert('Foto berhasil ditambahkan!'); window.location='../admin/d-admin.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data ke database: ".mysqli_error($conn)."'); history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload file ke folder img/. Pastikan folder dapat ditulis.'); history.back();</script>";
    }
}
?>