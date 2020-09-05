<?php
    include 'koneksi.php';
    session_start();
    echo $_SESSION['status'];
    
	$signature = $_SERVER['SERVER_SIGNATURE'];
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
    $server_name = $_SERVER['SERVER_NAME'];
    
    echo "<br><br>". $signature ."<br><br>". $user_agent."<br>". $server_name;
?>