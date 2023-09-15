<?php include("header.php"); 
$paketid=$user["uyelik"];
	$paket = @mysqli_query($baglanti,"select * from paketler where id='$paketid'");
	$paket = $paket->fetch_assoc();
?>
    <link href="assets/css/pages/faq/faq2.css" rel="stylesheet" type="text/css" /> 
		
<div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="faq">

                    <div class="faq-layouting layout-spacing">

                        <div class="fq-tab-section layout-top-spacing">
                            <div class="row">
                                <div class="col-md-12">

                                    <h2>Frequently Asked <span>Questions</span></h2>

                                    <div class="row">
                                        
                                        <div class="col-lg-6">

                                            <div class="accordion" id="simple_faq">
                                                <div class="card">
                                                    <div class="card-header" id="fqheadingOne">
                                                        <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#fqcollapseOne" aria-expanded="false" aria-controls="fqcollapseOne">
                                                            <span class="faq-q-title">What is a stresser/booter ?</span> <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                                        </div>
                                                    </div>
                                                    <div id="fqcollapseOne" class="collapse" aria-labelledby="fqheadingOne" data-parent="#simple_faq">
                                                        <div class="card-body">
                                                            <p>An IP stresser is a tool designed to test a network or server for robustness. The administrator may run a stress test in order to determine whether the existing resources (bandwidth, CPU, etc.) are sufficient to handle additional load.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header" id="fqheadingTwo">
                                                        <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#fqcollapseTwo" aria-expanded="true" aria-controls="fqcollapseTwo">
                                                            <span class="faq-q-title">How long does it take to activate my package?</span> <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg></div>
                                                        </div>
                                                    </div>
                                                    <div id="fqcollapseTwo" class="collapse show" aria-labelledby="fqheadingTwo" data-parent="#simple_faq">
                                                        <div class="card-body">
                                                            <p>Stresser.gg offers automated services, after coinpayments declares the payment as "complete" it usually takes another 10-30 minutes for you to receive your purchased package.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header" id="fqheadingThree">
                                                        <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#fqcollapseThree" aria-expanded="false" aria-controls="fqcollapseThree">
                                                            <span class="faq-q-title">What is the difference between Premium and Non-Premium?</span><div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                                        </div>
                                                    </div>
                                                    <div id="fqcollapseThree" class="collapse" aria-labelledby="fqheadingThree" data-parent="#simple_faq">
                                                        <div class="card-body">
                                                            <p>Premium plans usually get an average of 60% more power than regular packages. Premium plans also gives customers priority support service. And they can use special methods prepared for Premium.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header" id="fqheadingFour">
                                                        <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#fqcollapseFour" aria-expanded="false" aria-controls="fqcollapseFour">
                                                            <span class="faq-q-title">Can i share my account with a friend?</span><div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                                        </div>
                                                    </div>
                                                    <div id="fqcollapseFour" class="collapse" aria-labelledby="fqheadingFour" data-parent="#simple_faq">
                                                        <div class="card-body">
                                                            <p>Based on IP Stresser terms and conditions, you cannot share your account or sell your account to anyone. If the system detects such an account, it will auto-ban the account and you will loose access to your package.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header" id="fqheadingFive">
                                                        <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#fqcollapseFive" aria-expanded="false" aria-controls="fqcollapseFive">
                                                            <span class="faq-q-title">Can i have multiple packages at the same time?</span><div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                                        </div>
                                                    </div>
                                                    <div id="fqcollapseFive" class="collapse" aria-labelledby="fqheadingFive" data-parent="#simple_faq">
                                                        <div class="card-body">
                                                            <p>Our friendly system allows you to purchase another package before your current one has finished. The new package will on start when the old one is over. However you can switch between different packages and the system will automatically reduce your days based on how much you have used the package.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header" id="fqheadingSix">
                                                        <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#fqcollapseSix" aria-expanded="false" aria-controls="fqcollapseSix">
                                                            <span class="faq-q-title">Is there a daily limit?</span><div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                                        </div>
                                                    </div>
                                                    <div id="fqcollapseSix" class="collapse" aria-labelledby="fqheadingSix" data-parent="#simple_faq">
                                                        <div class="card-body">
                                                            <p>There is no daily limit, you can do unlimited tests.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>   
                                        </div>
                                        <div class="col-lg-6">
                                            
                                            <div class="accordion" id="simple_faq1">
                                                <div class="card">
                                                    <div class="card-header" id="fqheadingOne1">
                                                        <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#fqcollapseOne1" aria-expanded="false" aria-controls="fqcollapseOne1">
                                                            <span class="faq-q-title">Why is PayPal no longer available?</span> <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                                        </div>
                                                    </div>
                                                    <div id="fqcollapseOne1" class="collapse" aria-labelledby="fqheadingOne1" data-parent="#simple_faq1">
                                                        <div class="card-body">
                                                            <p>PayPal do not allow such services to be registered on their platform and hence we no longer have an account with PayPal. This is inturn good for you as a customer because your data will be secure and anonymous, without PayPal you do not need to use your actual identity anywhere.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header" id="fqheadingTwo2">
                                                        <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#fqcollapseTwo2" aria-expanded="false" aria-controls="fqcollapseTwo2">
                                                            <span class="faq-q-title">Can i be traced as a customer?</span> <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg></div>
                                                        </div>
                                                    </div>
                                                    <div id="fqcollapseTwo2" class="collapse" aria-labelledby="fqheadingTwo2" data-parent="#simple_faq1">
                                                        <div class="card-body">
                                                            <p>Stresser.gg uses secure IP header modification and hence no attacks can be traced back to us and therefore no attacks can be traced back to you.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header" id="fqheadingTwo2">
                                                        <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#why" aria-expanded="false" aria-controls="why">
                                                            <span class="faq-q-title">Why should we choose you?</span> <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg></div>
                                                        </div>
                                                    </div>
                                                    <div id="why" class="collapse" aria-labelledby="fqheadingTwo2" data-parent="#simple_faq1">
                                                        <div class="card-body">
                                                            <p>Stresser.gg provides its own strength among all other stresser sites. We prepare our methods ourselves and update them weekly. For this reason, you will get 40% successful results in your tests with the "Starter Package" with the lowest plan, this % may vary according to your plan.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header" id="fqheadingThree3">
                                                        <div class="mb-0" data-toggle="collapse" role="navigation" data-target="#fqcollapseThree3" aria-expanded="false" aria-controls="fqcollapseThree3">
                                                            <span class="faq-q-title">How is my data protected?</span><div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                                        </div>
                                                    </div>
                                                    <div id="fqcollapseThree3" class="collapse" aria-labelledby="fqheadingThree3" data-parent="#simple_faq1">
                                                        <div class="card-body">
                                                            <p>Our site is layered by SSL and payment parameters are heavily encrypted using AES256 bit encryption and randomized hashing algorithms. All passwords and other sensitive data are hashed using todays highest security standard. Security is top priority for us and we have never had vulnerabilities or any issues securing our site.</p>
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

            </div>
        </div>
			<?php include("footer.php"); ?>
       