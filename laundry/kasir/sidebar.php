<?php 
    if(isset($_POST['edit-profil'])){
        $nama = addslashes($_POST['nama_kasir']);
        $username = addslashes($_POST['username']);
        $tlpn = $_POST['tlpn'];
        $password = addslashes($_POST['password']);

    $berhasil = mysqli_query($koneksi, "UPDATE kasir SET
        nama_kasir = '".$nama."',
        username = '".$username."',
        tlpn = '".$tlpn."',
        password = '".$password."'
    WHERE id = '".$_GET['id']."' ");
        if($berhasil){
            echo "<script type='text/javascript'> alert('Berhasil DiUbah');</script>";
        }
        else{
            echo "<script type='text/javascript'> alert('Gagal DiUbah');</script>";
        }
    } ?>
<script>
    function keluar(){
        var keluar = confirm("Anda Mencoba Untuk Keluar??");

        if (keluar) {
            window.location.href = 'logout.php';
        }
    }
</script>

<div class="profil">
    <a href="#edit-profil">
        <img src="../admin/logo.png" width="120px">
    </a>
    </div>
<ul>
    <li><a href="index.php?id=<?= $id;?>">Dashboard</a></li>
    <li><a href="pelanggan.php?id=<?= $id;?>">Registrasi Pelanggan</a></li>
    <li><a href="transaksi.php?id=<?= $id;?>">Transaksi</a></li>
    <li><a href="generate.php?id_owner=<?= $id_owner;?>">Generate</a></li>
    <li><a onClick="keluar()">Keluar</a></li>
</ul>

<!-- edit data -->
<?php
    $profil = mysqli_query($koneksi, "SELECT kasir.id, kasir.nama_kasir, kasir.username, kasir.password, kasir.tlpn, owner.nama_laundry, owner.alamat FROM kasir INNER JOIN owner ON kasir.id_owner=owner.id WHERE kasir.id = $id");
    while($p = mysqli_fetch_array($profil)){
    ?>  
<div id="edit-profil" class="popup">
        <div class="popup-background">
            <a href="" class="close-button" title="Close">X</a>
            <h2>Profil Kasir</h2>
            <form  enctype="multipart/form-data"  action="index.php?id=<?= $id;?>" method="POST" >
                    <table>
                    <tr>
                        <th>ID Kasir</th>
                        <td><p><?= $p['id']?></p></td>
                    </tr>
                    <tr>
                        <th>Laundry</th>
                        <td><input style="color:white;" type="text" disabled value="<?= $p['nama_laundry']; ?>"></td>                    
                    </tr>
                    <tr>
                        <th>Alamat Laundry</th>
                        <td><input type="text" style="color:white;" disabled value="<?= $p['alamat']; ?>"></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td><input type="text" name="nama_kasir"   value="<?= $p['nama_kasir']; ?>" required></td>                    
                    </tr>
                    <tr>
                        <th>NO HP</th> 
                        <td><input type="text" name="tlpn"   value="<?= $p['tlpn']; ?>" required></td>                    
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td><input type="text" name="username"   value="<?= $p['username']; ?>" required></td>                    
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td><input type="text" name="password"   value="<?= $p['password']; ?>" required></td>                    
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Edit" name="edit-profil" id="edit-profil"></td>
                    </tr>
                </table>
            </form>
            
        </div>
    </div>
    <?php } ?>
<!-- akhir edit data -->
