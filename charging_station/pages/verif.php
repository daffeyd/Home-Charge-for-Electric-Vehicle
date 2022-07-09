
<?php

$idTransaction = $_GET['idTr'];
$idM = $_GET['idM'];

$sql = "SELECT * FROM partner WHERE id='$idM'";

$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $multiplier = $row['multiplier'];
    $machineCapacity = $row['machineCapacity'];
}
$sql = "SELECT * FROM history WHERE idTransaction='$idTransaction'";

$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $startTime = $row['start_time'];
    $endTime = $row['end_time'];
    $duration = $row['duration'];
    $statusPayment = $row['paymentStatus'];
    $totalPayment = $row['totalPayment'];
}
if (isset($_GET['method'])) {
    $method = $_GET['method'];
    if (($method == "Home-chargePay") && ($statusPayment == "unverified")) {
        $newBalance = $balance - $totalPayment;
        $updatePayment = "UPDATE members SET balance=$newBalance WHERE id = '$iduser'";
        if ($db->query($updatePayment) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($db);
        }
        $updateStatus = "UPDATE history SET status='3' , paymentType='Home-chargePay' , paymentStatus='verified' WHERE idTransaction = '$idTransaction'";
        if ($db->query($updateStatus) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($db);
        }
        $update = "UPDATE partner SET status='0' WHERE id = '$idM'";
        if ($db->query($update) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($db);
        }
    }
    if (($method == "Cash") && ($statusPayment == "unverified")) {
        $updateStatus = "UPDATE history SET paymentType='Cash' , paymentStatus='unverified' WHERE idTransaction = '$idTransaction'";
        if ($db->query($updateStatus) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($db);
        }
        $update = "UPDATE partner SET status='2' WHERE id = '$idM'";
        if ($db->query($update) === TRUE) {
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($db);
        }
    }
} ?>
<div class="container" style="padding: 20px;margin-top: 30px; border-radius: 25px;  border: 2px solid #73AD21;width:100%;">
    <div class="container">
        <div style="padding: 20px; content:center; width:100%">
            <h2 style="margin-bottom: 20px; color: #32a852;">Payment Status</h2>

            <div style="padding: 20px; border-radius: 25px;  border: 2px solid #73AD21;width:100%; background: #32a852;">

                <h4 style="margin-bottom : 20px; color: white;">Total Payment With <?php echo $method; ?></h4>
                <div class="col" style="margin-bottom : 20px; padding: 20px; content:center; border-radius: 25px;  border: 2px solid #73AD21;width: 100%; background: #278a35;">
                    <h2 style="color: white;"><?php
                                                $payment = round($duration * $multiplier * $machineCapacity);
                                                $update = "UPDATE history SET totalPayment='$payment' WHERE idTransaction = $idTransaction";
                                                if ($db->query($update) === TRUE) {
                                                } else {
                                                    echo "Error: " . $sql . "<br>" . mysqli_error($db);
                                                }
                                                echo "Rp " . $payment . ".00,-";
                                                ?></h2>
                </div>
                <h3 style="margin-bottom : 20px; color: white;">Status</h3>
                <h4 style="color: white; padding-bottom: 50px">
                    <div class="col" style="margin-bottom : 20px; padding: 20px; content:center; border-radius: 25px;  border: 2px solid #73AD21;width: 100%; background: 
                <?php if ($statusPayment == "verified") {
                    echo "#fcba03" ?>"><?php echo '<h2 style="color: #32a852;"> Verified</h2>';
                                    }
                                    if ($statusPayment == "unverified") {
                                        echo "#fc0303" ?>"> <?php echo '<h2 style="color:white;"> Unverified</h2>';
                                                        } ?>

                    </div>
                    <?php if ($statusPayment == "verified") {
                        echo '<form style="float:right;padding-top: 20px;" action="index.php">
                    <button type="submit" class="btn btn-warning" style="color: #32a852;">Go to Home</button>
                </form>';
                    } ?>

                </h4>


            </div>


        </div>

    </div>
</div>

</body>
<script type="text/javascript">
    setTimeout(function() {
        window.location.reload(1);
    }, 3000);
</script>