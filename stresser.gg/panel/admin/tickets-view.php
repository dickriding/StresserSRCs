<?php include("header.php");

if($_GET["id"]!=Null){

	$destekid = $_GET['id'];

	$destekid=htmlentities($destekid, ENT_QUOTES, "UTF-8");

	$sorgu = @mysqli_query($baglanti,"select * from destektalep where id ='$destekid'"); 

	$sonuc = $sorgu->fetch_assoc();

	$id= $_SESSION["id"];



}

else{header("Location: tickets");exit;}
if(@$_GET["is"]=="kilit"){
    	if ($baglanti->query("UPDATE destektalep SET  durum='Closed' WHERE id='$destekid'")){

												header("Location: tickets-view?id=".$destekid);

												}
}
?>
<style>
.wrapper {
     width: 100% !important; 
 height: 100% !important; 
}
</style>
    <link href="../assets/css/apps/mailing-chat.css" rel="stylesheet" type="text/css" />
  <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tickets View <a href="?id=<?php echo $destekid;?>&is=kilit" class="alert alert-danger btn-sm">Closed</a> <a href="member-edit?id=<?php echo $sonuc["user"];?>" class="alert alert-info btn-sm">Show Member</a> </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Tickets View</li>
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
             
							<div class="chat-system">
                                <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu mail-menu d-lg-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></div>
                              
                                <div class="chat-box" style="height: calc(100vh - 232px);">

                                    <div class="chat-box-inner" style="height: 100%;">
                                        <div class="chat-meta-user chat-active">
                                            <div class="current-chat-user-name"><span><span class="name"><?php echo $sonuc["baslik"]; ?></span></span></div>

                                       
                                        </div>
                                        <div class="chat-conversation-box ps">
                                            <div id="chat-conversation-box-scroll" class="chat-conversation-box-scroll">
                                                <div class="chat active-chat" data-chat="person1">
                                                 
                                                    <div class="bubble you">
                                                       Member - <?php echo $sonuc["btarih"]; ?><br>
                                                       <?php echo $sonuc["icerik"]; ?>
                                                    </div>
													<?php
															  $cevaplar=mysqli_query($baglanti,"select * from destekcevap where destekid='$destekid'"); 


											while($cevap=mysqli_fetch_array($cevaplar))

											{

										$cevapuser=$cevap["user"];
												$user3 = @mysqli_query($baglanti,"select * from user where id='".$cevapuser."'") or die(mysql_error());

												$user4 = $user3->fetch_assoc();


												if($user4["rank"]=="1"){

													echo'   <div class="bubble me">';


$tag="Admin";
												}

										

												else{

														echo'   <div class="bubble you">';

$tag="Member";
												}

													  echo' 

                         '.$tag.' - '.$cevap["tarih"].'<br>
                                                       '.$cevap["cevap"].'                               
                                                    </div>


';

											

											}
											?>
                                                
                                                </div>
                                            </div>
                                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div><div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                                        <div class="chat-footer chat-active">
                                            <div class="chat-input">
                                                     <form method="post"  class="chat-form" >

                <input type="hidden" name="destekid" value="<?php echo $sonuc["id"]; ?>">
															  <?php

if($sonuc["durum"]=="Closed"){

echo' 

<div class="alert alert-warning">

Since the support request is closed, no response can be written.

</div> ';}

?>

 <?php

if($sonuc["durum"]!="Closed"){

echo'         
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                                    <input type="text" name="cevap" class="mail-write-box form-control" placeholder="Text...">
';}?>
                                      
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <script src="../assets/js/apps/mailbox-chat.js"></script>
 <?php 
 			if(@$_POST["cevap"]!=Null && @$_POST["destekid"]!=Null)  {


	$cevap = $_POST['cevap'];

	$cevap=htmlentities($cevap, ENT_QUOTES, "UTF-8");

	$tarih=date("d/m/Y (H:i:s)");

	$user=$_SESSION["id"];

	if ($baglanti->query("INSERT INTO destekcevap (destekid, user, cevap, tarih) VALUES ('$destekid','$user', '$cevap', '$tarih')"))

											{

												if ($baglanti->query("UPDATE destektalep SET  durum='Admin Response' WHERE id='$destekid'")){

												header("Location: tickets-view?id=".$destekid);

												}

											}


}
 include("footer.php");?>