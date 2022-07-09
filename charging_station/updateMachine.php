<?php

$tgl = date('Y-m-d H:i:s');
include "koneksi.php";
$idM = $_GET['idM'];

$sql = "SELECT * FROM history WHERE idM='$idM' AND status='1' ORDER BY idTransaction desc Limit 1";

$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $idTransaction = $row['idTransaction'];
    $update = "UPDATE history SET status='2' , end_time='$tgl' WHERE idTransaction = '$idTransaction'";
    if ($db->query($update) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
    exit();
} else {
    exit();
}
?>