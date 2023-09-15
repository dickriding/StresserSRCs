<?php ob_start();

session_start();

include("config.php");

include("config2.php");



	$ayar = @mysqli_query($baglanti,"select * from ayarlar where id='1'");

	$ayar = $ayar->fetch_assoc();



$merchant_id = $ayar["coinpayments_merchant"];

$secret = $ayar["coinpayments_secret"];



if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
  die("No HMAC signature sent");
}



$merchant = isset($_POST['merchant']) ? $_POST['merchant']:'';
if (empty($merchant)) {
  die("No Merchant ID passed");
}



if ($merchant != $merchant_id) {
  die("Invalid Merchant ID");
}



$request = file_get_contents('php://input');
if ($request === FALSE || empty($request)) {
  die("Error reading POST data");
}



$hmac = hash_hmac("sha512", $request, $secret);
if ($hmac != $_SERVER['HTTP_HMAC']) {
  die("HMAC signature does not match");
}

	$custom=htmlentities($_POST["custom"], ENT_QUOTES, "UTF-8");
	$sip = @mysqli_query($baglanti,"select * from odeme where benzersiz='$custom' and durum='0' or  benzersiz='$custom' and durum='3' order by id desc");
	$sip = $sip->fetch_assoc();
	if($sip["id"]==Null){

		echo "OK";

		exit;

	}

	$sipid=$sip["id"];

			$userid=$sip["user"];

			$money=$sip["miktar"];
if($_POST["status"]>="100"){
	$user = @mysqli_query($baglanti,"select * from user where id='$userid'");

	$user = $user->fetch_assoc();

if($user["id"]==Null){

	echo "OK";

	exit;

}

$newbal=$user["bakiye"]+$money;



	$baglanti->query("UPDATE user SET  bakiye='$newbal' WHERE id='$userid'");

	$baglanti->query("UPDATE odeme SET  durum='1' where benzersiz='$custom' order by id desc");
}
elseif($_POST["status"]<"0"){
	$baglanti->query("UPDATE odeme SET  durum='2' where benzersiz='$custom' order by id desc");
}
else{
	$baglanti->query("UPDATE odeme SET  durum='3' where benzersiz='$custom' order by id desc");
}
	echo "OK";

ob_end_flush();