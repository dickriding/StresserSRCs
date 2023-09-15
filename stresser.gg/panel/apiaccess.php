<?php
include("header.php");
@ob_start();
?>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">
       				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12  layout-spacing">
                        <div class="widget widget-table-three">
                            <div class="widget-heading">
                                <h5 class="">API Access</h5>
                            </div>
<?php
$sipxr = @mysqli_query($baglanti, "SELECT apiWhitelistIP, apiKey FROM user WHERE id='$userid'");
$sipxr = $sipxr->fetch_assoc();

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
							

                            <div class="widget-content">
							<?php
								if(isset($_POST["updateWhitelistIP"])) {
									if(isset($_POST["ipAddress"])) {
										$ipv4 = $_POST["ipAddress"];
										if(filter_var($ipv4, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
											$baglanti->query("UPDATE user SET apiWhitelistIP = '$ipv4' WHERE id='$userid'");
											$msg = "Whitelisted IP was successfully updated";
											header("refresh:2;url=apiaccess");
										} else {
											$msg = "You should provide a valid IPv4 address";
											header("refresh:2;url=apiaccess");
											header("refresh:2;url=apiaccess");
										}
									} else {
										$msg = "Please fill all fields";
										header("refresh:2;url=apiaccess");
									}
									echo '<div class="alert alert-outline-primary mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>'.$msg.'</div>';
								}
							?>
							<?php
								if(isset($_POST["regenerateApiKey"])) {
									$randomKey = generateRandomString(5)."-".generateRandomString(5)."-".generateRandomString(5)."-".generateRandomString(5)."-".generateRandomString(5);
									$baglanti->query("UPDATE user SET apiKey = '$randomKey' WHERE id='$userid'");

									$msg = "API key was successully regenerated";
									header("refresh:2;url=apiaccess");
									/*if(isset($_POST["ipAddress"])) {
										$ipv4 = $_POST["ipAddress"];
										if(filter_var($ipv4, FILTER_VALIDATE_IP)) {
											$baglanti->query("UPDATE user SET apiWhitelistIP='$ipv4' WHERE id='$userid'");
											$msg = "Whitelisted IP was successfully updated";
										} else {
											$msg = "You should provide a valid IPv4 address"
										}
									} else {
										$msg = "Please fill all fields";
									}*/
									echo '<div class="alert alert-outline-primary mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>'.$msg.'</div>';
								}
							?>


															<div class="form-row mb-4">
																<div class="col-12"><br>
																<form action="" method="POST">
																	<label>API Key</label>
																		<input type="text" readonly class="form-control" value="<?=($sipxr["apiKey"] ? $sipxr["apiKey"] : "Regenerate API Key")?>" disabled><br>
																	</div>
																	<input type="submit" name="regenerateApiKey" value="Regenerate API Key" class="btn btn-primary">
																</form>
																
																<div class="col-12"><br>
																<form action="" method="POST">
																	<label>Whitelisted IP</label>
																		<input type="text" class="form-control" name="ipAddress" value="<?=($sipxr["apiWhitelistIP"] ? $sipxr["apiWhitelistIP"] : "Set a Whitelisted IP")?>"><br>
																	</div>
																	<input type="submit" name="updateWhitelistIP" value="Update Whitelisted IP" class="btn btn-primary">
																</form>
															</div>

															
															
                            </div>
                        </div>
						
                    </div>



					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
<div class="widget widget-table-three">
<div class="widget-heading">
<h5 class="">API Documentation</h5>
</div>
<div class="widget-content">
<div class="table-responsive">
<label>Launch Attack</label>
<input type="text" class="form-control" value="http://api.stresser.gg/?key=<?=($sipxr["apiKey"] ? $sipxr["apiKey"] : "Not Setted")?>&action=start&host=1.3.3.7&port=80&time=30&method=NTP" readonly disabled />
</br>
<label>Stop Attack</label>
<input type="text" class="form-control" value="http://api.stresser.gg/?key=<?=($sipxr["apiKey"] ? $sipxr["apiKey"] : "Not Setted")?>&action=stop&id={ID}" readonly disabled />
</br>
<label>Renew Attack</label>
<input type="text" class="form-control" value="http://api.stresser.gg/?key=<?=($sipxr["apiKey"] ? $sipxr["apiKey"] : "Not Setted")?>&action=renew&id={ID}" readonly disabled />
</br></br>

<label>Classic Methods</label><br/>
<?php
$sipxrr = @mysqli_query($baglanti, "SELECT * FROM method WHERE node = 'Classic'");
$sipxrr = $sipxrr->fetch_all();



foreach($sipxrr as $method) {
	echo '<span class="badge badge-dark" style="margin-left: 5px; margin-top: 5px"> '.$method[2].' </span>';
	//echo '<input type="submit" value="'.$method[2].' '.($method[4] == "VIP" ? "VIP" : "Normal").'" class="btn btn-primary" style="margin: 5px !important" />';
	//echo $method[2]." (".($method[4] == "VIP" ? "VIP" : "Normal")."), ";
}


?></br></br>

<label>Premium Methods</label><br/>
<?php
$sipxrrs = @mysqli_query($baglanti, "SELECT * FROM method WHERE node = 'VIP'");
$sipxrrs = $sipxrrs->fetch_all();



foreach($sipxrrs as $method) {
	echo '<span class="badge badge-dark" style="margin-left: 5px; margin-top: 5px"> '.$method[2].' </span>';
	//echo '<input type="submit" value="'.$method[2].' '.($method[4] == "VIP" ? "VIP" : "Normal").'" class="btn btn-primary" style="margin: 5px !important" />';
	//echo $method[2]." (".($method[4] == "VIP" ? "VIP" : "Normal")."), ";
}


?></br></br>
</div>
</div>
</div>
</div>


                </div>
            </div>
			<?php include("footer.php"); ?>
			<script type="text/javascript">
				$(document).ready(function () {
					setInterval(() => {
						$(".alert-outline-primary").show();
					}, 100)
				})
			</script>
			
       