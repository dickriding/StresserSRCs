<?php ob_start();
session_start();
include("config.php");
include("config2.php");

	$ayar = @mysqli_query($baglanti,"select * from ayarlar where id='1'");
	$ayar = $ayar->fetch_assoc();



if(isset($_SESSION["id"])){
	header("Location:index");
	exit;
}

if(isset($_POST["mail"]) && isset($_POST["secret_code"]) && isset($_POST["kadi"]) && isset($_POST["pass"])) {
    $gk = @$_POST['gk'];
    $korumakod=$_SESSION['korumakod'];
    /*if($korumakod != $gk) {
        header("Location: ?process=gk");
        exit; 
    }*/
	$mail=htmlentities($_POST['mail'], ENT_QUOTES, "UTF-8");
	$secret_code=htmlentities($_POST['secret_code'], ENT_QUOTES, "UTF-8");
	$kadi=htmlentities($_POST['kadi'], ENT_QUOTES, "UTF-8");
	$pass=htmlentities($_POST['pass'], ENT_QUOTES, "UTF-8");
    $pass=md5($pass);
    if($secret_code == "1234" || $secret_code == 1234) {
        @header("Location: ?error=secret");
	    exit;
    }

	function telkontrol($string) {
        return (preg_match('(([+][(]?[0-9]{1,3}[)]?)|([(]?[0-9]{4}[)]?))\s*[)]?[-\s\.]?[(]?[0-9]{1,3}[)]?([-\s\.]?[0-9]{3})([-\s\.]?[0-9]{3,4})', $string) ? true : false);
	}
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
		header("Refresh:0");
        exit;
	}
	$mysqli = @mysqli_query($baglanti,"SELECT * FROM user where mail='$mail' or kadi='$kadi'");
	if(@mysqli_num_rows($mysqli) > 0) { 
		@header("Location: ?error=user");
		exit;
	}	
    
    //Multiple Account Options
    /*$user_ipx = (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);
	$fracture = @mysqli_query($baglanti, "SELECT * FROM user where son_ip='$user_ipx'");
	if (@mysqli_num_rows($fracture) > 0) {
		@header("Location: ?process=account");
		exit;
	}*/

    $DICK_FRACTURE_FREE_UYELIK_PAKET_ID = "12";
    

	if ($baglanti->query("INSERT INTO user (mail, secret_code, kadi, pass,bakiye,rank,uyelik,uyelik_son) VALUES ('$mail', '$secret_code', '$kadi', '$pass', '0', '0', '$DICK_FRACTURE_FREE_UYELIK_PAKET_ID', '0')")) {
        header("Location: login?process=success");
        exit;

	}
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
      <title><?php echo $ayar["ad"];?></title>
      <meta name="keywords" content="<?php echo $ayar["keyword"];?>">
      <meta name="description" content="<?php echo $ayar["description"];?>">
    <link rel="icon" type="image/x-icon" href="../favicon.png"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="assets/css/elements/alert.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Saira&display=swap" rel="stylesheet">
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
</head>

<body class="form">
    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <h1 class="">Register</h1>
                        <p class="signup-link register">Do you already have an account?<a href="login"> Log In</a></p>
                        <form class="text-left" method="post" action="">
                            <div class="form">
                            <?php
                                if(@$_GET["error"] == "user") {
                                    echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Someone else is using this username.</div>';
                                }
                                /*if(@$_GET["process"] == "gk") {
                                    echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Enter the catpcha code correctly.</div>';
                                }*/
                                if(@$_GET["process"] == "secret") {
                                    echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Please enter a private secret code, not use default.</div>';
                                }
                                if(@$_GET["process"] == "account") {
                                    echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>You cant create multiple account.</div>';
                                }
                            ?>
                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">USERNAME</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="username" name="kadi" required type="text" class="form-control" placeholder="Username">
                                </div>

                                <div id="email-field" class="field-wrapper input">
                                    <label for="email">EMAIL</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign register"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                    <input id="email" name="mail" required type="text" value="" class="form-control" placeholder="Email">
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">PASSWORD</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="pass" required type="password" class="form-control" placeholder="Password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">SECRET CODE</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="text" name="secret_code" minlength="4" maxlength="4" pattern="[0-9]*" required type="number" class="form-control" placeholder="1234">
                                </div>

                                <div id="username-field" class="field-wrapper input">
                                    <label for="username">CAPTCHA <img class="guvenlik_resmi" src="korumakod.php"></label>
                                    <input id="username" name="gk" required type="text" autocomplete="off" class="form-control" placeholder="Captcha">
                                </div>

                                <div class="field-wrapper terms_condition">
                                    <div class="n-chk">
                                        <label style="font-size: 14px;color: #bfc9d4;padding-left: 31px;font-weight: 100;" class="new-control new-checkbox checkbox-primary">
                                          <input type="checkbox" required class="new-control-input">
                                          <span class="new-control-indicator"></span>I agree to the&nbsp;<span><a href="terms" style="color: #009688;" target="_blank"> Terms of Service</span></a>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Create Account</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>                    
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/authentication/form-2.js"></script>
</body>
</html>