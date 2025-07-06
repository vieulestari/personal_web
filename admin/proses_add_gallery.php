<?php
include('../koneksi.php');
session_start();
if (!isset($_SESSION['username'])) {
  header('location:login.php');
  exit;
}

$judul = mysqli_real_escape_string($db, $_POST['judul']);
$foto = $_FILES['foto']['name'];
$tmp  = $_FILES['foto']['tmp_name'];
$folder = '../images/';

// Pastikan folder penyimpanan ada
if (!file_exists($folder)) {
  mkdir($folder, 0777, true);
}

// Cek ekstensi dan mime tipe
$ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$mime = mime_content_type($tmp);
$allowedMime = [
  'image/jpeg', 'image/png', 'image/gif', 'image/webp'
];

// Validasi file
if (!in_array($ext, $allowed) || !in_array($mime, $allowedMime)) {
  echo "<script>alert('Format file tidak didukung. Hanya gambar (jpg, png, gif, webp) yang diperbolehkan.');
        history.back();</script>";
  exit;
}

// Nama file unik
$newFileName = uniqid('img_', true) . '.' . $ext;
$target = $folder . $newFileName;

// Upload dan simpan ke database
if (move_uploaded_file($tmp, $target)) {
  $sql = "INSERT INTO tbl_gallery (judul, foto) VALUES ('$judul', '$newFileName')";
  $query = mysqli_query($db, $sql);

  if ($query) {
    echo "<script>alert('Gambar berhasil ditambahkan.');
          window.location='data_gallery.php';</script>";
  } else {
    echo "<script>alert('Gagal menyimpan data ke database.');
          history.back();</script>";
  }
} else {
  echo "<script>alert('Gagal mengupload gambar ke folder.');
        history.back();</script>";
}
?>
