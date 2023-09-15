<?php include("header.php");
if(isset($_POST["eslesen"])){


	$eslesen=htmlentities($_POST["eslesen"], ENT_QUOTES, "UTF-8");
	$deger=htmlentities($_POST["deger"], ENT_QUOTES, "UTF-8");
		if ($baglanti->query("INSERT INTO blacklist (eslesen, deger) VALUES ('$eslesen', '$deger')"))

											{

												header("Location: blacklist?islem=basarili");
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
            <h1>Add Blacklist</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Add Blacklist</li>
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
                  <div class="form-group">
                    <label for="exampleInputEmail1">Match Status</label>
                   <select class="form-control" name="eslesen">
				   <option value="0">Exact Match</option>
				   <option value="1">Containing This Value</option>
				   </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Blaclist IP:DOMAIN</label>
                    <input type="text" name="deger" required class="form-control" id="exampleInputEmail1">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Create</button>
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