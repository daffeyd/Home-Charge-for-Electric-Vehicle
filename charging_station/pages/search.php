<div class="container" style="padding: 20px; content:center;margin-top: 30px; border-radius: 25px;  border: 2px solid #73AD21;width:100%; height: wrap-content">
    <div class="container">
        <div style="color: #32a852">
            <div style="padding: 20px; content:center;margin-top: 30px; width:100%">
                <h1>Hello,<?php echo $nama ?>!</h1><br>
            </div>
            <div style="padding: 20px; content:center; border-radius: 25px;  border: 2px solid #73AD21;width:100%; background: #32a852;">
                <h3 style="color: white;margin-left:20px">Charging Place Near Your Location</h3>
                <?php
                if (isset($_GET['lat'])) {
                    $machine = "";
                    $latitude = $_GET['lat'];
                    $longitude = $_GET['lon'];
                    $distance = 10;
                    $distanceQuery = "SELECT *, (((acos(sin(($latitude*pi()/180)) * sin((`latitude`*pi()/180)) + cos(($latitude*pi()/180)) * cos((`latitude`*pi()/180)) * cos((($longitude- `longitude`)*pi()/180)))) * 180/pi()) * 60 * 1.1515) as distance FROM `partner` HAVING distance <= $distance";
                    $query_mysql = mysqli_query($db, $distanceQuery);
                    while ($data = mysqli_fetch_array($query_mysql)) {
                        $latitudeMachine = $data['latitude'];
                        $longitudeMachine = $data['longitude'];
                        $details = $data['details'];
                        $address = $data['alamat'];
                        $machine = $machine . $data['id'];
                        $idM = $data['id'];
                ?>
                        <div class="container" style="margin-bottom: 10px; border-radius: 25px;  width:100%; background: #32a852;">
                            <div style="margin-top: 10px;padding: 20px;border-radius: 15px;width:100%; background: #3b6128;">
                                <div class="row">
                                    <div class="col-md-8" style="line-height: 100px; ">
                                        <div style=" display: inline-block;line-height: normal;vertical-align: middle;">
                                            <h6 style="color: white;">Address : <?php echo  $address; ?></h6>
                                            <h6 style="color: white;">Latitude : <?php echo  $latitudeMachine;  ?>, Longitude : <?php echo  $longitudeMachine; ?>
                                            </h6>
                                            <h6 style="color: white;">Details : <?php echo $details ?></h6>
                                        </div>
                                    </div>

                                    <div class="col" style=" text-align: center;  height: 100px; line-height: 100px; ">
                                        <button id="destination<?php echo $idM; ?>" type="submit" class="btn btn-warning " style=" display: inline-block;line-height: normal;vertical-align: middle;color: white;"><i style="color:#3b6128;" class="fa fa-paper-plane-o fa-4x" aria-hidden="true"></i></button>

                                    </div>
                                    <script type="text/javascript">
                                        <?php

                                        if (isset($_GET['lat'])) {

                                            echo '
                                                    document.getElementById("destination' .  $idM . '").onclick = function() {
                                             window.location.replace("https://www.google.com/maps/place/' . $latitudeMachine . ',' . $longitudeMachine . '")}';
                                        }
                                        ?>
                                    </script>
                                </div>
                            </div>


                        </div>

                <?php
                    }
                } ?>
            </div>
        </div>
    </div>
</div>

<p id="demo"></p>

</body>

<script type="text/javascript">
    var x = document.getElementById("demo");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {}

    function showPosition(position) {
        <?php
        if (!isset($_GET['lat'])) {
        ?>
            window.location.replace("http://localhost/charging_station/index.php?p=search&lat=" + position.coords.latitude + "&lon=" + position.coords.longitude + "");
        <?php
        }
        ?>
    }
</script>