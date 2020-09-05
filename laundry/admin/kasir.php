<?php 
    include 'security.php'; //koneksi
    
    if(isset($_POST['tambah'])){
        $nama = addslashes($_POST['nama_kasir']);
        $username = addslashes($_POST['username']);
        $tlpn = $_POST['tlpn'];
        $owner = $_POST['owner'];
        $password = addslashes($_POST['password']);
            
    $berhasil = mysqli_query($koneksi,"INSERT INTO kasir VALUES( NULL , '$nama', '$tlpn','$username','$password','$owner', 'Kasir')");    
        if($berhasil){
            echo "<script type='text/javascript'> alert('Berhasil Ditambahkan');</script>";
        }
        else{
            echo "<script type='text/javascript'> alert('Gagal Ditambahkan');</script>";
        }
    }
    elseif(isset($_POST['edit'])){
        $nama = addslashes($_POST['nama_kasir']);
        $username = addslashes($_POST['username']);
        $tlpn = $_POST['tlpn'];
        $owner = $_POST['owner'];
        $password = addslashes($_POST['password']);

    $update = mysqli_query($koneksi, "UPDATE kasir SET
        nama_kasir = '".$nama."',
        id_owner = '".$owner."',
        username = '".$username."',
        tlpn = '".$tlpn."',
        password = '".$password."'
    WHERE id = '".$_GET['id']."' ");
        if($update){
            header("location: kasir.php");
        }
        else{
            echo "<script type='text/javascript'> alert('Gagal DiUbah');</script>";
        }
    }
    
    elseif(isset($_GET['act']) && $_GET['act'] == 'delete') {
        $id = $_GET['id'];
                
        mysqli_query($koneksi,"DELETE FROM kasir WHERE id='$id' ");
        header("location: kasir.php");
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
        <h1>Kasir</h1>
        <a href="#tambah" style="margin-left: 30px"><button class="btn-tambah">TAMBAH</button></a>
			<table class="table-line">
				<thead>
					<tr>
						<th>#</th>
						<th>id</th>
						<th>Username</th>
                        <th>Nama</th>
                        <th>Laundry</th>
						<th>NO HP</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
			<!-- perulangan data -->
                <?php 
					error_reporting(0);
					$no=1;
					$page = (isset($_GET['page']))? $_GET['page'] : 1;
					$limit = 10;                               
                    $limit_start = ($page - 1) * $limit;
					$no = $limit_start + 1;
					$cari = $_POST['cari'];
                    if($cari != ''){
                        $result  = mysqli_query($koneksi, "SELECT kasir.id, kasir.username, kasir.nama_kasir, owner.nama_laundry, kasir.tlpn FROM kasir INNER JOIN owner ON owner.id=kasir.id_owner  WHERE kasir.id LIKE '%$cari%' OR kasir.nama LIKE '%$cari%' OR owner.nama_laundry LIKE '%$cari%' OR kasir.tlpn LIKE '%$cari%' LIMIT ".$limit_start.",".$limit." ");
                        }
                    else{
                        $result = mysqli_query($koneksi,"SELECT kasir.id, kasir.username, kasir.nama_kasir, owner.nama_laundry, kasir.tlpn FROM kasir INNER JOIN owner ON owner.id=kasir.id_owner LIMIT ".$limit_start.",".$limit." ");         
                        }   
                    echo mysqli_error($koneksi);
					error_reporting(0);
                    if(mysqli_num_rows($result)){
                    while($isi = mysqli_fetch_array($result) ){
                        ?>
                        <tr>
                            <td><?= $no++?></td>
							<td><?= $isi['id']; ?></td>
                            <td><?= $isi['username']; ?></td>
                            <td><?= $isi['nama_kasir']; ?></td>
                            <td><?= $isi['nama_laundry']; ?></td>
                            <td><?= $isi['tlpn']; ?></td>
                            <td>
                                <a href="kasir.php?id=<?php echo $isi['id']; ?>#edit"  value="id=<?= $isi['id']?>" class="btn-edit" >Edit</a>
                                <a role="button" href="kasir.php?id=<?php echo $isi['id']; ?>&act=delete" class="btn-hapus">Hapus</a>
                            </td>
						</tr>
                    <?php }
                    } 
                    else{
                        echo "<tr><td colspan='7'><p style='text-align: center'>Data Tidak Ditemukan</p></td></tr>";
                        }?>                 
                    </tbody>
				</table>
        <!-- NAV -->
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
                <li><a href="kasir.php?page=1">First</a></li>
                <li><a href="kasir.php?page=<?php echo $link_prev; ?>">&laquo;</a></li>
                <?php
                }
                ?>
                
                <!-- LINK NUMBER -->
                <?php
                // Buat query untuk menghitung semua jumlah data
                $sql_jml = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM kasir");
                $get_jumlah = mysqli_fetch_array($sql_jml);
                
                $jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya
                $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
                $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
                
                for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($page == $i)? ' class="active"' : '';
                ?>
                <li <?php echo $link_active; ?>><a href="kasir.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
                <li><a href="kasir.php?page=<?php echo $link_next; ?>">&raquo;</a></li>
                <li><a href="kasir.php?page=<?php echo $jumlah_page; ?>">Last</a></li>
                <?php
                }
                ?>
            </ul>
            </nav>
            <!-- NAV -->

            <!-- popup-tambah -->
<div id="tambah" class="popup">
        <div class="popup-background">
            <a href="" class="close-button" title="Close">X</a>
            <h2>Tambah Kasir</h2>
                <form  enctype="multipart/form-data"  action="kasir.php" method="POST" >
                    <table>
                    <tr>
                        <th>Nama</th>
                        <td><input required type="text" name="nama_kasir"></td>                    
                    </tr>
                    <tr>
                        <th>No HP</th>
                        <td><input required type="number" name="tlpn"></td>
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
                        <th>Nama Laundry</th>
                        <td><select name="owner">
                            <option selected disabled value="-1">Pilih yang Bener</>
                            <?php
                                include 'koneksi.php';	
                                $data = mysqli_query($koneksi,"SELECT * FROM owner"); 
                                echo mysqli_error($koneksi);

                                while($d = mysqli_fetch_array($data) ){
                                ?>
                            <option value="<?php echo $d['id']; ?> "><?php echo $d['nama_laundry'];?></option>
                            
                            <?php } ?>
                            </select>
                        </td>
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

<!-- edit -->
<?php
    $id=$_GET['id'];
    $data = mysqli_query($koneksi, "SELECT * FROM kasir WHERE id=$id");
    while($isi = mysqli_fetch_array($data)){
    ?>  
            <div id="edit" class="popup">
                    <div class=" popup-background">
                        <a href="" class="close-button" title="Close">X</a>
                        <h2>Edit Kasir</h2>
                            <form  enctype="multipart/form-data"  action="kasir.php?id=<?= $isi['id']; ?>" method="POST" >
                                <table>
                                <tr>
                                    <th>Nama</th>
                                    <td><input type="text" name="nama_kasir" id="nama"  value="<?= $isi['nama_kasir']; ?>" required></td>                    
                                </tr>
                                <tr>
                                    <th>No HP</th>
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
                                    <th>Nama Laundry</th>
                                    <td><select name="owner">
                                        <?php
                                            $ido=$isi['id_owner'];
                                                $data11 = mysqli_query($koneksi, "SELECT * from owner where id=$ido");
                                                while($isi11 = mysqli_fetch_array($data11)){
                                            ?>
                                <option value="<?= $isi11['id']; ?>"><?= $isi11['nama_laundry']; ?></option>
                                <?php } ?>
                                <?php
                                $data12 = mysqli_query($koneksi, "SELECT * from owner");
                                while($isi12 = mysqli_fetch_array($data12)){
                                    ?>
                                    <option value="<?= $isi12['id']; ?>"><?= $isi12['nama_laundry']; ?></option>
                                <?php } ?>
                            </select></td>
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