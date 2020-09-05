<?php
//abaikan error yang muncul pada browser
error_reporting(0);
//sesi dimulai
session_start();
//panggil koneksi.php untuk menghubungkan ke database
include "koneksi.php";
$status = $_SESSION['status'];
$id = $_SESSION['id'];
$id_owner = $_SESSION['id_owner'];
//jika sesi sudah admin (sudah pernah login)  maka akan  di direct ke halaman home.php
if($status=="admin")
{
 header("location:admin");
}
if($status=="kasir")
{
 header("location:kasir/index.php?id=$id");
}
if($status=="owner")
{
 header("location:owner/index.php?id=$id_owner");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Laundry</title>
    <style type="text/css">
        body {
            background-repeat: no-repeat;
            background-color: rgb(24, 125, 240);
            background-size: cover;
            font-family: Arial, Helvetica, sans-serif;
            }
        
            #box-login {
            background: white;
            width: 35%;
            height: 350px;
            border: 1px solid #d2d2d2;
            border-radius: 5px;
            margin-top: 150px;
            }
        
            #box-login form {
            margin-top: 15px;
            float: left;
            padding: 5px;
            }
        
            #box-login .inputa {
            width: 90%;
            margin-top: 1px;
            height: 50px;
            border: 0px;
            border-bottom: 1px solid #6a82fb;
            font-size: 16px;
            background: transparent;
            }
        
            #box-login .wed {
            margin-top: 30px;
            width: 45%;
            height: 40px;
            background: #6a82fb;
            border: none;
            color: white;
            font-size: 20px;
            border-radius: 5px;
            }
        
            #box-login h1 {
            text-align: center;
            padding: 5px;
            color: #6a82fb;
            }
        
            #box-login hr {
            width: 50%;
            height: 4px;
            border: none;
            background: #6a82fb;
            }</style>
            
<script>
    function gagal(){
        alert("Salah Gan")
    }
</script>
</head>
<body>

    <center>
        <div id="box-login">
          <h1>Laundry</h1><hr>
          <form id="login" action="" method="post"> 
            <input type="text" class="inputa" name="username" required placeholder="Masukan Username"> 
            <input type="password" class="inputa" name="password" required placeholder="Masukan password"> 
            <input type="submit" class="wed"name="" value="Submit"> 
          </form>
          <!-- proses -->
          <?php 
                                if($_SERVER['REQUEST_METHOD']=='POST'){
                                include 'koneksi.php'; 

                                // admin
                                    $user_admin = $_POST['username']; 
                                    $pass_admin = md5($_POST['password']); 

                                    $login_admin = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$user_admin' AND password = '$pass_admin'");
                                    $cek_admin = mysqli_num_rows($login_admin);
                                    
                                // kasir
                                    $user_kasir = $_POST['username']; 
                                    $pass_kasir = $_POST['password']; 

                                    $login_kasir = mysqli_query($koneksi, "SELECT * FROM kasir WHERE username = '$user_kasir' AND password = '$pass_kasir'  AND level = 'kasir'");
                                    $cek_kasir = mysqli_num_rows($login_kasir);
                                    
                                // owner
                                    $user_owner = $_POST['username']; 
                                    $pass_owner = $_POST['password']; 

                                    $login_owner = mysqli_query($koneksi, "SELECT * FROM owner WHERE username = '$user_owner' AND password = '$pass_owner'  AND level = 'owner'");
                                    $cek_owner = mysqli_num_rows($login_owner);

                                    
                                // admin
                                if ($cek_admin>0) {
                                    $data = mysqli_fetch_assoc($login_admin);
                                    session_start();
                                        $_SESSION['username'] = $user_admin;
                                        $_SESSION['password'] = $pass_admin;
                                        $_SESSION['status'] = "admin";
                                        $_SESSION['id_admin'] = $data['id_admin'];;
                                        header("location: admin/"); //masuk ke halaman admin
                                    } 
                                    

                                // kasir
                                else if($cek_kasir>0) {
                                $data = mysqli_fetch_assoc($login_kasir);
                                $id = $data['id'];
                                    session_start();
                                        $_SESSION['id'] = $id;
                                        $_SESSION['nama'] = $data['nama_kasir'];
                                        $_SESSION['username'] = $user_kasir;
                                        $_SESSION['password'] = $pass_kasir;
                                        $_SESSION['id_owner'] = $data['id_owner'];
                                        $_SESSION['status'] = "kasir";
                                        header("location: kasir/index.php?id=$id"); //masuk ke hal kasir
                                    }
                                // owner
                                elseif($cek_owner>0){
                                $data = mysqli_fetch_assoc($login_owner);
                                $id_owner = $data['id'];    
                                session_start();
                                        $_SESSION['id_owner'] = $id_owner;
                                        $_SESSION['nama'] = $data['nama_own'];
                                        $_SESSION['nama_laundry'] = $data['nama_laundry'];
                                        $_SESSION['username'] = $user_owner;
                                        $_SESSION['password'] = $pass_owner;
                                        $_SESSION['status'] = "owner";
                                        header("location: owner/index.php?owner=$id_owner"); //masuk ke hal owner
                                    }
                                else
                                    echo"
                                    <script type='text/javascript'> alert('Kelsalahan Username/Password Atau Mungkin Akun Tidak Terdaftar'); </script>";
                                }
                                    ?>
                        <!-- proses -->

        </div>
      </center>
</body>
</html>