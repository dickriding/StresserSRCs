<?php include("header.php");

if(@$_GET["id"]!=Null){
	$userid=$_SESSION["id"];
	$dataid = $_GET['id'];
	$dataid=htmlentities($dataid, ENT_QUOTES, "UTF-8");
	$data = @mysqli_query($baglanti,"select * from blacklist where id='$dataid'") or die(mysql_error());
	$data = $data->fetch_assoc();
	if($data["id"]!=Null){
	}
	else{header("Location: blacklist");exit;}
}
else{header("Location: blacklist");exit;}
if(isset($_POST["eslesen"])){


	$eslesen=htmlentities($_POST["eslesen"], ENT_QUOTES, "UTF-8");
	$deger=htmlentities($_POST["deger"], ENT_QUOTES, "UTF-8");
		if ($baglanti->query("UPDATE blacklist SET  eslesen='$eslesen',deger='$deger' WHERE id='$dataid'"))

											{

												header("Location: edit-blacklist?id=$dataid&islem=basarili");
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
            <h1>Edit Blacklist</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Edit Blacklist</li>
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
					echo '<div class="alert alert-success">Blacklist has been updated successfully.</div>';
				}
				?>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Match Status</label>
                   <select class="form-control" name="eslesen">
				   <option value="0" <?php if($data["eslesen"]==0){echo 'selected';}?>>Exact Match</option>
				   <option value="1" <?php if($data["eslesen"]==1){echo 'selected';}?>>Containing This Value</option>
				   </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Blacklist IP:DOMAIN</label>
                    <input type="text" name="deger" value="<?php echo $data["deger"]; ?>" required class="form-control" id="exampleInputEmail1">
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