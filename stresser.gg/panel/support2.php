<?php include("header.php"); 
if($_GET["id"]!=Null){

	$destekid = $_GET['id'];

	$destekid=htmlentities($destekid, ENT_QUOTES, "UTF-8");

	$sorgu = @mysqli_query($baglanti,"select * from destektalep where id ='$destekid'"); 

	$sonuc = $sorgu->fetch_assoc();

	$id= $_SESSION["id"];

	if($sonuc["user"]==$id){

	}
	else{header("Location: ".$site."support");exit;}

}

else{header("Location: ".$site."support");exit;}?>
		
    <link href="assets/css/apps/mailing-chat.css" rel="stylesheet" type="text/css" />
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">

       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-three">

                            <div class="widget-content">
							<div class="chat-system">
                           
                                <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu mail-menu d-lg-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></div>
                         
                                <div class="chat-box" style="height: calc(100vh - 232px)">

                                    <div class="chat-box-inner" style="height: 100%;">
                                        <div class="chat-meta-user chat-active">
                                            <div class="current-chat-user-name"><span><span class="name"><?php echo $sonuc["baslik"]; ?></span></span></div>

                                       
                                        </div>
                                        <div class="chat-conversation-box ps" style="overflow: auto !important;">
                                            <div id="chat-conversation-box-scroll" class="chat-conversation-box-scroll">
                                                <div class="chat active-chat" data-chat="person1">
                                                 
                                                    <div class="bubble me">
                                                    <?php echo $user["kadi"];?> - <?php echo $sonuc["btarih"]; ?><br>
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

													echo'   <div class="bubble you">';


$tag="Admin";
												}

										

												else{

														echo'   <div class="bubble me">';

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
                                                    <input type="text" name="cevap" class="mail-write-box form-control" placeholder="Text..">
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

            </div>
    <script src="assets/js/apps/mailbox-chat.js"></script>
			<?php 
			if(@$_POST["cevap"]!=Null && @$_POST["destekid"]!=Null)  {

		if($sonuc["durum"]=="Closed"){

		header("Location: ".$site."support");

		exit;

	}

	$cevap = $_POST['cevap'];

	$cevap=htmlentities($cevap, ENT_QUOTES, "UTF-8");

	$tarih=date("d/m/Y (H:i:s)");

	$user=$_SESSION["id"];
if($user==$sonuc["user"]){
	if ($baglanti->query("INSERT INTO destekcevap (destekid, user, cevap, tarih) VALUES ('$destekid','$user', '$cevap', '$tarih')"))

											{

												if ($baglanti->query("UPDATE destektalep SET  durum='Customer Response' WHERE id='$destekid'")){

												header("Location: ".$site."panel/support2?id=".$destekid);

												}

											}
}

}
			include("footer.php"); ?>
       