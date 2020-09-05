<?php 
include '../koneksi.php';

session_start();
$status = $_SESSION['status'];
$id_admin = $_SESSION['id_admin'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];


if($status!="admin") {
	header("location:../");
}
?>
