
<div class="profil">
    <img src="logo.png" width="120px" alt="">
</div>
<ul>
    <li><a href="index.php">Dashboard</a></li>
    <li><a href="pelanggan.php">Registrasi Pelanggan</a></li>
    <li><a href="paket.php">Paket Cucian</a></li>
    <li><a href="kasir.php">Pengguna</a></li>
    <li><a href="outlet.php">Outlet/Generate</a></li>
    <li><a href="transaksi.php">Transaksi</a></li>
    <li><a onClick="keluar()">Keluar</a></li>
</ul>

<script>
    function keluar(){
        var keluar = confirm("Anda Mencoba Untuk Keluar??");

        if (keluar) {
            window.location.href = 'logout.php';
        }
    }
</script>