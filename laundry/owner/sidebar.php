<?php 
    if(isset($_POST['edit-profil'])){
        $nama = addslashes($_POST['nama_own']);
        $alamat = addslashes($_POST['alamat']);
        $nama_laundry = addslashes($_POST['nama_laundry']);
        $username = addslashes($_POST['username']);
        $tlpn = $_POST['tlpn'];
        $password = addslashes($_POST['password']);

    $berhasil = mysqli_query($koneksi, "UPDATE owner SET
        nama_own = '".$nama."',
        nama_laundry = '".$nama_laundry."',
        alamat = '".$alamat."',
        username = '".$username."',
        tlpn = '".$tlpn."',
        password = '".$password."'
    WHERE id = '".$id_owner."' ");
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
        <img src="logo.png" width="120px">
    </a>
    </div>
<ul>
    <li><a href="index.php?id=<?= $id_owner?>">Dashboard</a></li>
    <li><a href="generate.php?id=<?= $id_owner?>">Laporan</a></li>
    <li><a onClick="keluar()">Keluar</a></li>
</ul>


<!-- edit data -->
<?php
    $profil = mysqli_query($koneksi, "SELECT * FROM owner WHERE owner.id = $id_owner");
    while($p = mysqli_fetch_array($profil)){
    ?>  
<div id="edit-profil" class="popup">
        <div class="popup-background">
            <a href="" class="close-button" title="Close">X</a>
            <h2>Profil Kasir</h2>
            <form  enctype="multipart/form-data"  action="index.php?id_owner=<?= $id_owner;?>" method="POST" >
                    <table>
                    <tr>
                        <th>ID</th>
                        <td><?=$p['id'];?></td>
                    </tr>
                    <tr>
                        <th>Laundry</th>
                        <td><input type="text" name="nama_laundry" value="<?= $p['nama_laundry']; ?>"></td>                    
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td><input type="text" name="nama_own" value="<?= $p['nama_own']; ?>" required></td>                    
                    </tr>
                        <th>Alamat</th>
                        <td><input type="text" name="alamat" value="<?= $p['alamat'];?>"></td>
                    <tr>
                        <th>NO HP</th>
                        <td><input type="text" name="tlpn" value="<?= $p['tlpn']; ?>" required></td>                    
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
