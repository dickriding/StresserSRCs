<?php include("header.php"); 
	if( isset($_POST["secret_code"])){


	$secret_code=htmlentities($_POST["secret_code"], ENT_QUOTES, "UTF-8");

	if($_POST["pass"]!=Null){
	$pass=htmlentities($_POST["pass"], ENT_QUOTES, "UTF-8");	
	$pass=md5($pass);
			$baglanti->query("UPDATE user SET  secret_code='$secret_code',pass='$pass' WHERE id='$userid'");
	}
else{
	$baglanti->query("UPDATE user SET  secret_code='$secret_code' WHERE id='$userid'");
}	
	

		header("Location: profile?process=success");
exit;
											


}
?>
		
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">

       <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 m-auto layout-spacing">
                        <div class="widget widget-table-three">

                            <div class="widget-heading">
                                <h5 class="">Profile</h5>
                            </div>

                            <div class="widget-content">
							<?php if(@$_GET["process"]=="success"){
								echo'<div class="alert alert-success">Profile has been successfully updated.</div>';
							}
							?>
                                <form method="post" action="">
                                        <div class="form-row mb-4">
                                            <div class="col-12">
											<label>Secret Code (When you forget your password, you reset your password with the secret code. Do not share with anyone!)</label>
                                                <input type="text" maxlength="4" pattern="[0-9]*" name="secret_code" value="<?php echo $user["secret_code"];?>" required class="form-control" placeholder="Secret Code"><br>
                                            </div>
                                            <div class="col-12">
											<label>Password (Leave blank if no changes are made.)</label>
                                                <input type="password" name="pass"  class="form-control" placeholder="Password"><br>
                                            </div>
                                            <div class="col-12">
											<label>Mail Address</label>
                                                <input type="text"  value="<?php echo $user["mail"];?>" readonly required class="form-control" placeholder="Mail Adress"><br>
                                            </div>
                                            <div class="col-12">
											<label>Username</label>
                                                <input type="text" name="kadi" value="<?php echo $user["kadi"];?>" readonly required class="form-control" placeholder="Username"><br>
                                            </div>
                                          
                                            <!-- <div class="col-12">
											<label>Last Login IP</label> 
                                                <input type="text" value="<?php echo $user["son_ip"];?>" readonly class="form-control" placeholder="loginip"><br>
                                            </div>
                                            <div class="col-12">
											<label>Last Login Date</label>
                                                <input type="text" value="<?php echo $user["son_giris"];?>" readonly class="form-control" placeholder="date"><br>
                                            </div> -->
                                        </div>
                                        <input type="submit" value="Update" class="btn btn-primary">
                                    </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
			<?php include("footer.php"); ?>
       