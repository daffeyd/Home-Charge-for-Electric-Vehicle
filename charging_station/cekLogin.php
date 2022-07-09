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
		header("Location: login.php?error=Username is required");
	    exit();
	}else if(empty($pass)){
        header("Location: login.php?error=Password is required");
	    exit();
	}else{
		$sql = "SELECT * FROM members WHERE uname='$uname' AND password='$pass'";

		$result = mysqli_query($db, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['uname'] === $uname && $row['password'] === $pass) {
            	$_SESSION['iduser'] = $row['id'];
            	$_SESSION['pass'] = $row['password'];
            	$_SESSION['uname'] = $row['uname'];
            	header("Location: index.php");
		        exit();
            }else{
				header("Location: login.php?error=Incorect Username or password");
		        exit();
			}
		}else{
			header("Location: login.php?error=Incorect Username or password");
	        exit();
		}
	}
	
}else{
	header("Location: login.php");
	exit();
}