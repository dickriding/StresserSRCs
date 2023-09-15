<?php include("header.php");

if(@$_GET["id"]!=Null){
	$userid=$_SESSION["id"];
	$dataid = $_GET['id'];
	$dataid=htmlentities($dataid, ENT_QUOTES, "UTF-8");
	$data = @mysqli_query($baglanti,"select * from paketler where id='$dataid'") or die(mysql_error());
	$data = $data->fetch_assoc();
	if($data["id"]!=Null){
	}
	else{header("Location: plans");exit;}
}
else{header("Location: plans");exit;}
if(isset($_POST["ad"])){


	$ad=htmlentities($_POST["ad"], ENT_QUOTES, "UTF-8");
	$fiyat=htmlentities($_POST["fiyat"], ENT_QUOTES, "UTF-8");
	$sure=htmlentities($_POST["sure"], ENT_QUOTES, "UTF-8");
	$es_zaman=htmlentities($_POST["es_zaman"], ENT_QUOTES, "UTF-8");
	$gunluk_limit=htmlentities($_POST["gunluk_limit"], ENT_QUOTES, "UTF-8");
	$max_sure=htmlentities($_POST["max_sure"], ENT_QUOTES, "UTF-8");
	$zaman=htmlentities($_POST["zaman"], ENT_QUOTES, "UTF-8");
	$node=htmlentities($_POST["node"], ENT_QUOTES, "UTF-8");
  $anlik_saldir=htmlentities($_POST["anlik_saldir"], ENT_QUOTES, "UTF-8");
  $isHidden=htmlentities($_POST["isHidden"], ENT_QUOTES, "UTF-8");
		if ($baglanti->query("UPDATE paketler SET  ad='$ad', fiyat='$fiyat', sure='$sure', zaman='$zaman', es_zaman='$es_zaman', gunluk_limit='$gunluk_limit', max_sure='$max_sure', node='$node', anlik_saldir='$anlik_saldir', isHidden='$isHidden' WHERE id='$dataid'"))

											{

												header("Location: edit-plans?id=$dataid&islem=basarili");
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
            <h1>Edit Plan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Edit Plan</li>
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
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="">
                <div class="card-body">
				<?php if(@$_GET["islem"]=="basarili"){
					echo '<div class="alert alert-success">The package has been updated successfully.</div>';
				}
				?>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Plan Name</label>
                    <input type="text" name="ad" required value="<?php echo $data["ad"]; ?>" class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Price</label>
                    <input type="text" name="fiyat" pattern="[0-9.]*" value="<?php echo $data["fiyat"]; ?>" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Length</label>
                    <input type="text" name="sure" pattern="[0-9]*" value="<?php echo $data["sure"]; ?>" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Length</label>
					<select class="form-control" name="zaman">
					<option value="Day" <?php if($data["zaman"]=="Day"){ echo 'selected'; }?>>Day</option>
					<option value="Week" <?php if($data["zaman"]=="Week"){ echo 'selected'; }?>>Week</option>
					<option value="Month" <?php if($data["zaman"]=="Month"){ echo 'selected'; }?>>Month</option>
					<option value="Year" <?php if($data["zaman"]=="Year"){ echo 'selected'; }?>>Year</option>
					<option value="Lifetime" <?php if($data["zaman"]=="Lifetime"){ echo 'selected'; }?>>Lifetime</option>
					</select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Concurrents</label>
                    <input type="number" name="es_zaman" value="<?php echo $data["es_zaman"]; ?>" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Daily Attacks</label>
                    <input type="number" name="gunluk_limit" value="<?php echo $data["gunluk_limit"]; ?>" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Max Stress Time</label>
                    <input type="number" name="max_sure" value="<?php echo $data["max_sure"]; ?>" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Simultaneous Attack</label>
                    <input type="number" name="anlik_saldir" value="<?php echo $data["anlik_saldir"]; ?>" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Node</label>
					<select class="form-control" name="node">
					<option value="VIP" <?php if($data["node"]=="VIP"){ echo 'selected'; }?>>VIP</option>
					<option value="Classic" <?php if($data["node"]=="Classic"){ echo 'selected'; }?>>Classic</option>
					<option value="Free" <?php if($data["node"]=="Free"){ echo 'selected'; }?>>Free</option>
					</select></div>

          <div class="form-group">
                    <label for="exampleInputEmail1">Is Hidden</label>
					<select class="form-control" name="isHidden">
					<option value="0" <?php if($data["isHidden"]==0){ echo 'selected'; }?>>No</option>
					<option value="1" <?php if($data["isHidden"]==1){ echo 'selected'; }?>>Yes</option>
					</select></div>
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