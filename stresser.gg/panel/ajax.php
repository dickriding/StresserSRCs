<?php
/*header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");*/

ob_start();

session_start();

include("config.php");

include("config2.php");

if (@$_POST["sonsaldırı"] != Null) {

	if (!isset($_SESSION["id"])) {

		exit;
	}

	$userid = $_SESSION["id"];

	$data = mysqli_query($baglanti, "select * from log where user='$userid' ORDER BY id DESC LIMIT 15");

	while ($satir = mysqli_fetch_array($data)) {

		$tarih1 = strtotime($satir["sonlanma"]);

		$tarih2 = strtotime(date("Y-m-d H:i:s"));

		$fark = $tarih1 - $tarih2;

		if ($fark < 0) {

			$fark = 0;
		}


		$data2XX = mysqli_query($baglanti, "select * from method where kate='Layer7' ORDER BY id ASC");
		$l7methodsx = [];
		while ($satir2XX = mysqli_fetch_array($data2XX)) {

			array_push($l7methodsx, $satir2XX["method"]);
		}



		if (strtotime($satir["sonlanma"]) < strtotime(date("Y-m-d H:i:s"))) { ?>

			<tr>

			<?php } else { ?>

			<tr style="background-color:rgba(28, 15, 69)">

			<?php  }

			?>



			<td>
				<div class="td-content product-name"><?php echo $satir["ip"]; ?>
					<?php
					if (!in_array($satir["method"], $l7methodsx)) {
						echo ":" . $satir["port"];
					}
					?></div>
			</td>

			<td>
				<div class="td-content"><span class="discount-pricing">

						<?php if (strtotime($satir["sonlanma"]) < strtotime(date("Y-m-d H:i:s"))) { ?><?php echo $satir["sure"]; ?><?php } else { ?> <?php echo $fark ?><?php } ?> </span></div>
			</td>

			<td>
				<div class="td-content"><?php echo $satir["method"]; ?></div>
			</td>

			<td>
				<div class="td-content">

					<?php if (strtotime($satir["sonlanma"]) < strtotime(date("Y-m-d H:i:s"))) { ?>

						Expired

					<?php } else { ?>

						Running

					<?php  } ?>

				</div>
			</td>

			<td>
				<div class="td-content" style="text-align:center!important;">

					<?php if (strtotime($satir["sonlanma"]) < strtotime(date("Y-m-d H:i:s"))) { ?>

						<a href="?renew=<?php echo $satir["id"]; ?>"> <span class="badge badge-success"> <i class="fa fa-refresh" aria-hidden="true"></i> </span></a>

					<?php } else { ?>

						<a href="?stop=<?php echo $satir["id"]; ?>"> <span class="badge badge-danger"> <i class="fa fa-stop-circle"></i> </span></a></a>

					<?php  } ?>

				</div>
			</td>

			</tr>

	<?php

	}
}

	?>