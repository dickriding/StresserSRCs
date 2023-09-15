<?php
require_once(__DIR__."/inc/CloudFirewall.php");
use CF\CloudFirewall;

$firewall = new CloudFirewall('xerinio@protonmail.com', '62483594630d59beb376557a935b26c33c0ce', '25bad07b2d111ec8d33fc8f1b51391cd');

$firewall->sqlInjectionBlock(false);
$firewall->xssInjectionBlock(false);
$firewall->cookieStealBlock(false);
//$firewall->antiFlood(5, 20, 5, false);


if($_SERVER["SCRIPT_NAME"] != "/panel/pay-callback.php") {
	if($_SERVER['HTTP_HOST']=="196.118.66.205"){ header("HTTP/1.0 404 Not Found"); die(); }
}


@$baglanti = new mysqli('localhost', 'root', '', 'web');
$baglanti->set_charset("utf8mb4");
	if(mysqli_connect_error())

	{

		echo mysqli_connect_error();

		exit;

	}

date_default_timezone_set('Europe/Istanbul'); 

function ipal(){
  if(getenv("HTTP_CLIENT_IP")) {
    $ip = getenv("HTTP_CLIENT_IP");
  } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
    $ip = getenv("HTTP_X_FORWARDED_FOR");
    if (strstr($ip, ',')) {
      $tmp = explode (',', $ip);
      $ip = trim($tmp[0]);
    }
  } else {
    $ip = getenv("REMOTE_ADDR");
  }
  return $ip;
}

	function kisalt($kelime, $str = 10)
	{
		if (strlen($kelime) > $str)
		{
			if (function_exists("mb_substr")) $kelime = mb_substr($kelime, 0, $str, "UTF-8").'..';
			else $kelime = substr($kelime, 0, $str).'..';
		}
		return $kelime;
	}
?>