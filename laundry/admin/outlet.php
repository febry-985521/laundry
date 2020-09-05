<?php 
include 'security.php';
    // koneksi database                 

    if(isset($_POST['tambah'])){
// menangkap data yang di kirim dari form

    $nama = addslashes($_POST['nama_own']);
    $nama_laundry = addslashes($_POST['nama_laundry']);
    $alamat = addslashes($_POST['alamat']);
    $tlpn = $_POST['tlpn'];
    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);
    $berhasil = mysqli_query($koneksi,"INSERT INTO owner VALUES( NULL , '$nama', '$nama_laundry','$alamat', '$tlpn' ,'$username','$password', 'owner')");
    if($berhasil){
        echo "<script type='text/javascript'> alert('Berhasil Ditambahkan');</script>";
    }else{
        echo "<script type='text/javascript'> alert('Gagal Ditambahkan');</script>";
    }
    }
    if(isset($_POST['edit'])){
        // koneksi database
        include '../koneksi.php';                               
    // menangkap data yang di kirim dari form
       $nama = addslashes($_POST['nama_own']);
    $nama_laundry = addslashes($_POST['nama_laundry']);
    $alamat = addslashes($_POST['alamat']);
    $tlpn = $_POST['tlpn'];
    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);
                                    // menginput data ke database
        $berhasil1 = mysqli_query($koneksi,"UPDATE owner SET
        nama_own = '".$nama."',
        nama_laundry = '".$nama_laundry."',
        tlpn = '".$tlpn."',
        username = '".$username."',
        alamat ='".$alamat."',
        password = '".$password."'
        WHERE id = '".$_GET['id']."'
    ");
        if($berhasil1){
            header("location: outlet.php");
        }
    } 
    else if(isset($_GET['act']) && $_GET['act'] == 'delete') {
        $id = $_GET['id'];
                    
        mysqli_query($koneksi,"DELETE FROM owner WHERE id='$id' ");
        header("location: outlet.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $status; ?></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="wrapper">

		<div class="header">			
            <?php include 'header.php'; ?>
		</div>
		
        <div class="badan">			
			<div class="sidebar">
				<?php include 'sidebar.php'; ?>
			</div>
			
		<div class="content">
        <h1>Laundry</h1>
        <a href="#tambah" style="margin-left: 30px"><button class="btn-tambah">TAMBAH</button></a>
			<table class="table-line">
				<thead>
					<tr>
						<th>id</th>
						<th>Laundry</th>
                        <th>Alamat</th>
                        <th>Owner</th>
                        <th>NO HP</th>
                        <th></th>
						<th colspan="2">Aksi</th>
					</tr>
				</thead>
				<tbody>
			<!-- perulangan data -->
                <?php 
					include '../koneksi.php';
					error_reporting(0);
					$page = (isset($_GET['page']))? $_GET['page'] : 1;
					$limit = 10;                               
                  $limit_start = ($page - 1) * $limit;
					$no = $limit_start + 1;
					$cari = $_POST['cari'];
                    if($cari != ''){
                        $result  = mysqli_query($koneksi, "SELECT * FROM owner  WHERE id LIKE '%$cari%' OR nama_laundry LIKE '%$cari%' OR tlpn LIKE '%$cari%' OR alamat LIKE '%$cari%' OR nama_own LIKE '%$cari%' OR username LIKE '%$cari%' LIMIT ".$limit_start.",".$limit." ");
                        }
                    else{
                        $result = mysqli_query($koneksi,"SELECT * FROM owner  LIMIT ".$limit_start.",".$limit." ");         
                        }   
                    echo mysqli_error($koneksi);
					error_reporting(0);
                    if(mysqli_num_rows($result)){
                    while($isi = mysqli_fetch_array($result) ){
                        ?>
                        <tr>
                            <td><?= $isi['id']; ?></td>
                            <td><?= $isi['nama_laundry']; ?></td>
                            <td><?= $isi['alamat']; ?></td>
                            <td><?= $isi['nama_own']; ?></td>
                            <td><?= $isi['tlpn']; ?></td>
                            <td>
                                <a href="outlet.php?id=<?php echo $isi['id']; ?>#edit" style="" value="id=<?= $isi['id']?>" class="btn-edit" >Detail</a>
                            </td>
                            <td>
                                <a href="eksport.php?id=<?php echo $isi['id']; ?>" style="" value="id=<?= $isi['id']?>" class="btn-cetak">Cetak</a>
                            </td>
                            <td>
                                <a role="button" href="outlet.php?id=<?php echo $isi['id']; ?>&act=delete" class="btn-hapus">Hapus</a>
                            </td>
						</tr>
					<?php }} 
                    else{
                        echo "<tr><td colspan='7'><p style='text-align: center'>Data Tidak Ditemukan</p></td></tr>";
                        }?>                 
                    </tbody>
				</table>
		<nav class="nav-button">
        <ul>
    <!-- LINK FIRST AND PREV -->
            <?php
                if($page == 1){ // Jika page adalah page ke 1, maka disable link PREV
                ?>
            	<li><a style="font-weight: bold;">First</a></li>
        		<li><a href="#">&laquo;</a></li>
                <?php
                }else{ // Jika page bukan page ke 1
                $link_prev = ($page > 1)? $page - 1 : 1;
                ?>
                <li><a href="outlet.php?page=1">First</a></li>
                <li><a href="outlet.php?page=<?php echo $link_prev; ?>">&laquo;</a></li>
                <?php
                }
                ?>
                
                <!-- LINK NUMBER -->
                <?php
                // Buat query untuk menghitung semua jumlah data
                $sql_jml = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM owner");
                $get_jumlah = mysqli_fetch_array($sql_jml);
                
                $jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya
                $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
                $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
                
                for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($page == $i)? ' class="active"' : '';
                ?>
                <li <?php echo $link_active; ?>><a href="outlet.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php
                }
                ?>
                
                <!-- LINK NEXT AND LAST -->
                <?php
                // Jika page sama dengan jumlah page, maka disable link NEXT nya
                // Artinya page tersebut adalah page terakhir 
                if($page == $jumlah_page){ // Jika page terakhir
                ?>
                <li><a href="#">&raquo;</a></li>
                <li><a href="#">Last</a></li>
                <?php
                }else{ // Jika Bukan page terakhir
                $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
                ?>
                <li><a href="outlet.php?page=<?php echo $link_next; ?>">&raquo;</a></li>
                <li><a href="outlet.php?page=<?php echo $jumlah_page; ?>">Last</a></li>
                <?php
                }
                ?>
            </ul>
            </nav>
            <!-- popup-tambah -->
<div id="tambah" class="popup">
        <div class="popup-background">
            <a href=# class="close-button" title="Close">X</a>
            <h2>Tambah Owner</h2>
                <form  enctype="multipart/form-data"  action="outlet.php" method="POST" >
                    <table>
                    <tr>
                        <th>Nama Laundry</th>
                        <td><input required type="text" name="nama_laundry"></td>                    
                    </tr>
                    <tr>
                        <th>Owner</th>
                        <td><input required type="text" name="nama_own"></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><input type="text" name="alamat"></td>
                    </tr>
                    <tr>
                        <th>NO HP</th>
                        <td><input type="number" name="tlpn"></td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td><input type="text" name="username"></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><input type="text" name="password"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Tambah" name="tambah"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<!-- akhir-popup-tambah -->
<!-- edit data -->
<?php
  $id=$_GET['id'];
    $data = mysqli_query($koneksi, "SELECT * FROM owner WHERE id=$id");
    while($isi = mysqli_fetch_array($data)){
    ?>  
    <div id="edit" class="popup">
        <div class="popup-background">
            <a href="outlet.php" class="close-button" title="Close">X</a>
            <h2>Data Owner Laundry</h2>
                <form  enctype="multipart/form-data"  action="outlet.php?id=<?= $isi['id']; ?>" method="POST" >
                    <table>
                    <tr>
                        <th>Nama Laundry</th>
                        <td><input type="text" name="nama_laundry" id="nama_laundry"  value="<?= $isi['nama_laundry']; ?>" required></td>                    
                    </tr>
                    <tr>
                        <th>Owner</th>
                        <td><input type="text" name="nama_own" id="nama_own"  value="<?= $isi['nama_own']; ?>" required></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><input type="text" name="alamat" id="alamat"  value="<?= $isi['alamat']; ?>" required></td>
                    </tr>
                    <tr>
                        <th>NO HP</th>
                        <td><input type="number" name="tlpn" id="tlpn"  value="<?= $isi['tlpn']; ?>" required></td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td><input type="text" name="username" id="username"  value="<?= $isi['username']; ?>" required></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><input type="text" name="password" id="password"  value="<?= $isi['password']; ?>" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Edit" name="edit"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php } ?>
<!-- akhir edit data -->
			</div>
        </div>
        <div class="clear">

        </div>
        <div class="footer">
            <p> @copyright Pengelola Data Laundry 2020 By<a target="_blank" href="https://www.instagram.com/official_febryardyansyah/" style="text-decoration:none; color:orange"> Febry</a></p>
        </div>
        
	</div>
</body>
</html>