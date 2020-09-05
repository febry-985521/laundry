
<?php
    $laundry = mysqli_query($koneksi, "SELECT owner.nama_laundry, kasir.id FROM kasir INNER JOIN owner ON kasir.id_owner=owner.id WHERE kasir.id=$id
    ");
    $p = mysqli_fetch_array($laundry)
        
    ?>  
<div class=" fixed-top">			
    <p>Pengelola Data Laundry <b style="text-align :center;"><?php echo $p['nama_laundry']; ?></b></p>
        <form action="" method="POST">
            <input class="search" type="search" name="cari">
            <input class="button" type="submit" value="Cari">
    </form>
</div>
