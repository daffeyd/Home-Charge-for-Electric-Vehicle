<?php 
session_start(); 
include "koneksi.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	if (empty($uname)) {
		header("Location: login.php?error=Email / Username is required");
	    exit();
	}else if(empty($pass)){
        header("Location: login.php?error=Password is required");
	    exit();
	}else{
		$sql = "INSERT INTO `members`(`uname`, `password`, `type`, `balance`) VALUES ('$uname','$pass','user','0')";
		$result = mysqli_query($db, $sql);
        header("Location: login.php?success=Akun Sudah Didaftarkan!!!");
	}
	
}else{
	header("Location: login.php");
	exit();
}