<?php include("header.php");

if(@$_GET["id"]!=Null){
	$userid=$_SESSION["id"];
	$dataid = $_GET['id'];
	$dataid=htmlentities($dataid, ENT_QUOTES, "UTF-8");
	$data = @mysqli_query($baglanti,"select * from user where id='$dataid'") or die(mysql_error());
	$data = $data->fetch_assoc();
	if($data["id"]!=Null){
	}
	else{header("Location: members");exit;}
}
else{header("Location: members");exit;}

if( isset($_POST["secret_code"]) && isset($_POST["mail"])){


	$secret_code=htmlentities($_POST["secret_code"], ENT_QUOTES, "UTF-8");
	$bakiye=htmlentities($_POST["bakiye"], ENT_QUOTES, "UTF-8");	
	$mail=htmlentities($_POST["mail"], ENT_QUOTES, "UTF-8");	
	$uyelik=htmlentities($_POST["uyelik"], ENT_QUOTES, "UTF-8");	
	$uyelik_son=htmlentities($_POST["uyelik_son"], ENT_QUOTES, "UTF-8");	

  if($data["uyelik"] != $uyelik) {
    $vid = $_POST["uyelik"];
    $dataXX = @mysqli_query($baglanti,"select * from paketler where id='$vid'") or die(mysql_error());
    $dataXX = $dataXX->fetch_assoc();

    if($dataXX["zaman"] != "Lifetime") {
      $uyelik_son = $uyelik_son=date("Y-m-d", strtotime("+".$dataXX["sure"]." ".strtolower($dataXX["zaman"])));
    } else {
      $uyelik_son = 0;
    }
  }

	if($_POST["pass"]!=Null){
        $pass=htmlentities($_POST["pass"], ENT_QUOTES, "UTF-8");	
        $pass=md5($pass);
        $baglanti->query("UPDATE user SET  secret_code='$secret_code',bakiye='$bakiye',pass='$pass',mail='$mail',uyelik='$uyelik',uyelik_son='$uyelik_son' WHERE id='$dataid'");
	}else{
	  $baglanti->query("UPDATE user SET  secret_code='$secret_code',bakiye='$bakiye',mail='$mail',uyelik='$uyelik',uyelik_son='$uyelik_son' WHERE id='$dataid'");
  }	
	

		header("Location: member-edit?id=$dataid&islem=basarili");
exit;
											


}
?>
  <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Member</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Edit Member</li>
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
					echo '<div class="alert alert-success">The member has been updated successfully.</div>';
				}
				?>
				  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Secret Code</label>
                    <input type="number" name="secret_code" value="<?php echo $data["secret_code"]; ?>" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Member Mail</label>
                    <input type="email" name="mail" value="<?php echo $data["mail"]; ?>" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Member Password (If it is not changed, leave it blank)</label>
                    <input type="password" name="pass"  class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Balance</label>
                    <input type="number" name="bakiye" value="<?php echo $data["bakiye"]; ?>" required class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Plan</label>
					<select class="form-control" name="uyelik">
					<option value="0">No plans</option>
					<?php
					$data2=mysqli_query($baglanti,"select * from paketler ORDER BY id DESC"); 
												while($satir=mysqli_fetch_array($data2))
												{
													if($data["uyelik"]==$satir["id"]){
													echo '	<option value="'.$satir["id"].'" selected>'.$satir["ad"].'</option>';
													}
													else{
													echo '	<option value="'.$satir["id"].'">'.$satir["ad"].'</option>';
													}
												}
												?>
				
					</select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Expired (0 = Lifetime)</label>
                    <input type="text" name="uyelik_son" value="<?php echo $data["uyelik_son"]; ?>"  class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nickname</label>
                    <input type="text" readonly value="<?php echo $data["kadi"]; ?>"  class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Last Login IP</label>
                    <input type="text" readonly value="<?php echo $data["son_ip"]; ?>"  class="form-control" id="exampleInputEmail1">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Last Login Date</label>
                    <input type="text" readonly value="<?php echo $data["son_giris"]; ?>"  class="form-control" id="exampleInputEmail1">
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