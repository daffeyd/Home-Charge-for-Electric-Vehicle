<?php

$sql = "SELECT * FROM history WHERE iduser='$iduser'and status='1'";

$result = mysqli_query($db, $sql);
if ($result !=""){
if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $paymentType = $row['paymentType'];
    $idTransaction = $row['idTransaction'];
    $idM = $row['idM'];
        echo '
        <script type="text/javascript">
            window.location.replace("http://localhost/charging_station/index.php?p=act&idM='.$idM.'&idTr='.$idTransaction.'");
        </script>
        ';
}}

$sql = "SELECT * FROM history WHERE iduser='$iduser'and paymentStatus='unverified' or paymentStatus=''";

$result = mysqli_query($db, $sql);
if ($result !=""){
if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $paymentType = $row['paymentType'];
    $idTransaction = $row['idTransaction'];
    $idM = $row['idM'];
    if(($paymentType == "Cash")||($paymentType == "Home-chargePay")){
        echo '
        <script type="text/javascript">
            window.location.replace("http://localhost/charging_station/index.php?p=verif&idM='.$idM.'&idTr='.$idTransaction.'&method='.$paymentType.'");
        </script>
        ';
    }
    echo '
        <script type="text/javascript">
            window.location.replace("http://localhost/charging_station/index.php?p=pay&idM='.$idM.'&idTr='.$idTransaction.'");
        </script>
        ';
}}
?>
<script src="./jquery.min.js"></script>
<script src="./instascan.min.js"></script>
<div class="container" style="padding: 20px; content:center;margin-top: 30px; border-radius: 25px;  border: 2px solid #32a852;width:500px">
    <div style="padding: 5px; content:center;margin-top: 10px; width:100%">
        <h3 style="text-align: center; color:#32a852;">Scan Machine QR Code</h3><br>
    </div>
    <div class="container" style="padding: 20px; float:center; border-radius: 25px;  border: 2px solid #32a852;width:100%; background: #32a852;height:30%">
        <center>
            <video id="preview" style="border-radius: 25px;" width="100%" height="100%"></video>
        </center>
    </div>

</div>
</div>

</div>
</body>
<script type="text/javascript">
    let scanner = new Instascan.Scanner({
        video: document.getElementById('preview')
    });
    scanner.addListener('scan', function(content) {
        window.location.replace(content);
    });
    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            console.error('No cameras found')
        }
    }).catch(function(e) {
        console.error(e);
    });
</script>