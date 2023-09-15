<?php include("header.php");


?>
  <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Attack Logs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Attack Logs</li>
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
		
        <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
			  <?php if(@$_GET["islem"]=="basarili"){
				  echo '<div class="alert alert-success">Kategori başarıyla eklendi</div>';
			  }
			  ?>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                                              <th><div class="th-content">ID</div></th>
                                                <th><div class="th-content">Member</div></th>
                                                <th><div class="th-content">IP:PORT</div></th>
                                                <th><div class="th-content th-heading">Date</div></th>
                                                <th><div class="th-content th-heading">Stress Time</div></th>
                                                <th><div class="th-content">Method</div></th>
                                                <th><div class="th-content">API</div></th>
                                                <th><div class="th-content">Status</div></th>
                    </tr>
                  </thead>
                  <tbody>
                 
							<?php 	  $say=mysqli_query($baglanti,"select * from log ORDER BY id DESC"); 
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
									  $data=mysqli_query($baglanti,"select * from log ORDER BY id DESC LIMIT $goster, $limit"); 
												while($satir=mysqli_fetch_array($data))
												{
													$userid=$satir["user"];
												  $uye=mysqli_query($baglanti,"select * from user where id='$userid'"); 
												$uye=mysqli_fetch_array($uye);
											?>
     <tr>                                     <td><div class="td-content" style="text-align: center !important"><?php echo $satir["id"];?></div></td>
                                                <td><div class="td-content product-name"><a href="member-edit?id=<?php echo $uye["id"];?>"><?php echo $uye["kadi"];?></a></div></td>
                                                <td><div class="td-content product-name"><?php echo $satir["ip"];?>:<?php echo $satir["port"];?></div></td>
                                                <td><div class="td-content"><span class="pricing"><?php echo $satir["tarih"];?></span></div></td>
                                                <td><div class="td-content"><span class="discount-pricing"><?php echo $satir["sure"];?> Seconds</span></div></td>
                                                <td><div class="td-content"><?php echo $satir["method"];?></div></td>
                                                <td><div class="td-content"><?php echo ($satir["api"] == 1 ? "API" : "Panel");?></div></td>
                                                <td><div class="td-content">
												<?php if(strtotime($satir["sonlanma"])<strtotime(date("Y-m-d H:i:s"))){ ?>
												Compeleted
												<?php } else { echo 'Attacking'; } ?>
												</div></td>
                                            </tr>
<?php											
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