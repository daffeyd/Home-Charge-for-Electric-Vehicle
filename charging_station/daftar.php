<!DOCTYPE html>
<html>
<head>
	<title>Daftar Akun</title>
	<link rel="stylesheet" type="text/css" href="style_log.css">
	<link rel="shortcut icon" type="image" href="assets/images/logo.png">
</head>

<body style="background: #6e501e;">
<img src="assets/images/navbar-logo.png" class="img-fluid" alt="logo" style="height:100px; margin: 20px">
     <form class="ind" action="cekDaftar.php" method="post">
     	<h2>Daftar Akun</h2>
     	<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
     	<label>Username</label>
     	<input type="text" name="uname" placeholder="Username"><br>

     	<label>Password</label>
     	<input type="password" name="password" placeholder="Password"><br>

     	<button class="log" type="submit">Daftar</button>
		<p> Sudah memiliki akun? <a class="daftar" href="login.php">Login disini</a></p>
     </form>
	 
     
</body>

</html>