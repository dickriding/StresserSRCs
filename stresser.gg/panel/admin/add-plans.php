<?php include("header.php");
if(isset($_POST["ad"])){


	$ad=htmlentities($_POST["ad"], ENT_QUOTES, "UTF-8");
	$fiyat=htmlentities($_POST["fiyat"], ENT_QUOTES, "UTF-8");
	$sure=htmlentities($_POST["sure"], ENT_QUOTES, "UTF-8");
	$zaman=htmlentities($_POST["zaman"], ENT_QUOTES, "UTF-8");
	$es_zaman=htmlentities($_POST["es_zaman"], ENT_QUOTES, "UTF-8");
	$gunluk_limit=htmlentities($_POST["gunluk_limit"], ENT_QUOTES, "UTF-8");
	$max_sure=htmlentities($_POST["max_sure"], ENT_QUOTES, "UTF-8");
	$node=htmlentities($_POST["node"], ENT_QUOTES, "UTF-8");
  $power=htmlentities($_POST["power"], ENT_QUOTES, "UTF-8");
  $anlik_saldir=htmlentities($_POST["anlik_saldir"], ENT_QUOTES, "UTF-8");
  $isHidden=htmlentities($_POST["isHidden"], ENT_QUOTES, "UTF-8");
		if ($baglanti->query("INSERT INTO paketler (ad, fiyat, sure, zaman, es_zaman, gunluk_limit, max_sure, node, power,anlik_saldir, isHidden) VALUES ('$ad', '$fiyat', '$sure', '$zaman', '$es_zaman', '$gunluk_limit', '$max_sure', '$node', '$power', '$anlik_saldir', '$isHidden')"))

											{

												header("Location: plans?islem=basarili");
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
            <h1>Add Plan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Add Plan<li>
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
                    <label for="exampleInputEmail1">Plan Name</label>
                    <input type="text" name="ad" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Price</label>
                    <input type="text" name="fiyat" pattern="[0-9.]*" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Length</label>
                    <input type="text" name="sure" pattern="[0-9]*" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Length</label>
					<select class="form-control" name="zaman">
					<option value="Day">Day</option>
					<option value="Week">Week</option>
					<option value="Month">Month</option>
					<option value="Year">Year</option>
					<option value="Lifetime">Lifetime</option>
					</select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Concurrents</label>
                    <input type="number" name="es_zaman" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Daily Attacks</label>
                    <input type="number" name="gunluk_limit" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Max Stress Time</label>
                    <input type="number" name="max_sure" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Simultaneous Attack</label>
                    <input type="number" name="anlik_saldir" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Node</label>
					            <select class="form-control" name="node">
					            <option value="VIP">VIP</option>
					            <option value="Classic">Classic</option>
					            <option value="Free">Free</option>
					            </select></div>

                      <div class="form-group">
                    <label for="exampleInputEmail1">Is Hidden</label>
					            <select class="form-control" name="isHidden">
					            <option value="0">No</option>
					            <option value="1">Yes</option>
					            </select></div>
                  </div>
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