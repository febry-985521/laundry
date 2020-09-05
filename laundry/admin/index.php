<?php 
include 'security.php';

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
			<h2 class="welcome">SELAMAT DATANG DI DASHBOARD ADMIN</h2>
        </div>
        <div class="clear">

        </div>
       <div class="footer">
            <p> @copyright Pengelola Data Laundry 2020 By<a target="_blank" href="https://www.instagram.com/official_febryardyansyah/" style="text-decoration:none; color:orange"> Febry</a></p>
        </div>
        
	</div>
</body>
</html>