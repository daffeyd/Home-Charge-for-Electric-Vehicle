<?php
include'../koneksi.php';
$id =  $_POST['id'];
$nama=$_POST['nama'];
$jenis_kelamin=$_POST['jenis_kelamin'];
$tempatlahir=$_POST['tempatlahir'];
$tanggallahir=$_POST['tanggallahir'];
$asalsekolah=$_POST['asalsekolah'];
$nomortelpon=$_POST['nomortelpon'];
$status=$_POST['stats'];

If(isset($_POST['simpan'])){
	
		extract($_POST);
		$nama_file   = $_FILES['foto']['name'];
		if(!empty($nama_file)){
			// Baca lokasi file sementar dan nama file dari form (fupload)
			$lokasi_file 	= $_FILES['foto']['tmp_name'];
			$tipe_file 		= pathinfo($nama_file, PATHINFO_EXTENSION);
			$file_foto 		= $id_anggota.".".$tipe_file;
			// Tentukan folder untuk menyimpan file
			$folder 		= "../images/$file_foto";
			@unlink ("$folder");
			// Apabila file berhasil di upload
			move_uploaded_file($lokasi_file,"$folder");
		}
		else
			$file_foto=$foto_awal;
	
		// $sql = 
		// "INSERT INTO `informasipsb`(`nama`, `foto`, `jeniskelamin`, `tempatlahir`, `tanggallahir`, `asalsekolah`, `nomortelpon`, `stats`) 
		// VALUES ('$nama','$file_foto','$jenis_kelamin','$tempatlahir','$tanggallahir','$asalsekolah','$nomortelpon','$status')";
		// //echo $sql;
		$sql = 
		"UPDATE `informasipsb` SET `nama`='$nama',`foto`='$file_foto',`jeniskelamin`='$jenis_kelamin',
		`tempatlahir`='$tempatlahir',`tanggallahir`='$tanggallahir',`asalsekolah`='$asalsekolah',`nomortelpon`='$nomortelpon',`stats`='$status' WHERE id = '$id'";
		//echo $sql;
		$query = mysqli_query($db, $sql);
		
		header("location:../index.php?p=daftarPSB");
}
?>
