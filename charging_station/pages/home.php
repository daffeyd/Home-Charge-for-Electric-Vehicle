<div class="container" style="padding: 20px; content:center;margin-top: 30px; border-radius: 25px;  border: 2px solid #73AD21;width:100%; height: wrap-content">
    <div class="container">
        <div style="margin-bottom:30px;" class="row">
            <div style="color: #32a852" class="col-md-6">
                <div style="padding: 20px; content:center;margin-top: 30px; width:100%">
                    <h1>Hello,<?php echo $nama ?>!</h1><br>
                </div>
                <div style="padding: 20px; content:center; border-radius: 25px;  border: 2px solid #73AD21;width:100%; background: #32a852;">
                    <h3 style="color: white;">Home-Charge Pay Balance,</h3><br>
                    <h2 style="color: white;">Rp <?php echo $balance ?></h2>
                </div>
            </div>
            <div class="col">
                <a style="text-decoration: none;" href="index.php?p=search"><i style="margin-bottom : 20px ;color: #32a852; position: relative;top: 50%;left: 50%;transform: translate(-50%, -50%);" class="fa fa-search fa-4x" aria-hidden="true"></i>
                    <h4 style="color: #32a852; text-align: center; position: relative; top: 50%;left: 50%;transform: translate(-50%, -50%);">Search</h4>
                </a>
            </div>
            <div class="col">
                <a style="text-decoration: none;" href="index.php?p=inputId"><i style="margin-bottom : 20px ;color: #32a852; position: relative;top: 50%;left: 50%;transform: translate(-50%, -50%);" class="fa fa-qrcode fa-4x" aria-hidden="true"></i></a>
                <h4 style="color: #32a852; text-align: center; position: relative; top: 50%;left: 50%;transform: translate(-50%, -50%);">Scan QR Code</h4>
            </div>
            <div class="col">
                <a style="text-decoration: none;" href="index.php?p=history"><i style="margin-bottom : 20px ;color: #32a852; position: relative;top: 50%;left: 50%;transform: translate(-50%, -50%);" class="fa fa-history fa-4x" aria-hidden="true"></i>
                    <h4 style="color: #32a852; text-align: center; position: relative; top: 50%;left: 50%;transform: translate(-50%, -50%);">History</h4>
                </a>
            </div>
            <?php
            if (strlen($idMachine) >= 2)
                echo '
            <div class="col">
            <a style="text-decoration: none;" href="index.php?p=machine"><i style="margin-bottom : 20px ;color: #32a852; position: relative;top: 50%;left: 50%;transform: translate(-50%, -50%);" class="fa fa-cogs fa-4x" aria-hidden="true"></i>
                <h4 style="color: #32a852; text-align: center; position: relative; top: 50%;left: 50%;transform: translate(-50%, -50%);">Machine</h4>
            </a>
        </div>'
            ?>
        </div>
    </div>
</div>