<?php
include('../koneksi.php');
session_start();
if (!isset($_SESSION['username'])) {
header('location:login.php');
exit;
}
$id = $_GET['id_about'];
$sql = "DELETE FROM tbl_about WHERE id_about = '$id'";
$query = mysqli_query($db, $sql);
if ($query) {
echo "<script>alert('Data About berhasil dihapus.');
window.location='about.php';</script>";
} else {
echo "<script>alert('Gagal menghapus data.'); history.back();</script>";
}
?>