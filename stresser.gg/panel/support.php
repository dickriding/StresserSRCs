<?php include("header.php");
	if(@$_POST["baslik"]!=Null && @$_POST["cevap"]!=Null)  {
	$id=$_SESSION["id"];
	$baslik = $_POST['baslik'];
	$baslik=htmlentities($baslik, ENT_QUOTES, "UTF-8");
	$cevap = $_POST['cevap'];
	$cevap=htmlentities($cevap, ENT_QUOTES, "UTF-8");
	$tarih=date("d/m/Y (H:i:s)");


	if ($baglanti->query("INSERT INTO destektalep (user, baslik, icerik, durum, tarih, btarih) VALUES ('$id','$baslik', '$cevap', 'Waiting', '$tarih', '$tarih')"))
		{
			header("Location: support?process=success");
		}
} ?>
		
    <link rel="stylesheet" type="text/css" href="plugins/editors/quill/quill.snow.css">
    <link href="assets/css/apps/mailbox.css" rel="stylesheet" type="text/css" />
        <div id="content" class="main-content"><br>
            <div class="layout-px-spacing">
            <div class="message-box">
                 <?php	if(@$_GET["process"]=="success"){echo'<div class="alert alert-outline-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i><strong>Successfull !</strong> Support request created.</div>';} ?>
                <div class="row layout-top-spacing">

       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                  <div class="mail-box-container">
                                    <div class="mail-overlay"></div>

                                    <div class="tab-title">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-12 text-center mail-btn-container">
                                                <a id="btn-compose-mail" class="btn btn-block" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></a>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-12 mail-categories-container">

                                                <div class="mail-sidebar-scroll ps">

                                                    <ul class="nav nav-pills d-block" id="pills-tab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link list-actions active" id="mailInbox"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg> <span class="nav-names">Waiting for an Answer</span></a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link list-actions" id="important"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg> <span class="nav-names">Replies</span></a>
                                                        </li>
                                                    </ul>

                                                
                                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: -15px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="mailbox-inbox" class="accordion mailbox-inbox">

                                            <div class="message-box-scroll ps ps--active-y" id="ct">

                                                  									<?php
	$id=$_SESSION["id"];
	$say=0;
				  $destekcek=mysqli_query($baglanti,"select * from destektalep where user='$id'  ORDER BY id DESC"); 
												while($satir=mysqli_fetch_array($destekcek))
												{
													if($satir['durum']=="Waiting" || $satir['durum']=="Customer Response") {
														?>
														 <div id="unread-promotion-page" class="mail-item mailInbox">
                                                    <div class="animated animatedFadeInUp fadeInUp" id="mailHeadingThree">
                                                        <div class="mb-0">
                                                            <div class="mail-item-heading social collapsed" data-toggle="collapse" role="navigation" data-target="#mailCollapseThree" aria-expanded="false">
                                                                <div class="mail-item-inner">

                                                                    <a href="support2?id=<?php echo $satir["id"];?>">   <div class="d-flex">
                                                                        <div class="f-body">
                                                                            <div class="meta-mail-time">
                                                                                <p class="user-email" ><?php echo $satir['baslik']; ?></p>
                                                                            </div>
                                                                            <div class="meta-title-tag">
                                                                                <p class="mail-content-excerpt"><?php echo $satir['icerik']; ?>
                                                                                </p>
                                                                                <div class="tags">
                                                                                   <?php if($satir["durum"]=="Customer Response"){echo'<div class="yellowCircle"></div><p class="AnswerYes">Customer Response</p>';}
															elseif($satir["durum"]=="Waiting"){echo'<div class="yellowCircle"></div><p class="AnswerYes">Waiting</p>';}
															elseif($satir["durum"]=="Admin Response"){echo'<div class="greyCircle"></div><p class="AnswerWait">Admin Response</p>';}
															elseif($satir["durum"]=="Closed"){echo'<div class="greyCircle"></div><p class="AnswerYes"><font color="red">Closed</font></p>';} ?>
                                                                                </div>
                                                                                <p class="meta-time align-self-center"><?php echo $satir['tarih']; ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
														
														<?php
													$say++;
													}
												}
												if($say==0){
													?>
															 <div id="unread-promotion-page" class="mail-item mailInbox">
                                                    <div class="animated animatedFadeInUp fadeInUp" id="mailHeadingThree">
                                                        <div class="mb-0">
                                                            <div class="mail-item-heading social collapsed" data-toggle="collapse" role="navigation" data-target="#mailCollapseThree" aria-expanded="false">
                                                                <div class="mail-item-inner">

                                                                    <div class="d-flex">
                                                                        <div class="f-body">
                                                                            <div class="meta-mail-time">
                                                                            </div>
                                                                            <div class="meta-title-tag">
                                                                                <p class="mail-content-excerpt">No records were found in this section.
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
													<?php
												}
												?>
                                                  									<?php
	$id=$_SESSION["id"];
	$say=0;
				  $destekcek=mysqli_query($baglanti,"select * from destektalep where user='$id'  ORDER BY id DESC"); 
												while($satir=mysqli_fetch_array($destekcek))
												{
													if($satir['durum']=="Admin Response" || $satir['durum']=="Closed") {
														?>
														 <div id="unread-promotion-page" class="mail-item mailInbox2 important">
                                                    <div class="animated animatedFadeInUp fadeInUp" id="mailHeadingThree">
                                                        <div class="mb-0">
                                                            <div class="mail-item-heading social collapsed" data-toggle="collapse" role="navigation" data-target="#mailCollapseThree" aria-expanded="false">
                                                                <div class="mail-item-inner">

                                                                        <a href="support2?id=<?php echo $satir["id"];?>">  <div class="d-flex">
                                                                        <div class="f-body">
                                                                      <div class="meta-mail-time">
                                                                                <p class="user-email" ><?php echo $satir['baslik']; ?></p>
                                                                            </div>
                                                                            <div class="meta-title-tag">
                                                                                <p class="mail-content-excerpt"><?php echo $satir['icerik']; ?>
                                                                                </p>
                                                                                <div class="tags">
                                                                                   <?php if($satir["durum"]=="Customer Response"){echo'<div class="yellowCircle"></div><p class="AnswerYes">Customer Response</p>';}
															elseif($satir["durum"]=="Waiting"){echo'<div class="yellowCircle"></div><p class="AnswerYes">Waiting</p>';}
															elseif($satir["durum"]=="Admin Response"){echo'<div class="greyCircle"></div><p class="AnswerWait">Admin Response</p>';}
															elseif($satir["durum"]=="Closed"){echo'<div class="greyCircle"></div><p class="AnswerYes"><font color="red">Closed</font></p>';} ?>
                                                                                </div>
                                                                                <p class="meta-time align-self-center"><?php echo $satir['tarih']; ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
														
														<?php
													$say++;
													}
												}
												if($say==0){
													?>
															 <div id="unread-promotion-page" class="mail-item mailInbox2 important">
                                                    <div class="animated animatedFadeInUp fadeInUp" id="mailHeadingThree">
                                                        <div class="mb-0">
                                                            <div class="mail-item-heading social collapsed" data-toggle="collapse" role="navigation" data-target="#mailCollapseThree" aria-expanded="false">
                                                                <div class="mail-item-inner">

                                                                    <div class="d-flex">
                                                                        <div class="f-body">
                                                                            <div class="meta-mail-time">
                                                                            </div>
                                                                            <div class="meta-title-tag">
                                                                                <p class="mail-content-excerpt">No records were found in this section.
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
													<?php
												}
												?>
                                              

                                            <div class="ps__rail-x" style="left: 0px; bottom: 0px; display: none;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 723px; right: 0px; display: none;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 399px;"></div></div></div>
                                        </div>

                                  
                                    </div>
                                    
                                </div>
                    </div>

                </div>

            </div>      <div class="modal fade" id="composeMailModal" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                <div class="compose-box">
                                                    <div class="compose-content">
                                                        <form method="post" action="">
                                                           

                                                            <div class ="row">
                                                                <div class="col-md-6">
                                                                    <div class="d-flex mb-4 mail-to">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                                        <div class="">
                                                                            <input type="text" id="m-to" readonly value="<?php echo $user["kadi"];?>" class="form-control">
                                                                            <span class="validation-text"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="d-flex mb-4 mail-cc">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>
                                                                        <div>
                                                                            <input type="text" id="m-cc" readonly value="<?php echo $user["mail"];?>" class="form-control">
                                                                            <span class="validation-text"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex mb-4 mail-subject">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                                                <div class="w-100">
                                                                    <input type="text" id="m-subject" name="baslik" required class="form-control" placeholder="Subject">
                                                                    <span class="validation-text"></span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex mb-4 mail-subject">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>
                                                                <div class="w-100">
                                                                    <textarea name="cevap" required class="form-control" rows="5" placeholder="Text.."></textarea>
                                                                    <span class="validation-text"></span>
                                                                </div>
                                                            </div>

<br>
                                                <button class="btn btn-primary btn-block mb-4 mr-2" type="submit">Create</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
			<?php include("footer.php"); ?>
       
    <script src="assets/js/ie11fix/fn.fix-padStart.js"></script>
    <script src="plugins/editors/quill/quill.js"></script>
    <script src="plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="plugins/notification/snackbar/snackbar.min.js"></script>
    <script src="assets/js/apps/custom-mailbox.js"></script>