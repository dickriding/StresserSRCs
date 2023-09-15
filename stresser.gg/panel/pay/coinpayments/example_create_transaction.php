<?php
/*
	CoinPayments.net API Example
	Copyright 2014-2018 CoinPayments.net. All rights reserved.	
	License: GPLv2 - http://www.gnu.org/licenses/gpl-2.0.txt
*/

//potewop372@art2427.com
//test@123
	require('./coinpayments.inc.php');
	$cps = new CoinPaymentsAPI();
	$cps->Setup('32730a5e3d9712eD5094c49FCd1cF254a5c44D6e1de33B911478b99b5Fc7d6d8', '4423af2003dd0b3104f13564ec916e17bbbd81639ed2df0da6b491f2df3215f8');

	$req = array(
		'amount' => 10.00,
		'currency1' => 'TRY',
		'currency2' => 'BTC',
		'buyer_email' => 'your_buyers_email@email.com',
		'item_name' => 'Test Item/Order Description',
		'address' => '', // leave blank send to follow your settings on the Coin Settings page
		'ipn_url' => 'http://localhost/ddos/pay/ipn_handler.php',
	);
	// See https://www.coinpayments.net/apidoc-create-transaction for all of the available fields
			
	$result = $cps->CreateTransaction($req);
	if ($result['error'] == 'ok') {
		$le = php_sapi_name() == 'cli' ? "\n" : '<br />';
		print 'Transaction created with ID: '.$result['result']['txn_id'].$le;
		print 'Buyer should send '.sprintf('%.08f', $result['result']['amount']).' BTC'.$le;
		print 'Status URL: '.$result['result']['status_url'].$le;
	} else {
		print 'Error: '.$result['error']."\n";
	}
