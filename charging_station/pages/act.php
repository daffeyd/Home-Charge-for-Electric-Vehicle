<?php
$idM = $_GET['idM'];
$sql = "SELECT * FROM partner WHERE id='$idM'";

$result = mysqli_query($db, $sql);
if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $partnerID = $row['uname'];
    $statusMachine = $row['status'];
}
if ($statusMachine == 0) {
    $idM = strval($idM);
    $idTransaction = $idM . date('YmdHis');
    $insertHistory = "INSERT INTO history (`idTransaction`,`iduser`, `idM`, `hostName`,`questName`, `end_time`, `duration`, `status`) VALUES ($idTransaction,$iduser, $idM, '$partnerID','$nama','-','-','1')";
    if ($db->query($insertHistory) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
    $update = "UPDATE partner SET status='1' WHERE id = '$idM'";
    if ($db->query($update) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
}
if (($statusMachine == 1) && ($_GET['idTr'] == "")) {
    $sql = "SELECT * FROM history WHERE idM='$idM' ORDER BY idTransaction DESC LIMIT 1 ";

    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $idTransaction = $row['idTransaction'];
    }
    echo '
            <script type="text/javascript">
                window.location.replace("http://localhost/charging_station/index.php?p=act&idM=' . $idM . '&idTr=' . $idTransaction . '");
            </script>
            ';
}
if (isset($_GET['idTr'])) {
    $idTransaction = $_GET['idTr'];
}

$sql = "SELECT * FROM history WHERE idTransaction='$idTransaction'";

$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $startTime = $row['start_time'];
    $endTime = $row['end_time'];
    $transactionStatus = $row['status'];
}

?>
<div class="container" style="padding: 20px;margin-top: 30px; border-radius: 25px;  border: 2px solid #73AD21;width:100%;">
    <div class="container">
        <div style="padding: 20px; content:center; width:100%">
            <h1 style="margin-bottom: 20px; color: #32a852;">Charging Details</h1>

            <div style="padding: 20px; border-radius: 25px;  border: 2px solid #73AD21;width:100%; background: #32a852;">
                <h4 style="margin-bottom : 20px; color: white;">Welcome to <?php echo $partnerID ?>'s Home </h4>

                <div class="row">
                    <div class="col" style="margin-right: 20px; padding: 20px; content:center; border-radius: 25px;  border: 2px solid #73AD21;width: 20%; background: #278a35;">
                        <h6 style="color: white;">Start Time</h6>
                        <h2 style="color: white;"><?php echo $startTime ?></h2>
                    </div>
                    <div class="col" style="margin-right: 20px;padding: 20px; content:center; border-radius: 25px;  border: 2px solid #73AD21;width: 20%; background: #278a35;">
                        <h6 style="color: white;">End Time</h6>
                        <h2 style="color: white;"><?php echo $endTime ?></h2>
                    </div>
                    <div class="col" style="padding: 20px; content:center; border-radius: 25px;  border: 2px solid #73AD21;width: 20%; background: #278a35;">
                        <h6 style="color: white;">Duration</h6>
                        <h2 style="color: white;">
                            <?php

                            $assigned_time = $startTime;
                            $completed_time = date('Y-m-d H:i:s');

                            $d1 = new DateTime($assigned_time);
                            $d2 = new DateTime($completed_time);
                            $interval = $d2->diff($d1);
                            $dayInterval =  $interval->format('%d');
                            $hourInterval =  $interval->format('%H');
                            $minutesInterval =  $interval->format('%I');
                            $secInterval =  $interval->format('%I');

                            if ($dayInterval != 0) {
                                echo $interval->format('%d D') . " ";
                            }
                            if ($hourInterval != 0) {
                                echo $interval->format('%H H') . " ";
                            }
                            if ($minutesInterval != 0) {
                                echo $interval->format('%I M') . " ";
                            }
                            echo $interval->format('%S S');


                            ?></h2>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

</body>
<?php
if ($transactionStatus == 2) {
    $hourConvert = ((int)$dayInterval * 24) + ((int)$hourInterval) + ((int)$minutesInterval / 60) + ((int)$secInterval / 3600);
    $update = "UPDATE history SET end_time='$completed_time', duration=$hourConvert WHERE idTransaction = $idTransaction";
    if ($db->query($update) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
    echo '<script type="text/JavaScript"> 
        window.location.replace("http://localhost/charging_station/index.php?p=pay&idM=1&idTr=' . $idTransaction . '");
     </script>';
} ?>
<script type="text/javascript">
    setTimeout(function() {
        window.location.reload(1);
    }, 1000);
</script>