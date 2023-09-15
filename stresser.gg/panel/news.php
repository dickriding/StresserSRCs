<?php include("header.php"); 
$paketid=$user["uyelik"];
	$paket = @mysqli_query($baglanti,"select * from paketler where id='$paketid'");
	$paket = $paket->fetch_assoc();
?>
		
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">


       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                        <div class="widget widget-table-three">

                            <div class="widget-heading">
                                <h5 class="">News</h5>
                            </div>

                            <div class="widget-content">
                          
						  <div class="row">
						  <?php
						    $data=mysqli_query($baglanti,"select * from haberler ORDER BY id DESC"); 
												while($satir=mysqli_fetch_array($data))
												{
											?>
																	  <div class="col-md-4">
						  <div class="card-body" style="background: #191e3a;border: none;border-radius: 4px;margin-bottom: 30px;">

                                                <div class="task-header">
                                                    
                                                    <div class="">
                                                        <h4 class="" data-tasktitle="Launch New SEO Wordpress Theme "><?php echo $satir['baslik']; ?></h4>
                                                    </div>
                                                   
                                                </div>

                                                <div class="task-body">

                                                    <div class="task-content">
                                                        <p class="" data-tasktext="<?php echo str_replace('"',"",html_entity_decode($satir['yazi'])); ?>">
														<?php echo html_entity_decode($satir['yazi']); ?></p>

                                                     
                                                    </div>

                                          
                                                    
                                                </div>

                                            </div></div>
											<?php
												
												}
												
												?>

						  
						  </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
			<?php include("footer.php"); ?>
       