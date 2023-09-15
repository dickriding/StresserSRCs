<?php
ob_start();
session_start();
include("config.php");
include("config2.php");
$tarih = date("Y-m-d");
$data = mysqli_query($baglanti, "select * from user where uyelik!='0' and uyelik_son!='0' and uyelik_son < '$tarih'");
while ($kontrol = mysqli_fetch_array($data)) {

	$userid = $kontrol["id"];
	$baglanti->query("UPDATE user SET  uyelik='0', uyelik_son='' WHERE id='$userid'");
}

?>OK