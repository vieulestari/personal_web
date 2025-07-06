<?php
include('../koneksi.php');
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id_about']) ? intval($_POST['id_about']) : 0;
    $about = isset($_POST['about']) ? mysqli_real_escape_string($db, $_POST['about']) : '';

    if ($id > 0 && $about !== '') {
        $sql = "UPDATE tbl_about SET about='$about' WHERE id_about=$id";

        if (!mysqli_query($db, $sql)) {
            echo "Error updating data: " . mysqli_error($db);
            exit;
        } else {
            echo "<script>
                    alert('Data berhasil diperbarui.');
                    window.location='about.php';
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('Data tidak valid.');
                history.back();
              </script>";
        exit;
    }
} else {
    header('location:about.php');
    exit;
}
?>
