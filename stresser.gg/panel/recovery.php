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

if(@$_POST["kadi"]!=Null && @$_POST["secret_code"]!=Null && @$_POST["pass"]!=Null){

			$kadi=htmlentities($_POST["kadi"], ENT_QUOTES, "UTF-8");

			$pass=htmlentities($_POST["pass"], ENT_QUOTES, "UTF-8");

			$secret_code=htmlentities($_POST["secret_code"], ENT_QUOTES, "UTF-8");

			$korumakod = @$_SESSION['korumakod'];



/*$gk = @$_POST['gk'];



if($korumakod != $gk)

{

header("Location: ?is=gk");

					exit; 

}*/

	$sql_check = @mysqli_query($baglanti,"select * from user where kadi='$kadi' and secret_code='$secret_code'");

				$sonuc = $sql_check->fetch_assoc();

					if($sonuc["id"]==Null){

				header("Location: ?is=0");

					exit; 

					}

		

    $newpass2 = md5($pass);

        $update = mysqli_query($baglanti,"UPDATE user SET pass='$newpass2' WHERE kadi='$kadi' and secret_code='$secret_code'");





					





      

header("Location: ?is=1");

exit;

}

ob_end_flush();

?><!DOCTYPE html>

<html lang="tr">

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



                        <h1 class="">Recovery</h1>

                        

                        <form class="text-left" method="post" action="">

                            <div class="form">



		<?php if(@$_GET["is"]=="0"){

	echo '<div class="alert alert-danger">Incorrect information was entered.</div>';

} if(@$_GET["is"]=="1"){

	echo '<div class="alert alert-success">Your password has been updated.</div>';

/*}  if(@$_GET["is"]=="gk"){

	echo '<div class="alert alert-danger">The security code was entered incorrectly.</div>';

}*/ ?>

                                <div id="username-field" class="field-wrapper input">

                                    <label for="username">USERNAME</label>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>

                                    <input id="username" name="kadi" required type="text" class="form-control" placeholder="Username">

                                </div>



                                <div id="password-field" class="field-wrapper input mb-2">

                                    <div class="d-flex justify-content-between">

                                        <label for="password">NEW PASSWORD</label>

                                    </div>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>

                                    <input id="password" name="pass" required type="password" class="form-control" placeholder="New Password">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>

                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">

                                    <div class="d-flex justify-content-between">

                                        <label for="password">SECRET CODE</label>

                                    </div>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>

                                    <input id="password" name="secret_code" required type="text" class="form-control" autocomplete="off" placeholder="Secret Code">

                                </div>

   <div id="username-field" class="field-wrapper input">

                                    <label for="username">CATPCHA<img class="guvenlik_resmi" src="korumakod.php"></label>

                                    <input id="username" name="gk" required type="text" autocomplete="off" class="form-control" placeholder="Captcha">

                                </div>

                                <div class="d-sm-flex justify-content-between">

                                    <div class="field-wrapper">

                                        <button type="submit" class="btn btn-primary" value="">Update Password</button>

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