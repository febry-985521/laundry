<?php
header("Content-Type: application/vnd.msword");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=LaporanLaundry.doc");?>

<?php 
include 'security.php';                   
    $tb_laundry = mysqli_query($koneksi, "SELECT * FROM owner WHERE id=$id_owner ");
    $x = mysqli_fetch_assoc($tb_laundry);
?>


<style>
    *{
        font-family: Calibri;
    }
    .badan{
        width: 90%;
        margin-left: 5%;
    }
    .info tr td, .info tr th{
        text-align:left;
    }
    .info{
        width: 90%
    }
</style>


<div class="badan">
<h1 style="text-align: center; margin-bottom:100px">LAPORAN PEMASUKAN LAUNDRY</h1>
<table class="info">
    <tr>
        <th>LAUNDRY</th>
        <td>:</td>
        <td><?php echo $x['nama_laundry']; ?></td>
    </tr>
    <tr>
        <th>PEMILIK</th>
        <td>:</td>
        <td><?php echo $x['nama_own']; ?></td>
    </tr>
    <tr>
        <th>ID</th>
        <td>:</td>
        <td><?php echo $x['id'] ?></td>
    </tr>
    <tr>
        <th>ALAMAT</th>
        <td>:</td>
        <td><?php echo $x['alamat']; ?></td>
    </tr>
    <tr>
        <th>NO TELEPON</th>
        <td>:</td>
        <td><?php echo $x['tlpn'] ?></td>
    </tr>
</table><br><br>
        <table class="table" border style="border-collapse: collapse; width:90%; text-align:center; margin-left: 5%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Tgl</th>
                        <th>Nama</th>
                        <th>Paket</th>
                        <th>Berat</th>
                        <th>Total</th>
                    </tr>

                </thead>
                <tbody>
            <!-- perulangan data -->
                <?php 
                    $result = mysqli_query($koneksi,"SELECT  transaksi.id,transaksi.tanggal,
                    pelanggan.nama, paket.paket, transaksi.total, transaksi.id_owner, transaksi.berat FROM transaksi 
                    INNER JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan 
                    INNER JOIN paket ON paket.id=transaksi.id_paket WHERE transaksi.id_owner=$id_owner order by tanggal 
                    ");
                    if(mysqli_num_rows($result)){
                    while($isi = mysqli_fetch_array($result) ){
                        ?>
                        <tr>
                            <td><?= $isi['id']; ?></td>
                            <td><?= $isi['tanggal'];?></td>
                            <td><?= $isi['nama']; ?></td>
                            <td><?= $isi['paket']; ?></td>
                            <td><?= $isi['berat'];?> KG</td>
                            <td>Rp. <?= $isi['total']; ?></td>                            
                        </tr>
                    <?php }} 
                    else{
                        echo "<tr><td colspan='6'><p style='text-align: center'>Data Tidak Ditemukan</p></td></tr>";
                        }?>
                        <tr>
                            <td colspan="5">Pendapatan</td>
                            <td><b>Rp. <?php 
                            $tot  = mysqli_query($koneksi, "SELECT SUM(total) FROM transaksi WHERE id_owner=$id_owner");
                            $SUM = mysqli_fetch_assoc($tot);
                            echo $SUM['SUM(total)'];
                    
                        ?></b></td>
                        </tr>                 
                    </tbody>
                </table>
            </div>
