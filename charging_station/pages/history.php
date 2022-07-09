<div class="container" style="padding: 20px; content:center;margin-top: 30px; border-radius: 25px;  border: 2px solid #73AD21;width:100%; height: wrap-content">
    <div class="container">
        <div style="color: #32a852">
            <div style="padding: 20px; content:center;margin-top: 30px; width:100%">
                <h1>Hello,<?php echo $nama ?>!</h1><br>
            </div>
            <div style="padding: 20px; content:center; border-radius: 25px;  border: 2px solid #73AD21;width:100%; background: #32a852;">
                <h3 style="color: white;margin-left:20px; margin-bottom: 20px">History</h3>
                <?php
                $limit = 5;
                $pages = isset($_GET['pages']) ? (int)$_GET['pages'] : 1;
                $halaman_awal = ($pages > 1) ? ($pages * $limit) - $limit : 0;

                $previous = $pages - 1;
                $next = $pages + 1;

                $numData = mysqli_query($db, "SELECT * FROM `history` WHERE iduser = $iduser ORDER by idTransaction desc ");
                $jumlah_data = mysqli_num_rows($numData);
                $total_halaman = ceil($jumlah_data / $limit);

                $query_mysql = mysqli_query($db, "SELECT * FROM `history` WHERE iduser = $iduser ORDER by idTransaction desc limit $halaman_awal, $limit");
                $nomor = $halaman_awal + 1;

                while ($data = mysqli_fetch_array($query_mysql)) {
                    $idTransaction = $data['idTransaction'];
                    $idM = $data['idM'];
                    $duration = $data['duration'];
                    $paymentType = $data['paymentType'];
                    $paymentStatus = $data['paymentStatus'];
                    $totalPayment = $data['totalPayment'];

                    $sql = "SELECT * FROM partner WHERE id='$idM'";
                    $result = mysqli_query($db, $sql);

                    if (mysqli_num_rows($result) === 1) {
                        $row = mysqli_fetch_assoc($result);
                        $address = $row['alamat'];
                    }
                ?>
                    <div class="container" style="margin-bottom: 10px; border-radius: 25px;  width:100%; background: #32a852;">
                        <div style="margin-top: 10px;padding: 20px;border-radius: 15px;width:100%; background: #3b6128;">

                            <div  style="line-height: 100px; ">
                                <div style=" display: inline-block;line-height: normal;vertical-align: middle;">
                                    <h6 style="color: white;">Transaction ID <?php echo  $idTransaction; ?></h6>
                                    <h6 style="color: white;">Payment Type : <?php echo  $paymentType; ?>, Payment Status : <?php echo  $paymentStatus; ?></h6>
                                    <h6 style="color: white;">Address : <?php echo  $address; ?></h6>
                                    <h6 style="color: white;">Machine ID : <?php echo  $idM;  ?>, Duration : <?php echo  $duration; ?> Hour </h6>
                                    <h6 style="color: white;">Total Payment : Rp <?php echo $totalPayment ?>.00,-</h6>
                                </div>
                            </div>

                        </div>


                    </div>

                <?php
                }


                ?>
                	<nav>
			<ul class="pagination justify-content-center">
				<li class="page-item">
					<a class="page-link" <?php if($pages > 1){ echo "href='?p=history&pages=$previous'"; } ?>>Previous</a>
				</li>
				<?php 
				for($x=1;$x<=$total_halaman;$x++){
					?> 
					<li class="page-item"><a class="page-link" href="?p=history&pages=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>				
				<li class="page-item">
					<a  class="page-link" <?php if($pages < $total_halaman) { echo "href='?p=history&pages=$next'"; } ?>>Next</a>
				</li>
			</ul>
		</nav>
            </div>
        </div>
    </div>
</div>
</body>