<?php include("header.php"); 
$paketid=$user["uyelik"];
	$paket = @mysqli_query($baglanti,"select * from paketler where id='$paketid'");
	$paket = $paket->fetch_assoc();
?>
<link href="assets/css/pages/privacy/privacy.css" rel="stylesheet" type="text/css" />
<div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div id="headerWrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-12 text-center">
                                <h2 class="main-heading">Privacy Policy</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="privacyWrapper" class="">
                    <div class="privacy-container">
                        <div class="privacyContent">
                            <div class="d-flex justify-content-between privacy-head">
                                <div class="privacyHeader">
                                    <h1>Terms of Service</h1>
                                    <p>Updated Sep 15, 2020</p>
                                </div>

                          

                            </div>
                            <h5 class="policy-info-ques">Please fully read our Terms of Service & Acceptable Use Policy. Violating our policies will result in your service being suspended without notice.</h5><br>
                            <div class="privacy-content-container">
                                    
                                <section>
                                    <h5>Acceptance</h5>
                                    <p>By purchasing Stresser.gg Packages, you agree with the terms anc conditions stated below. Failure to comply with these can result in closure of the account without informing the customer or providing more information as why their account has been closed.</p>
                                </section>

                                <section>
                                    
                                    <h5>Usage</h5>
                                    <p>Stresser.gg allows users to purchase packages based on their Account ID and regularly cleans the database for efficient and quick running of the website. With numerous users on the website, it is not possible to monitor activity of the customers and hence Stresser.gg is not responsible for any actions by its customers. Attacking IP addresses without the consent from its owner is not allowed and can lead to various consequences.</p>
                                    <p>In order to keep Stresser.gg secure and avoid any data leakage to unknown authorities, Stresser.gg cleans their databases on a regular basis. VPN's are allowed to be used by customers as an added protection to hide their IP address for falling in the wrong hands.</p>
                                </section>

                                <section>

                                    <h5>Account Sharing</h5>

                                    <p>Account sharing is strictly prohibited. Customers caught sharing or selling their accounts to other users for a fee or for free will loose access to thier account and all future accounts created by them. These accounts will be closed with a reason stating "Stolen account" and will loose its ability to stress test.</p>

                                </section>
                                    
                                <section>
                                    <h5>Payments & Refunds</h5>

                                    <p>Stresser.gg also follows a no refund policy on all types of payment methods including crypto-currencies and PayPal. Hence any disputes will result in the IP being banned and hire of professional PayPal dispute handlers in order to prevent the refund from taking place.</p>
                                    <p>Stresser.gg staff are entirely there to help you out, using abusive language or threatening staff members of Stresser.gg will result in closure of your account and your IP will be banned to prevent any future registration and payments from the customer.</p>
                                </section>

                                <section>
                                    <h5>Professional behaviour</h5>

                                    <p>Stresser.gg also follows a no refund policy on all types of payment methods including crypto-currencies and PayPal. Hence any disputes will result in the IP being banned and hire of professional PayPal dispute handlers in order to prevent the refund from taking place.</p>
                                </section>

                                <section>
                                    <h5>Termination & Change of terms</h5>

                                    <p>In an event where Stresser.gg can no longer provide services, the project can be terminated without any warning or updating customers. Various reasons can lead to this such as financial crisis or unavailability of staff and servers. No refunds will be provided in such a scenario.</p>
                                    <p>Stresser.gg reserves the rights to change these terms at any given time without any notice for the better of its customers and the project itself as a whole.</p>
                                </section>

                            </div>

                        </div>
                    </div>
                </div>
            
            </div>
			<?php include("footer.php"); ?>

			
       