<?php 
    include 'security.php';

    if(isset($_POST['tambah'])){ // Tambah
        $nama = addslashes($_POST['nama']);
        $alamat = addslashes($_POST['alamat']);
        $tlpn = $_POST['tlpn'];

        $berhasil = mysqli_query($koneksi,"INSERT INTO pelanggan VALUES( NULL , '$nama', '$alamat', '$tlpn')");
        if($berhasil){
            echo "<script type='text/javascript'> alert('Berhasil Ditambahkan');</script>";
        }else{
            echo "<script type='text/javascript'> alert('Gagal Ditambahkan');</script>";
        }
    }
    elseif(isset($_POST['edit'])){
        $nama = addslashes($_POST['nama']);
        $alamat = addslashes($_POST['alamat']);
        $tlpn = $_POST['tlpn'];
                                    // menginput data ke database
        $edit = mysqli_query($koneksi,"UPDATE pelanggan SET
        nama = '".$nama."',
        alamat = '".$alamat."',
        tlpn = '".$tlpn."'
        WHERE id_pelanggan = '".$_GET['id_pelanggan']."' ");
        if($edit){
            header("location: pelanggan.php");
        }else{
            echo "<script type='text/javascript'> alert('Gagal DiUbah');</script>";
        }
    }
    
    elseif(isset($_GET['act']) && $_GET['act'] == 'delete') {
        $id = $_GET['id_pelanggan'];
        
        mysqli_query($koneksi,"DELETE FROM pelanggan WHERE id_pelanggan='$id' ");
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
        <h1>Pelanggan</h1>
        <a href="#tambah" style="margin-left: 30px"><button class="btn-tambah">TAMBAH</button></a>
        <table class="table-line">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>id</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>NO</th>
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
                        $result  = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan LIKE '%$cari%' OR nama  LIKE '%$cari%'OR alamat LIKE '%$cari%' OR tlpn LIKE '%$cari%' LIMIT ".$limit_start.",".$limit." ");
                        }
                    else{
                        $result = mysqli_query($koneksi,"SELECT * FROM pelanggan ORDER BY pelanggan.id_pelanggan DESC LIMIT  ".$limit_start.",".$limit." ");         
                        }   
                    echo mysqli_error($koneksi);
                    
                    error_reporting(0);
                    if(mysqli_num_rows($result)){
                    while($isi = mysqli_fetch_array($result) ){
                        ?>
                        <tr>
                            <td><?= $no++?></td>
                            <td><?= $isi['id_pelanggan']; ?></td>
                            <td><?= $isi['nama']; ?></td>
                            <td><?= $isi['alamat']; ?></td>
                            <td><?= $isi['tlpn']; ?></td>
                            <td>
                                <a href="pelanggan.php?id_pelanggan=<?php echo $isi['id_pelanggan']; ?>#edit"  value="id_pelanggan=<?= $isi['id_pelanggan']?>" class="btn-edit" >Edit</a>
                                <a role="button" href="pelanggan.php?id_pelanggan=<?php echo $isi['id_pelanggan']; ?>&act=delete" class="btn-hapus">Hapus</a>
                            </td>
                        </tr>
                    <?php }
                    } 
                    else{
                        echo "<tr><td colspan='6'><p style='text-align: center'>Data Tidak Ditemukan</p></td></tr>";
                        }
                        ?>                 
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
                <li><a href="pelanggan.php?page=1">First</a></li>
                <li><a href="pelanggan.php?page=<?php echo $link_prev; ?>">&laquo;</a></li>
                <?php
                }
                ?>
                
                <!-- LINK NUMBER -->
                <?php
                // Buat query untuk menghitung semua jumlah data
                $sql_jml = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM pelanggan");
                $get_jumlah = mysqli_fetch_array($sql_jml);
                
                $jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya
                $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
                $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
                
                for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($page == $i)? ' class="active"' : '';
                ?>
                <li <?php echo $link_active; ?>><a href="pelanggan.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
                <li><a href="pelanggan.php?page=<?php echo $link_next; ?>">&raquo;</a></li>
                <li><a href="pelanggan.php?page=<?php echo $jumlah_page; ?>">Last</a></li>
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
            <h2>Registrasi Pelanggan</h2>
                <form  enctype="multipart/form-data"  action="pelanggan.php" method="POST" >
                    <table>
                    <tr>
                        <th>Nama</th>
                        <td><input required type="text" name="nama"></td>                    
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><textarea name="alamat"cols="35" rows="4"></textarea></td>                    
                    </tr>
                    <tr>
                        <th>No HP</th>
                        <td><input required type="number" name="tlpn"></td>
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
    $id=$_GET['id_pelanggan'];
    $data = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id_pelanggan=$id");
        while($isi = mysqli_fetch_array($data)){
    ?>  
            <div id="edit" class="popup">
                    <div class="popup-background">
                        <a href="" class="close-button" title="Close">X</a>
                        <h2>Data Pelanggan</h2>
                            <form  enctype="multipart/form-data"  action="pelanggan.php?id_pelanggan=<?= $isi['id_pelanggan']; ?>" method="POST" >
                                <table>
                                <tr>
                                    <th>Nama
                                        <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?= $isi['id_pelanggan']; ?>"></th>
                                    <td><input type="text" name="nama" id="nama"  value="<?= $isi['nama']; ?>" required></td>                    
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td><input col="35" rom="4" type="text" name="alamat" id="alamat"  value="<?= $isi['alamat']; ?>" required></td>                    
                                </tr>
                                <tr>
                                    <th>No HP</th>
                                    <td><input type="number" name="tlpn" id="tlpn"  value="<?= $isi['tlpn']; ?>" required></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="submit" value="Edit" name="edit" id="edit"></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <?php } ?>
                <!-- edit -->
            </div>

        <div class="clear">

        </div>
        <div class="footer">
            <p> @copyright Pengelola Data Laundry 2020 By<a target="_blank" href="https://www.instagram.com/official_febryardyansyah/" style="text-decoration:none; color:orange"> Febry</a></p>
        </div>
        
    </div>
</body>
</html>