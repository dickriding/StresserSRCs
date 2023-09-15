<?php include("header.php");

if (@$_GET["id"] != Null) {
  $userid = $_SESSION["id"];
  $dataid = $_GET['id'];
  $dataid = htmlentities($dataid, ENT_QUOTES, "UTF-8");
  $data = @mysqli_query($baglanti, "select * from sunucular where id='$dataid'") or die(mysql_error());
  $data = $data->fetch_assoc();
  if ($data["id"] != Null) {
  } else {
    header("Location: servers");
    exit;
  }
} else {
  header("Location: servers");
  exit;
}
if (isset($_POST["api"])) {


  $paket = htmlentities($_POST["paket"], ENT_QUOTES, "UTF-8");
  $api = htmlentities($_POST["api"], ENT_QUOTES, "UTF-8");
  $type = $_POST["type"];
  $es_zaman = htmlentities($_POST["es_zaman"], ENT_QUOTES, "UTF-8");
  if ($baglanti->query("UPDATE sunucular SET  api='$api', es_zaman='$es_zaman' , paket='$paket', typex='$type' WHERE id='$dataid'")) {

    header("Location: edit-servers?id=$dataid&islem=basarili");
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
          <h1>Edit Server</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Edit Server</li>
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
                <?php if (@$_GET["islem"] == "basarili") {
                  echo '<div class="alert alert-success">The server has been updated successfully.</div>';
                }
                ?>
                <!--<div class="form-group">
                    <label for="exampleInputEmail1">Plan</label>
					<select class="form-control" name="paket">
					<?php
          $data2 = mysqli_query($baglanti, "select * from paketler ORDER BY id DESC");
          while ($satir = mysqli_fetch_array($data2)) {
            if ($data["paket"] == $satir["id"]) {
              echo '	<option value="' . $satir["id"] . '" selected>' . $satir["ad"] . '</option>';
            } else {
              echo '	<option value="' . $satir["id"] . '">' . $satir["ad"] . '</option>';
            }
          }
          ?>
				
					</select>
                  </div>-->
                <div class="form-group">
                  <label for="exampleInputEmail1">Sunucu Node</label>
                  <select class="form-control" name="paket">
                    <option value="0" <?php if ($data["paket"] == "0") {
                                        echo 'selected';
                                      } ?>>VIP / Classic</option>
                    <option value="1" <?php if ($data["paket"] == "1") {
                                        echo 'selected';
                                      } ?>>Free</option>

                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Type</label>
                  <select class="form-control" name="type">
                    <option value="4" <?php if ($data["type"] == 4) {
                                        echo 'selected';
                                      } ?>>Layer4</option>
                    <option value="7" <?php if ($data["type"] == 7) {
                                        echo 'selected';
                                      } ?>>Layer7</option>

                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">API</label>
                  <input type="text" name="api" required class="form-control" value="<?php echo $data["api"]; ?>" id="exampleInputEmail1">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Concurrent</label>
                  <input type="text" name="es_zaman" required class="form-control" value="<?php echo $data["es_zaman"]; ?>" id="exampleInputEmail1">
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