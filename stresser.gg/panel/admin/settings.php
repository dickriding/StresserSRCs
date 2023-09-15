<?php include("header.php");
	$ayar = @mysqli_query($baglanti,"select * from ayarlar where id='1'");
	$ayar = $ayar->fetch_assoc();
	if(isset($_POST["ad"])){


	$ad=htmlentities($_POST["ad"], ENT_QUOTES, "UTF-8");
	$coinpayments_private=htmlentities($_POST["coinpayments_private"], ENT_QUOTES, "UTF-8");
	$coinpayments_public=htmlentities($_POST["coinpayments_public"], ENT_QUOTES, "UTF-8");
	$coinpayments_merchant=htmlentities($_POST["coinpayments_merchant"], ENT_QUOTES, "UTF-8");
	$coinpayments_secret=htmlentities($_POST["coinpayments_secret"], ENT_QUOTES, "UTF-8");		
	$smtp_host=htmlentities($_POST["smtp_host"], ENT_QUOTES, "UTF-8");		
	$smtp_username=htmlentities($_POST["smtp_username"], ENT_QUOTES, "UTF-8");		
	$smtp_pass=htmlentities($_POST["smtp_pass"], ENT_QUOTES, "UTF-8");		
	$smtp_mail=htmlentities($_POST["smtp_mail"], ENT_QUOTES, "UTF-8");		
	$description=htmlentities($_POST["description"], ENT_QUOTES, "UTF-8");		
	$keyword=htmlentities($_POST["keyword"], ENT_QUOTES, "UTF-8");		
	$bakim=htmlentities($_POST["bakim"], ENT_QUOTES, "UTF-8");		
		if ($baglanti->query("UPDATE ayarlar SET  ad='$ad',coinpayments_private='$coinpayments_private',coinpayments_public='$coinpayments_public',coinpayments_merchant='$coinpayments_merchant',coinpayments_secret='$coinpayments_secret',smtp_host='$smtp_host',smtp_username='$smtp_username',smtp_pass='$smtp_pass',smtp_mail='$smtp_mail',description='$description',keyword='$keyword',bakim='$bakim' WHERE id='1'"))

											{

												header("Location: settings");
exit;
											}


}
	?>
  <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Settings</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
		<div class="col-md-12">
		
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Settings</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Website Title</label>
                    <input name="ad" class="form-control"  required value="<?php echo $ayar["ad"]; ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Website Description</label>
                    <input name="description" class="form-control"  required value="<?php echo $ayar["description"]; ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Website Keywords</label>
                    <input name="keyword" class="form-control"  required value="<?php echo $ayar["keyword"]; ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Maintenance Status</label>
					<select class="form-control" name="bakim">
					<option value="0" <?php if($ayar["bakim"]=="0"){ echo "selected";}?>>Passive</option>
					<option value="1" <?php if($ayar["bakim"]=="1"){ echo "selected";}?>>Active</option>
					</select>
                  </div>
				  <div class="row">
				  <div class="col-md-3">
                  <div class="form-group">
                    <label >Coinpayments Private Key</label>
                    <input name="coinpayments_private" class="form-control"  value="<?php echo $ayar["coinpayments_private"]; ?>">
                  </div>
                </div>
				  <div class="col-md-3">
                  <div class="form-group">
                    <label >Coinpayments Public Key</label>
                    <input name="coinpayments_public" class="form-control"  value="<?php echo $ayar["coinpayments_public"]; ?>">
                  </div>
                </div>
				  <div class="col-md-3">
                  <div class="form-group">
                    <label >Coinpayments Merchant ID</label>
                    <input name="coinpayments_merchant" class="form-control"  value="<?php echo $ayar["coinpayments_merchant"]; ?>">
                  </div>
                </div>
				  <div class="col-md-3">
                  <div class="form-group">
                    <label >Coinpayments Secret</label>
                    <input name="coinpayments_secret" class="form-control"  value="<?php echo $ayar["coinpayments_secret"]; ?>">
                  </div>
                </div>
                </div>
				  <div class="row">
				  <div class="col-md-3">
                  <div class="form-group">
                    <label >SMTP Server</label>
                    <input name="smtp_host" class="form-control"  value="<?php echo $ayar["smtp_host"]; ?>">
                  </div>
                </div>
				  <div class="col-md-3">
                  <div class="form-group">
                    <label >SMTP Username</label>
                    <input name="smtp_username" class="form-control"  value="<?php echo $ayar["smtp_username"]; ?>">
                  </div>
                </div>
				  <div class="col-md-3">
                  <div class="form-group">
                    <label >SMTP Password</label>
                    <input name="smtp_pass" class="form-control"  value="<?php echo $ayar["smtp_pass"]; ?>">
                  </div>
                </div>
				  <div class="col-md-3">
                  <div class="form-group">
                    <label >SMTP Mail</label>
                    <input name="smtp_mail" class="form-control"  value="<?php echo $ayar["smtp_mail"]; ?>">
                  </div>
                </div>
                </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </form>
            </div>
		</div>
		
           </div> 
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
 <?php include("footer.php");?>