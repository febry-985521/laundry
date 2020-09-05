<?php 
include '../koneksi.php';

session_start();
$id = $_SESSION['id'];
$id_owner = $_SESSION['id_owner'];
$kasir = $_SESSION['nama'];
$status = $_SESSION['status'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];


if($status!="kasir") {
	header("location:../");
}
?>
