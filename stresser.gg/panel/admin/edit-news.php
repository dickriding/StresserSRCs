<?php include("header.php");

if(@$_GET["id"]!=Null){
	$userid=$_SESSION["id"];
	$dataid = $_GET['id'];
	$dataid=htmlentities($dataid, ENT_QUOTES, "UTF-8");
	$data = @mysqli_query($baglanti,"select * from haberler where id='$dataid'") or die(mysql_error());
	$data = $data->fetch_assoc();
	if($data["id"]!=Null){
	}
	else{header("Location: news");exit;}
}
else{header("Location: news");exit;}
if(isset($_POST["baslik"])){


	$baslik=htmlentities($_POST["baslik"], ENT_QUOTES, "UTF-8");
	$yazi=htmlentities($_POST["yazi"], ENT_QUOTES, "UTF-8");
		if ($baglanti->query("UPDATE haberler SET  baslik='$baslik', yazi='$yazi' WHERE id='$dataid'"))

											{

												header("Location: edit-news?id=$dataid&islem=basarili");
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
            <h1>Edit News</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Edit News</li>
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
				<?php if(@$_GET["process"]=="success"){
					echo '<div class="alert alert-success">The news has been successfully updated.</div>';
				}
				?>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" name="baslik" required  value="<?php echo $data["baslik"]; ?>" class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Text</label>
                    <textarea type="text" name="yazi" required class="form-control" id="exampleInputEmail1"><?php echo $data["yazi"]; ?></textarea>
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