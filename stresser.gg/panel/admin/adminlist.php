<?php include("header.php");
	if(isset($_GET["id"])){


	$id=htmlentities($_GET["id"], ENT_QUOTES, "UTF-8");
		if ($baglanti->query("UPDATE user SET  rank='0' WHERE id='$id'"))

											{

												header("Location: adminlist");
exit;
											}


}
	if(isset($_POST["mail"])){


	$id=htmlentities($_POST["mail"], ENT_QUOTES, "UTF-8");
		if ($baglanti->query("UPDATE user SET  rank='1' WHERE mail='$id'"))

											{

												header("Location: adminlist");
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
            <h1>Admin List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Admin List</li>
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
                <h3 class="card-title">Give a permission</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Member Mail</label>
                    <input name="mail" required class="form-control" >
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Give a permission</button>
                </div>
              </form>
            </div>
		</div>
		
           </div> 
        <div class="row">
		<div class="col-md-12">
		
        <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Mail</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
               		<?php 
								  $say=mysqli_query($baglanti,"select * from user where rank='1' ORDER BY id DESC"); 
				  $satir_sayisi=mysqli_num_rows($say);
				      if(isset($_GET['sayfa']) && is_numeric($_GET['sayfa'])){
        $sayfa = $_GET['sayfa'];
        if($sayfa < 0){
            $sayfa=1;
        }
    }else{
        $sayfa = 1;
    }
    $limit  = 10;
    $ss     = ceil( $satir_sayisi / $limit );
    $sayfa  = ( $sayfa > $ss ? 1 : $sayfa );
    $goster = ( $sayfa * $limit ) - $limit;
									  $data=mysqli_query($baglanti,"select * from user where rank='1' ORDER BY id DESC LIMIT $goster, $limit"); 
												while($satir=mysqli_fetch_array($data))
												{
											
														echo '
                              <tr>
                                <td>'.$satir['id'].'</td>
                                <td>'.$satir['mail'].'</td>
                                <td><a href="member-edit?id='.$satir['id'].'" class="btn btn-info">View</a> <a href="?id='.$satir['id'].'" class="btn btn-danger">Remove a permission</a></td>
                              </tr>';
												}
							
							?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                 	   <?php 
                                for( $i = $sayfa - 1; $i < $sayfa + 2; $i++ ) 
                                { 
                                    if( $i > 0 && $i <= $ss ) 
                                    {
                                        echo '<li class="page-item"><a class="page-link" href="?sayfa='.$i.'">'.$i.'</a></li>';
                                    } 
                                } 
                            ?>
                </ul>
              </div>
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