<?php 
include '../koneksi.php';

session_start();
$id_owner = $_SESSION['id_owner'];
$owner = $_SESSION['nama'];
$laundry = $_SESSION['nama_laundry'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$status = $_SESSION['status'];


if($status!="owner") {
	header("location:../");
}
?>
