<?php 
    include 'security.php';

    if(isset($_POST['tambah'])){
        $paket = addslashes($_POST['paket']);
        $harga = addslashes($_POST['harga']);
                                    // menginput data ke database
        $berhasil = mysqli_query($koneksi,"INSERT INTO paket VALUES( NULL , '$paket', '$harga')");
        if($berhasil){
            echo "<script type='text/javascript'> alert('Berhasil Ditambahkan');</script>";
        }else{
            echo "<script type='text/javascript'> alert('Gagal Ditambahkan');</script>";
        }
    }
    elseif(isset($_POST['edit'])){
        $paket = addslashes($_POST['paket']);
        $harga = addslashes($_POST['harga']);

        $berhasil1 = mysqli_query($koneksi,"UPDATE paket SET
        paket = '".$paket."',
        harga = '".$harga."'
        WHERE id = '".$_GET['id']."'
    ");
        if($berhasil){
            header("location:paket.php");    
        }
    }
    elseif(isset($_GET['act']) && $_GET['act'] == 'delete') {
        $id = $_GET['id'];
        
        mysqli_query($koneksi,"DELETE FROM paket WHERE id='$id' ");
        header("location: paket.php");
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
        <h1>Paket</h1>
        <a href="#tambah" style="margin-left: 30px"><button class="btn-tambah">TAMBAH</button></a>
			<table class="table-line">
				<thead>
					<tr>
						<th>#</th>
						<th>Paket</th>
						<th>Harga/1KG</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
			<!-- perulangan data -->
                <?php 
					error_reporting(0);
					$page = (isset($_GET['page']))? $_GET['page'] : 1;
					$limit = 10;                               
                    $limit_start = ($page - 1) * $limit;
					$no = $limit_start + 1;
					$cari = $_POST['cari'];
                    if($cari != ''){
                        $result  = mysqli_query($koneksi, "SELECT * FROM paket WHERE paket  LIKE '%$cari%'OR harga LIKE '%$cari%' LIMIT ".$limit_start.",".$limit." ");
                        }
                    else{
                        $result = mysqli_query($koneksi,"SELECT * FROM paket LIMIT ".$limit_start.",".$limit." ");         
                        }   
                    echo mysqli_error($koneksi);
					error_reporting(0);
                    if(mysqli_num_rows($result)){
                    while($isi = mysqli_fetch_array($result) ){
                        ?>
                        <tr>
							<td><?= $no++ ?></td>
                            <td><?= $isi['paket']; ?></td>
                            <td><?= $isi['harga']; ?>/Kg</td>
                            <td>
                                <a href="paket.php?id=<?php echo $isi['id']; ?>#edit"  value="id=<?= $isi['id']?>" class="btn-edit" >Edit</a>
                                <a role="button" href="paket.php?id=<?php echo $isi['id']; ?>&act=delete" class="btn-hapus" >Hapus</a>
                            </td>
						</tr>
					<?php }}
                            
                    else{
                        echo "<tr><td colspan='4'><p style='text-align: center'>Data Tidak Ditemukan</p></td></tr>";
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
                <li><a href="paket.php?page=1">First</a></li>
                <li><a href="paket.php?page=<?php echo $link_prev; ?>">&laquo;</a></li>
                <?php
                }
                ?>
                
                <!-- LINK NUMBER -->
                <?php
                // Buat query untuk menghitung semua jumlah data
                $sql_jml = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM paket");
                $get_jumlah = mysqli_fetch_array($sql_jml);
                
                $jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya
                $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
                $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
                
                for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($page == $i)? ' class="active"' : '';
                ?>
                <li <?php echo $link_active; ?>><a href="paket.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
                <li><a href="paket.php?page=<?php echo $link_next; ?>">&raquo;</a></li>
                <li><a href="paket.php?page=<?php echo $jumlah_page; ?>">Last</a></li>
                <?php
                }
                ?>
            </ul>
            </nav>
            </div>
<!-- tambah data -->
    <div id="tambah" class="popup">
        <div class="popup-background">
            <a href="" class="close-button" title="Close">X</a>
            <h2>Tambah Paket</h2>
                <form  enctype="multipart/form-data"  action="paket.php" method="POST" >
                    <table>
                    <tr>
                        <th>Paket</th>
                        <td><input required type="text" name="paket"></td>                    
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td><input type="text" name="harga"></td>                    
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
    $data = mysqli_query($koneksi, "SELECT * FROM paket WHERE id=$id");
    while($isi = mysqli_fetch_array($data)){
    ?>  
<div id="edit" class="popup">
        <div class="tambah-pel popup-background">
            <a href="paket.php" class="close-button" title="Close">X</a>
            <h2>Detail Paket</h2>
                <form  enctype="multipart/form-data"  action="paket.php?id=<?= $isi['id']; ?>" method="POST" >
                    <table>
                    <tr>
                        <th>Nama
                            <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?= $isi['id']; ?>"></th>
                        <td><input type="text" name="paket" id="paket"  value="<?= $isi['paket']; ?>" required></td>                    
                    </tr>
                    <tr>
                        <th>Paket</th>
                        <td><input type="text" name="harga" id="harga"  value="<?= $isi['harga']; ?>" required></td>                    
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Edit" name="edit" id="edit"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php 
} ?>
<!-- akhir edit data -->
        </div>
        <div class="clear">

        </div>
       <div class="footer">
            <p> @copyright Pengelola Data Laundry 2020 By<a target="_blank" href="https://www.instagram.com/official_febryardyansyah/" style="text-decoration:none; color:orange"> Febry</a></p>
        </div>
        
	</div>
</body>
</html>