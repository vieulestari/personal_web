<?php
include('../koneksi.php');
session_start();
if (!isset($_SESSION['username'])) {
  header('location:login.php');
  exit;
}

$id = intval($_GET['id']);
$aksi = $_GET['aksi'];

switch ($aksi) {
  case 'terima':
    $sql = "UPDATE tbl_komentar SET status='diterima' WHERE id_komentar=$id";
    break;
  case 'tolak':
    $sql = "UPDATE tbl_komentar SET status='ditolak' WHERE id_komentar=$id";
    break;
  case 'hapus':
    $sql = "DELETE FROM tbl_komentar WHERE id_komentar=$id";
    break;
  default:
    echo "<script>alert('Aksi tidak valid');history.back();</script>";
    exit;
}

if (mysqli_query($db, $sql)) {
  echo "<script>alert('Aksi berhasil dilakukan.');window.location.href='kelola_komentar.php';</script>";
} else {
  echo "<script>alert('Terjadi kesalahan: " . mysqli_error($db) . "');history.back();</script>";
}
?>