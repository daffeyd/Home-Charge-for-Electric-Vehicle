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
}
$update = "UPDATE history SET paymentStatus='unverified' WHERE idTransaction = '$idTransaction'";
if ($db->query($update) === TRUE) {
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
} ?>
<div class="container" style="padding: 20px;margin-top: 30px; border-radius: 25px;  border: 2px solid #73AD21;width:100%;">
    <div class="container">
        <div style="padding: 20px; content:center; width:100%">
            <h2 style="margin-bottom: 20px; color: #32a852;">Transaction Receipt</h2>

            <div style="padding: 20px; border-radius: 25px;  border: 2px solid #73AD21;width:100%; background: #32a852;">

                <h4 style="margin-bottom : 20px; color: white;">Total Payment</h4>
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
                <h3 style="margin-bottom : 20px; color: white;">Cost Breakdown</h3>
                <h4 style="color: white; padding-bottom: 50px">
                    Start Time : <?php echo $startTime ?><br>
                    End Time : <?php echo $endTime ?><br>
                    Duration : <?php echo $duration ?><br>
                    kWh Used : Machine Capacity x Duration<br>
                    kWh Used : <?php echo $machineCapacity ?> x <?php echo $duration ?> <br>
                    kWh Used : <?php $kwhUsed =  $machineCapacity * $duration;
                                echo $kwhUsed ?> <br>
                    Total Payment : Price /kWh X kWh Used<br>
                    Total Payment : <?php echo $multiplier ?> x <?php echo $kwhUsed ?> <br>
                    Total Payment : <?php echo "Rp " . $payment . ".00,-"; ?> <br>
                    <div style="float:right;padding-top: 20px;">
                        <button id="cash" type="submit" class="btn btn-secondary" style="color: white;">Cash</button>
                        <button id="home-chargePay" type="submit" class="btn btn-warning" style="color: #32a852;" <?php if ($balance < $payment) {
                                                                                                                        echo "disabled";
                                                                                                                    } ?>>With Home-Charge Balance</button>


                    </div>


                </h4>


            </div>


        </div>

    </div>
</div>

</body>
<script type="text/javascript">
    document.getElementById("home-chargePay").onclick = function() {
        location.href = "index.php?p=verif&idM=<?php echo $idM; ?>&idTr=<?php echo $idTransaction; ?>&method=Home-chargePay";
    };
    document.getElementById("cash").onclick = function() {
        location.href = "index.php?p=verif&idM=<?php echo $idM; ?>&idTr=<?php echo $idTransaction; ?>&method=Cash";
    };
</script>