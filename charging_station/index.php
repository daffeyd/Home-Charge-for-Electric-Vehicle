<?php
session_start();
include 'koneksi.php';
ini_set('date.timezone', 'Asia/Jakarta');
$tgl = date('Y-m-d H:i:s');
$domain = "localhost";

if ((isset($_SESSION['iduser']) && (isset($_SESSION['uname']) && (isset($_SESSION['pass']))))) {
    $iduser = $_SESSION['iduser'];
    $nama = $_SESSION['uname'];

    $sql = "SELECT * FROM members WHERE id='$iduser'";

    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $balance = $row['balance'];
        $idMachine = $row['idM'];
    }
?>
    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- icon fa -->
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        <!-- Bootstrap CSS -->
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="shortcut icon" type="image" href="assets/images/logo.png">
        <link rel="stylesheet" href="main.css">
        <title>Home Charging Electric Vehicle Service</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <a class="navbar-brand" href="index.php"><img src="assets/images/navbar-logo.png" class="img-fluid" alt="logo" style="height : 50px"></a>

            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" style="padding-right: 30px" aria-current="page" href="index.php?p=partner">Become Partner</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" style="padding-right: 30px" aria-current="page" href="index.php?p=profile">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" style="padding-right: 30px" aria-current="page" href="index.php?p=cs">Customer Service</a>
                    </li>
                </ul>
            </div>

        </nav>
        <!-- <nav class="navbar navbar-expand-sm navbar-light bg-light">

            <a class="navbar-brand" href="index.php"><img src="assets/images/navbar-logo.png" class="img-fluid" alt="logo" style="height : 50px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">


                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" style="padding-right: 30px" aria-current="page" href="index.php?p=partner">Become Partner</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" style="padding-right: 30px" aria-current="page" href="index.php?p=profile">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" style="padding-right: 30px" aria-current="page" href="index.php?p=cs">Customer Service</a>
                    </li>
                </ul>

                <form action="logout.php">
                    <button type="submit" class="btn btn-outline-danger">Log Out</button>
                </form>
            </div>


        </nav> -->
        <?php
        $pages_dir = 'pages';
        if (!empty($_GET['p'])) {
            $pages = scandir($pages_dir, 0);
            unset($pages[0], $pages[1]);
            $p = $_GET['p'];
            if (in_array($p . '.php', $pages)) {
                include($pages_dir . '/' . $p . '.php');
            } else {
                echo 'Halaman Tidak Ditemukan';
            }
        } else {
            include($pages_dir . '/home.php');
        }
        ?>


    </html><?php
        } else {
            ?>
    <a href="login.php">Login Page</a>
<?php
        }
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>