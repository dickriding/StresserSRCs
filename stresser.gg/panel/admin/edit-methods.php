<?php include("header.php");

if(@$_GET["id"]!=Null){
	$userid=$_SESSION["id"];
	$dataid = $_GET['id'];
	$dataid=htmlentities($dataid, ENT_QUOTES, "UTF-8");
	$data = @mysqli_query($baglanti,"select * from method where id='$dataid'") or die(mysql_error());
	$data = $data->fetch_assoc();
	if($data["id"]!=Null){
	}
	else{header("Location: methods");exit;}
}
else{header("Location: methods");exit;}
if(isset($_POST["method"])){


	$method=htmlentities($_POST["method"], ENT_QUOTES, "UTF-8");
	$deger=htmlentities($_POST["deger"], ENT_QUOTES, "UTF-8");
	$kate=htmlentities($_POST["kate"], ENT_QUOTES, "UTF-8");
	$node=htmlentities($_POST["node"], ENT_QUOTES, "UTF-8");
		if ($baglanti->query("UPDATE method SET  method='$method',deger='$deger',kate='$kate',node='$node' WHERE id='$dataid'"))

											{

												header("Location: edit-methods?id=$dataid&islem=basarili");
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
            <h1>Edit Methods</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Edit Methods</li>
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
					echo '<div class="alert alert-success">The method has been updated successfully.</div>';
				}
				?>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Node</label>
					<select class="form-control" name="node">
					<option value="VIP" <?php if($data["node"]=="VIP"){ echo 'selected'; }?>>VIP</option>
					<option value="Classic" <?php if($data["node"]=="Classic"){ echo 'selected'; }?>>Classic</option>
					<option value="Free" <?php if($data["node"]=="Free"){ echo 'selected'; }?>>Free</option>
					</select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Method Name</label>
                    <input type="text" name="method" value="<?php echo $data["method"]; ?>" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Method Tag</label>
                    <input type="text" name="deger" value="<?php echo $data["deger"]; ?>" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Method Category</label>
                    <input type="text" name="kate" value="<?php echo $data["kate"]; ?>" required class="form-control" id="exampleInputEmail1">
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