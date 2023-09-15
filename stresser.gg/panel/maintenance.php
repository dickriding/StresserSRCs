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

if(@$_POST["kadi"]!=Null && @$_POST["pass"]!=Null){

			$kadi=htmlentities($_POST["kadi"], ENT_QUOTES, "UTF-8");

			$pass=htmlentities($_POST["pass"], ENT_QUOTES, "UTF-8");

			$pass=md5($pass);

	$sql_check = @mysqli_query($baglanti,"select * from user where kadi='$kadi' and pass='$pass'");

		if(@mysqli_num_rows($sql_check))  {

		

						$sonuc = $sql_check->fetch_assoc();

						if($sonuc["rank"]!="1" && $ayar["bakim"]=="1"){

							header("Location: maintenance");

					exit;

						}

						$ip=ipal();

						$tarih=date("Y-m-d H:i:s");

						$dataid=$sonuc["id"];

			$baglanti->query("UPDATE user SET son_ip='$ip',son_giris='$tarih' WHERE id='$dataid'");

						$_SESSION["login"]="1";

						$_SESSION["id"]=$sonuc["id"];

						$_SESSION["rank"]=$sonuc["rank"];

						$baglanti->query("INSERT INTO login (user, tarih, ip) VALUES ('$dataid','$tarih', '$ip')");

						header("Location: index");

						exit;



						

					}

					else{header("Location: ?error=pass");

					exit; }

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

    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png"/>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />

    <link href="assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />

    <!-- END GLOBAL MANDATORY STYLES -->

    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">

    <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">

    <link href="assets/css/pages/error/style-maintanence.css" rel="stylesheet" type="text/css" />

</head>

<body class="maintanence text-center">

    

    <div class="container-fluid maintanence-content">

        <div class="">

            <h1 class="error-title">Under Maintenance</h1>

            <p class="error-text">Thank you for visiting us.</p>

            <p class="text">We are currently working on making some improvements <br/> to give you better user experience.</p>

            <p class="text">Please visit us again shortly.</p>

            <a href="https://t.me/stresser_gg" class="btn btn-info mt-4">Telegram</a>

        </div>

    </div>

    

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->

    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>

    <script src="bootstrap/js/popper.min.js"></script>

    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->

</body>



</html>