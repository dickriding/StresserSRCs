<?php include("header.php"); 
if(@$_GET["al"]!=Null){
	
	$sipid=htmlentities($_GET["al"], ENT_QUOTES, "UTF-8");
	$sip = @mysqli_query($baglanti,"select * from paketler where id='$sipid'");
	$sip = $sip->fetch_assoc();
	if($sip["fiyat"]>$user["bakiye"]){
		header("Location: ?process=error");
		exit;
	}
	$uyelik=$sip["id"];
	if($sip["zaman"]=="Lifetime"){
								$uyelik_son="0";
							}
							elseif($sip["zaman"]=="Day"){ 
								$uyelik_son=date("Y-m-d", strtotime("+".$sip["sure"]." day"));
							}
							elseif($sip["zaman"]=="Week"){ 
								$uyelik_son=date("Y-m-d", strtotime("+".$sip["sure"]." week"));
							}
							elseif($sip["zaman"]=="Month"){ 
								$uyelik_son=date("Y-m-d", strtotime("+".$sip["sure"]." month"));
							}
							elseif($sip["zaman"]=="Year"){ 
								$uyelik_son=date("Y-m-d", strtotime("+".$sip["sure"]." year"));
							}
	$newbal=$user["bakiye"]-$sip["fiyat"];
	$baglanti->query("UPDATE user SET  bakiye='$newbal', uyelik='$uyelik', uyelik_son='$uyelik_son' WHERE id='$userid'");
		header("Location: ?process=success");
		exit;
}
?>
 <link rel="stylesheet" type="text/css" href="boostrap/css/boostrap.min.css">  
 <link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">  
 <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
 <link href="plugins/pricing-table/css/component.css" rel="stylesheet" type="text/css"/>

        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">	
			</div>

       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-three">

                            <div class="widget-heading">
                                <h5 class="">Plans</h5>
                            </div>


                            <div class="widget-content">
							<?php if(@$_GET["process"]=="error"){
								echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Not enough funds available to purchase this product.</div>';
							} if(@$_GET["process"]=="success"){
								echo '<div class="alert alert-outline-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>The package has been purchased successfully.</div>';
							}
							if($user["uyelik_son"]!=Null){
								if($user["uyelik_son"]=="0"){
									$user["uyelik_son"]="Lifetime";
								}
								echo '<div class="alert alert-outline-primary mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i><b>'.$user["uyelik_son"].'</b> - You have a plan purchased until the date.. If you get a new plan, this plan will be canceled.</div>';
							}					
							?>
							        <div class="row">
                <div class="col-lg-12">  <table id="default-ordering" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">Plan Name</th>
                                        <th style="text-align:center;">Price</th>
                                        <th style="text-align:center;">Length</th>
                                        <th style="text-align:center;">Concurrent</th>
                                        <th style="text-align:center;">Stress Time</th>
										<th style="text-align:center;">Premium Network</th>
										<th style="text-align:center;">API Access</th>
                                        <th class="text-center dt-no-sorting">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
									
						<?php
							  $data=mysqli_query($baglanti,"select * from paketler WHERE isHidden = 0 ORDER BY id ASC"); 
												while($satir=mysqli_fetch_array($data))
												{
													if($satir["zaman"]=="Lifetime"){
														$sure="Lifetime";
													}
													else{
														$sure=$satir["sure"]." ".$satir["zaman"];
													}

													if($satir["node"] == "VIP"){
														$satirSonuc = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
													}else{
														$satirSonuc = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
													}
													if($satir["apiAccess"] == "1"){
														$satirSonuc2 = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
													}else{
														$satirSonuc2 = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
													}
													?>       
													<tr>
                                        <td style="text-align:center;"><?php echo $satir["ad"];?></td>
                                        <td style="text-align:center;"><?=((intval($satir["fiyat"]) == 0 ? "Free" : "€".$satir["fiyat"]))?></td>
                                        <td style="text-align:center;"><?php echo $sure;?></td>
                                        <td style="text-align:center;"><?php echo $satir["es_zaman"];?></td>
                                        <td style="text-align:center;"><?php echo $satir["max_sure"];?></td>
										<td style="text-align:center;"><?php echo $satirSonuc ?></td>
										<td style="text-align:center;"><?php echo $satirSonuc2 ?></td>
                                        <td class="text-center"><a href="?al=<?php echo $satir["id"];?>"> <button class="btn btn-outline-success mb-2" style="margin-top: 9px;">Buy Now</button></a></td>
                                    </tr>
									
														
													<?php
													
												}
							?>
								</tbody>
								
								</table>
          
                </div>
            </div>
                            </div>
                        </div>
                    </div>

                </div>
				<?php include("footer.php"); ?>
            </div>
			<script type="text/javascript">
				$(document).ready(function () {
					setInterval(() => {
						$(".alert-outline-primary").show();
					}, 100)
				})
			</script>
       