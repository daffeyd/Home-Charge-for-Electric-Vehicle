<div class="container" style="padding: 20px; margin-top: 30px; border-radius: 25px;  border: 2px solid #73AD21;width:100%;">

    <h1 style="padding: 20px; width:100%;color: #32a852">List Machine</h1><br>

    <?php
    $machine = "";
    $query_mysql = mysqli_query($db, "SELECT * FROM `partner` WHERE hostID = $iduser ORDER by id desc ");
    while ($data = mysqli_fetch_array($query_mysql)) {
    ?>
        <div class="container" style="margin-bottom: 10px; padding: 20px;border-radius: 25px;  width:100%; background: #32a852;">
            <div class="row">
                <div class="col">
                    <div style="height:auto; padding: 20px;border-radius: 25px; width:100%; background: #3b6128;">
                        <h6 style="color: white;">Machine Id</h6><br>
                        <h4 style="color: white;"><?php echo $data['id']; ?></h4>
                    </div>
                </div>

                <div class="col">
                    <div style="padding: 20px;border-radius: 15px;width:100%; background: #3b6128;">
                        <h6 style="color: white;">Status :
                            <?php
                            $machine = $machine . $data['id'];
                            $idM = $data['id'];
                            $machineStatus = $data['status'];
                            if ($machineStatus == 0) {
                                echo "Free</h6>
                                        </div>";
                            }
                            if ($machineStatus == 1) {
                                echo "Booked</h6>
                                        </div>";
                            }
                            if ($machineStatus == 2) {
                                echo 'Need Verification</h6>
                                        </div><button id="verif' . $idM . '"  type="submit" class="btn btn-warning" style="width:100%; margin-top:10px; float:right ; border-radius: 15px; color: #32a852;">Verify</button>';
                            }
                            ?>
                    </div>
                </div>
                <div style="margin-top: 10px;padding: 20px;border-radius: 15px;width:100%; background: #3b6128;">
                    <h6 style="color: white;">Address : <?php echo $data['alamat']; ?></h6>
                </div>
            </div>
        <?php } ?>
        </div>


        </body>
        <?php
        $numMachine = strlen($machine);
        $machine = str_split($machine);
        for ($i = 0; $i < $numMachine; $i++) {
            echo '
        <script type="text/javascript">
            document.getElementById("verif' . $machine[$i] . '").onclick = function() {
                location.href = "payVerif.php?idM=' . $machine[$i] . '";
            };
        </script>';
        }

        ?>