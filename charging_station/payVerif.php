<?php
session_start();
$tgl = date('Y-m-d H:i:s');
include "koneksi.php";
$idM = $_GET['idM'];

$sql = "SELECT * FROM history WHERE idM='$idM' AND paymentStatus='unverified' ORDER BY idTransaction desc Limit 1";

$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $idTransaction = $row['idTransaction'];
    $update = "UPDATE history SET status='3' ,paymentStatus='verified' WHERE idTransaction = '$idTransaction'";
    if ($db->query($update) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
    $update = "UPDATE partner SET status='0' WHERE id = '$idM'";
    if ($db->query($update) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
    header("Location: index.php?p=machine");
    exit();
} else {
    header("Location: login.php?error=Incorect Username or password");
    exit();
}
