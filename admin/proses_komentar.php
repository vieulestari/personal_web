<?php
include "../koneksi.php";

$id_artikel = $_POST['id_artikel'];
$nama = mysqli_real_escape_string($db, $_POST['nama']);
$komentar = mysqli_real_escape_string($db, $_POST['komentar']);

$sql = "INSERT INTO tbl_komentar (id_artikel, nama_pengunjung, isi_komentar) VALUES ('$id_artikel', '$nama', '$komentar')";
$query = mysqli_query($db, $sql);

if ($query) {
  echo "<script>
    alert('Komentar berhasil dikirim, menunggu moderasi.');
    window.location.href = '../index.php';
  </script>";
} else {
  echo "Gagal mengirim komentar: " . mysqli_error($db);
}
?>
