<?php
include'../koneksi.php';
$nama=$_POST['id'];
$nama=$_POST['nama'];
$jenis_kelamin=$_POST['jenis_kelamin'];
$tempatlahir=$_POST['tempatlahir'];
$tanggallahir=$_POST['tanggallahir'];
$asalsekolah=$_POST['asalsekolah'];
$nomortelpon=$_POST['nomortelpon'];
$wali=$_POST['wali'];
$status="Belum Terverifikasi";
	
if(isset($_POST['simpan'])){
		extract($_POST);
		$nama_file   = $_FILES['foto']['name'];
		if(!empty($nama_file)){
		// Baca lokasi file sementar dan nama file dari form (fupload)
			$lokasi_file 	= $_FILES['foto']['tmp_name'];
			$tipe_file 		= pathinfo($nama_file, PATHINFO_EXTENSION);
			$file_foto 		= $id_anggota.".".$tipe_file;

			// Tentukan folder untuk menyimpan file
			$folder 		= "../images/$file_foto";
			// Apabila file berhasil di upload
			move_uploaded_file($lokasi_file,"$folder");
		}
		else
			$file_foto="-";
	
	$sql = 
	"INSERT INTO informasipsb
	VALUES('$id','$nama','$file_foto','$jenis_kelamin','$tempatlahir','$tanggallahir','$asalsekolah','$nomortelpon','$wali','$status')";
	// $sql = 
	// "INSERT INTO `informasipsb`(`nama`, `foto`, `jeniskelamin`, `tempatlahir`, `tanggallahir`, `asalsekolah`, `nomortelpon`, `stats`) 
	// VALUES ('$nama','$file_foto','$jenis_kelamin','$tempatlahir','$tanggallahir','$asalsekolah','$nomortelpon','$status')";
	// //echo $sql;
	$query = mysqli_query($db, $sql);
		
	header("location:../index.php?p=informasiakun");
}
?>