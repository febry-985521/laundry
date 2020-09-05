<?php 
    include 'security.php'; 
        
    if(isset($_POST['tambah'])){

        $id_pelanggan = addslashes($_POST['id_pelanggan']);
        $id_paket = addslashes($_POST['paket']);
        $berat = $_POST['berat'];
        $total = $_POST['total'];
                                    // menginput data ke database
        $berhasil = mysqli_query($koneksi,"INSERT INTO transaksi VALUES( NULL , '$id_pelanggan', '$id', '$id_paket',$id_owner, '$berat', '$total', NOW())");
        if($berhasil){
            header("location: transaksi.php");
        }
    }
    elseif(isset($_GET['act']) && $_GET['act'] == 'delete') {
        $id = $_GET['id'];
                    
        mysqli_query($koneksi,"DELETE FROM transaksi WHERE id='$id' ");
        header("location: transaksi.php");
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
        <h1>Transaksi</h1>
        <a href="#tambah" style="margin-left: 30px"><button class="btn-tambah">TAMBAH</button></a>
        <table class="table-line">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>id</th>
                        <th>Waktu</th>
                        <th>Nama</th>
                        <th>Paket</th>
                        <th>Berat</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>

                </thead>
                <tbody>
            <!-- perulangan data -->
                <?php 
                    include '../koneksi.php';
                    error_reporting(0);
                    $no=1;
                    $page = (isset($_GET['page']))? $_GET['page'] : 1;
                    $limit = 10;                               
                  $limit_start = ($page - 1) * $limit;
                    $no = $limit_start + 1;
                    $cari = $_POST['cari'];
                    if($cari != ''){
                        $result  = mysqli_query($koneksi,"SELECT transaksi.tanggal, transaksi.id, pelanggan.nama, paket.paket, transaksi.total ,transaksi.berat FROM transaksi INNER JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan INNER JOIN paket ON paket.id=transaksi.id_paket WHERE Id_input=$id 
                        AND transaksi.id LIKE '%$cari%' 
                        OR transaksi.tanggal LIKE '%$cari%' 
                        OR pelanggan.nama LIKE '%$cari%' 
                        OR paket.paket LIKE '%$cari%' 
                        OR transaksi.berat LIKE '%$cari%' 
                        OR transaksi.total LIKE '%$cari%' order by tanggal DESC LIMIT ".$limit_start.",".$limit." ");
                        }
                    else{
                        $result = mysqli_query($koneksi,"SELECT transaksi.tanggal, transaksi.id, pelanggan.nama, paket.paket, transaksi.total ,transaksi.berat FROM transaksi INNER JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan INNER JOIN paket ON paket.id=transaksi.id_paket WHERE id_input=$id order by tanggal DESC LIMIT ".$limit_start.",".$limit." ");         
                        }   
                    
                    echo mysqli_error($koneksi);
                    
                    error_reporting(0);
                    if(mysqli_num_rows($result)){
                    while($isi = mysqli_fetch_array($result) ){
                        ?>
                        <tr>
                            <td><?= $no++?></td>
                            <td><?= $isi['id']; ?></td>
                            <td><?= $isi['tanggal'];?></td>
                            <td><?= $isi['nama']; ?></td>
                            <td><?= $isi['paket']; ?></td>
                            <td><?= $isi['berat'];?> KG</td>
                            <td>Rp.<?= $isi['total']; ?></td>
                            <td>
                                <a class="btn-hapus" role="button" href="transaksi.php?id=<?php echo $isi['id']; ?>&act=delete">Hapus</a>
                            </td>
                        </tr>
                    <?php }} 
                    else{
                        echo "<tr><td colspan='8'><p style='text-align: center'>Data Tidak Ditemukan</p></td></tr>";
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
                <li><a href="transaksi.php?page=1">First</a></li>
                <li><a href="transaksi.php?page=<?php echo $link_prev; ?>">&laquo;</a></li>
                <?php
                }
                ?>
                
                <!-- LINK NUMBER -->
                <?php
                // Buat query untuk menghitung semua jumlah data
                $sql_jml = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM transaksi WHERE id_input=$id");
                $get_jumlah = mysqli_fetch_array($sql_jml);
                
                $jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya
                $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                $start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
                $end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
                
                for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($page == $i)? ' class="active"' : '';
                ?>
                <li <?php echo $link_active; ?>><a href="transaksi.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
                <li><a href="transaksi.php?page=<?php echo $link_next; ?>">&raquo;</a></li>
                <li><a href="transaksi.php?page=<?php echo $jumlah_page; ?>">Last</a></li>
                <?php
                }
                ?>
            </ul>
            </nav>
<!-- popup-tambah -->
<div id="tambah" class="popup">
        <div class="popup-background">
            <a href="" class="close-button" title="Close">X</a>
            <h2>Tambah Transaksi</h2>
                <form  enctype="multipart/form-data"  action="transaksi.php" method="POST" >
                    <table>
                    <tr>
                        <th>Nama</th>
                        <td>
                        <select name="id_pelanggan">
                            <option selected disabled value="-1">Nama Pelanggan</option>
                            <?php	
                                $data = mysqli_query($koneksi,"SELECT * FROM pelanggan");
                                while($d = mysqli_fetch_array($data) ){
                                ?>
                            <option name="id_pelanggan" value="<?php echo $d["id_pelanggan"]?>"> <?php echo $d["id_pelanggan"]." --> ".$d["nama"]?></option>
                            
                            <?php } ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Paket</th>
                        <td>
                            <?php
                                $query=mysqli_query($koneksi, "SELECT * FROM paket");
                                $jsArray = "var nama = new Array();\n";             
                    ?>
                        <select name="paket" onchange="changeValue(this.value)" required="isi dlu bos">
                        <option selected disabled value="-1">Pilih Paket Laundry</option>
                            <?php if(mysqli_num_rows($query)) {?>
                                <?php while($data= mysqli_fetch_array($query)) {?>
                                    <option name="paket" value="<?php echo $data["id"]?>"> <?php echo $data["paket"]?> </>
                                <?php $jsArray .= "nama['" . $data['id'] . "'] = {nama:'" . addslashes($data['paket']) ."', harga:'" . addslashes($data['harga']) . "'};\n";
                                } ?>
                            
                        <?php } ?>
                        </select></td>                    
                    </tr>
                    <tr>
                        <th>Harga/Kg</th>
                        
                        <td><input type="text" name="harga" id="harga" required="isi dlu bos" onkeyup="sum();"></td>
                        
                    </tr>
                    <tr>
                        <th>Berat</th>
                        
                        <td><input type="text" name="berat" id="berat" onkeyup="sum();"></td>
                        
                    </tr>
                    <tr>
                        <th>Total</th>
                        
                        <td><input type="number" name="total" id="total" onkeyup="sum();"></td>
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Tambah" name="tambah"></td>
                    </tr>
                </table>
            
            <script type="text/javascript">
                        <?php echo $jsArray; ?>
                        console.log(nama)
                        function changeValue(id) {
                        document.getElementById("harga").value = nama[id].harga;
                        };            
            </script>
            
            <script>
                    function sum() {
                        var harga = document.getElementById('harga').value;
                        var berat = document.getElementById('berat').value;
                        var result = parseInt(harga) * parseFloat(berat);
                        if (!isNaN(result)) {
                            document.getElementById('total').value = result;
                        }
                    }
            </script>
            </form>
        </div>
    </div>
    
<!-- akhir-popup-tambah -->
                    

        </div>

        <div class="clear">

        </div>
       <div class="footer">
            <p> @copyright Pengelola Data Laundry 2020 By<a target="_blank" href="https://www.instagram.com/official_febryardyansyah/" style="text-decoration:none; color:orange"> Febry</a></p>
        </div>
        
    </div>

</body>
</html>