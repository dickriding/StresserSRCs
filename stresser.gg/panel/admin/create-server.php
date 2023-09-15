<?php include("header.php");
if (isset($_POST["api"])) {


  $paket = htmlentities($_POST["paket"], ENT_QUOTES, "UTF-8");
  $api = htmlentities($_POST["api"], ENT_QUOTES, "UTF-8");
  $es_zaman = htmlentities($_POST["es_zaman"], ENT_QUOTES, "UTF-8");
  $type = $_POST["type"];
  if ($baglanti->query("INSERT INTO sunucular (paket, api,es_zaman,typex) VALUES ('$paket', '$api', '$es_zaman','$type')")) {

    header("Location: servers?islem=basarili");
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
          <h1>Create Server</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Create Server</li>
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
                <!-- <div class="form-group">
                    <label for="exampleInputEmail1">Plan</label>
					<select class="form-control" name="paket">
					<?php
          $data = mysqli_query($baglanti, "select * from paketler ORDER BY id DESC");
          while ($satir = mysqli_fetch_array($data)) {
            echo '	<option value="' . $satir["id"] . '">' . $satir["ad"] . '</option>';
          }
          ?>
				
					</select>
                  </div>-->
                <div class="form-group">
                  <label for="exampleInputEmail1">Node</label>
                  <select class="form-control" name="paket">
                    <option value="0">VIP / Classic</option>
                    <option value="1">Free</option>

                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Type</label>
                  <select class="form-control" name="type">
                    <option value="4">Layer4</option>
                    <option value="7">Layer7</option>

                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">API</label>
                  <input type="text" name="api" required class="form-control" id="exampleInputEmail1">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Concurrent</label>
                  <input type="text" name="es_zaman" required class="form-control" id="exampleInputEmail1">
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
    </div>
    <!--/. container-fluid -->
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
<?php include("footer.php"); ?>