<?php
include("header.php");
$coins = ["BTC", "LTC", "ETH", "USDT", "XMR"];
?>

<div id="content" class="main-content">
	<div class="layout-px-spacing">
		<div class="row layout-top-spacing">
			<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12  layout-spacing">
				<div class="widget widget-table-three">
					<div class="widget-heading">
						<h5 class="">Add Balance</h5>
					</div>

					<div class="widget-content">
						<?php
						echo '<div class="alert alert-outline-primary mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Our payment system works as automation, when you successfully complete the payment, the amount you have added to your account will be added to your account within <b>15-30 minutes</b>.</div>';
						?>

						<?php
						$minimum = 5;
						$maximum = 3000;
						$minimumeth = 50;
						if (@$_POST["bakiye"] != Null) {
							if(!is_numeric($_POST["bakiye"])) {
								header("Location: ?process=invalid");
								exit;
							}
							$coin = (isset($_POST["coin"]) ? $_POST["coin"] : "BTC");
							$tarih = date("Y-m-d H:i:s");

							if ($coin == "ETH") {
								$minimum = 50;
								if ($_POST["bakiye"] < $minimum || $_POST["bakiye"] > $maximum) {
									header("Location: ?process=ethlimit");
									exit;
								}
							} else {
								if ($_POST["bakiye"] < $minimum || $_POST["bakiye"] > $maximum) {
									header("Location: ?process=smallamount");
									exit;
								}
							}

							if (!in_array($coin, $coins)) {
								header("Location: ?process=invalid");
								exit;
							}
							if (date("YmdHis") < $_SESSION["bakiye"]) {
								header("Location: ?process=cooldown");
								exit;
							}
							$_SESSION["bakiye"] = date("YmdHis", strtotime("+2 minute"));
							$bakiye = htmlentities($_POST["bakiye"], ENT_QUOTES, "UTF-8");
							require('pay/coinpayments.inc.php');
							$cps = new CoinPaymentsAPI();
							$cps->Setup($ayar["coinpayments_private"], $ayar["coinpayments_public"]);
							$benzersiz = $user["id"] . "a" . $bakiye . "a" . rand();

							$req = array(
								'amount' => $bakiye,
								'currency1' => 'EUR',
								'currency2' => $coin,
								'buyer_email' => $user["mail"],
								'item_name' => 'Stresser.gg Funds (' . $bakiye . ' EUR)',
								'address' => '',
								'custom' => $benzersiz,
								'ipn_url' => $site . 'panel/pay-callback.php',
								'success_url' => $site . 'panel/addbalance?process=1',
								'cancel_url' => $site . 'panel/addbalance?process=0'
							);
							$result = $cps->CreateTransaction($req);
							if ($result['error'] == 'ok') {
								$le = php_sapi_name() == 'cli' ? "\n" : '<br />';
								$tarih = date("Y-m-d H:i:s");
								$baglanti->query("INSERT INTO odeme (user, miktar, tarih, durum,benzersiz) VALUES ('$userid', '$bakiye', '$tarih', '0','$benzersiz')"); ?>

								<center><img src="<?php echo $result['result']['qrcode_url']; ?>" style="width:150px;"></center>
								<div class="form-row mb-4">
									<div class="col-12"><br>
										<label>Amount to pay</label>
										<input type="text" readonly class="form-control" value="<?php echo $result['result']['amount']; ?>"><br>
									</div>
									<div class="col-12"><br>
										<label>Payment address</label>
										<input type="text" readonly class="form-control" value="<?php echo $result['result']['address']; ?>"><br>
									</div>
								</div>
							<?php
								/*header("Location: ".$result['result']['status_url']);
										exit;*/
							} else {
								print 'Error: ' . $result['error'] . "\n";
							}
						} else { ?>

							<?php if (@$_GET["process"] == "0") {
								echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Payment transaction failed.</div></div>';
							}
							if (@$_GET["process"] == "1") {
								echo '<div class="alert alert-outline-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Payment transaction completed successfully.</div>';
							}
							/*if (@$_GET["process"] == "gk") {
								echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Enter the catpcha code correctly.</div>';
							}*/
							if (@$_GET["process"] == "cooldown") {
								echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>To make a new transaction, you have to wait 2 minutes.</div>';
							}
							if (@$_GET["process"] == "invalid") {
								echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>You\'ve selected invalid crypto currency, please try again correctly.</div>';
							}
							if (@$_GET["process"] == "smallamount") {
								echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Amount too small. You can add funds minimum €' . $minimum . ', maximum €' . $maximum . '</div>';
							}
							if (@$_GET["process"] == "ethlimit") {
								echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Amount too small. You can add funds minimum €' . $minimumeth . ', maximum €' . $maximum . '</div>';
							}


							?>
							<form method="post" action="">
								<div class="form-row mb-4">
									<div class="input-group mb-4" style="width: 99%;">
										<div class="input-group-prepend" style="margin-left:5px;">
											<span class="input-group-text">€</span>
										</div>
										<input type="text" pattern="[0-9.]*" name="bakiye" required class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="Amount">
										<div class="input-group-append">
										</div>
									</div>
									<div class="col-12">
										<select class="form-control ceviz" name="coin" id="coin">
											<?php foreach ($coins as $coin) : ?>
												<option value="<?= $coin ?>"><?= $coin . ($coin == "LTC" ? " (no fee)" : "") ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<input type="submit" style="width:100%;" value="Add" class="btn btn-primary">
							</form>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
				<div class="widget widget-table-three">
					<div class="widget-heading">
						<h5 class="">Payments History</h5>
					</div>
					<div class="widget-content">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th style="text-align: center;">Amount</th>
										<th style="text-align: center;">Date</th>
										<th style="text-align: center;">Status</th>
									</tr>
								</thead>
								<tbody id="tabloliste">
									<?php
									$data = mysqli_query($baglanti, "select * from odeme where user='$userid' ORDER BY id DESC LIMIT 15");
									while ($satir = mysqli_fetch_array($data)) {
										if ($satir['durum'] == "0") {
											$durum = "<span class='badge badge-dark'> Waiting </span>";
										} elseif ($satir['durum'] == "2") {
											$durum = "<span class='badge badge-danger'> Canceled </span>";
										} elseif ($satir['durum'] == "3") {
											$durum = "<span class='badge badge-warning'> Pending </span>";
										} else {
											$durum = "<span class='badge badge-success'> Completed </span>";
										}
										echo '
											<tr>
												<td style="text-align: center;">€' . $satir['miktar'] . '</td>
												<td style="text-align: center;">' . $satir['tarih'] . '</td>
												<td style="text-align: center;">' . $durum . '</td>
											</tr>';
									} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include("footer.php"); ?>
	<script type="text/javascript">
		$(document).ready(function() {
			setInterval(() => {
				$(".alert-outline-primary").show();
			}, 100)
		})
	</script>