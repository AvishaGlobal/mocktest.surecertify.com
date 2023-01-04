<?php

@ $db = new mysqli($db_server, $db_user, $db_pass, $db_name);

$db->select_db(@$new_dbname);

$result = $db->query("select * from tbl_users");

$fectRow = $result->fetch_assoc();

$admin_email_from				=	$fectRow['admin_email_from'];

$admin_email_to					=	$fectRow['admin_email_to'];

$website_title					=	$fectRow['website_title'];

$website_name					=	$fectRow['website_name'];

ini_set("allow_call_time_pass_reference", "1");

	date_default_timezone_set('Asia/Calcutta'); ///// change this zone as per your location



###########################################################################################

function sendsms($mobno, $sms){



	$sms = urlencode($sms);

	$apiCallUrl = "http://182.18.162.128/api/mt/SendSMS?user=gslinfra&password=Admin123&senderid=VERTIG&channel=Trans&DCS=0&flashsms=0&number=$mobno&text=$sms&route=27";

	$curlHandle = curl_init(); // init curl

	curl_setopt($curlHandle, CURLOPT_URL, $apiCallUrl); // set the url to fetch

	curl_setopt($curlHandle, CURLOPT_HEADER, 0); // set headers (0 = no headers in result)

	curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1); // type of transfer (1 = to string)

	curl_setopt($curlHandle, CURLOPT_TIMEOUT, 15); // time to wait in seconds

	$content = curl_exec($curlHandle); // Make the call for sending the SMS

	if (preg_match("/\bresponse\b/i", $content)) {

		$MSg = "Message Sent Successfully.";

	} else {

		$MSg = "Invalid Phone Number.";

	}

	curl_close($curlHandle); // Close the connection to Clickatell

	return $MSg;

}



function sendsmspaymet($mobno, $sms){



if($otpreq==0){



	$sms = urlencode($sms);

	$apiCallUrl = "http://182.18.162.128/api/mt/SendSMS?user=gslinfra&password=Admin123&senderid=FLIPLA&channel=Trans&DCS=0&flashsms=0&number=$mobno&text=$sms&route=27";

	$curlHandle = curl_init(); // init curl

	curl_setopt($curlHandle, CURLOPT_URL, $apiCallUrl); // set the url to fetch

	curl_setopt($curlHandle, CURLOPT_HEADER, 0); // set headers (0 = no headers in result)

	curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1); // type of transfer (1 = to string)

	curl_setopt($curlHandle, CURLOPT_TIMEOUT, 15); // time to wait in seconds

	$content = curl_exec($curlHandle); // Make the call for sending the SMS

	if (preg_match("/\bresponse\b/i", $content)) {

		$MSg = "Message Sent Successfully.";

	} else {

		$MSg = "Invalid Phone Number.";

	}

	curl_close($curlHandle); // Close the connection to Clickatell

	return $MSg;

	}

}







function GetName($Smemid){

	global $db;

	$Selmmtsql = "select name from member where mem_id = '".$Smemid."'";

	$Selmmtres = $db->query($Selmmtsql);

	$Selmmtarr = $Selmmtres->fetch_assoc();

	return $Selmmtarr['name'];

}



function GetTotSeries($CourseID)

{

global $db;

$Selmmjoisql = "select test_title from test_series_tbl where subject_title = '".$CourseID."'";

$Selmmjoires = $db->query($Selmmjoisql);

$Selmmjoinum = $Selmmjoires->num_rows;

return $Selmmjoinum;

}



function EwalletBalance($memids)

{

	global $db;

	$Selbalewalletsql = "select sum(creditamt) as totreceivedamt from ewallet_tbl where memid = '".$memids."'";

	$Selbalewalletres = $db->query($Selbalewalletsql);

	$Selbalewalletnum = $Selbalewalletres->num_rows;

	 if($Selbalewalletnum){

		$Selbalewalletrarr = $Selbalewalletres->fetch_assoc();

		$totreceivedamt = $Selbalewalletrarr['totreceivedamt'];

		$Selbalewalletdebitsql = "select sum(cur_withdraw_amt) as totdebitamt from payment_withdraw where memid = '".$memids."'";

		$Selbalewalletdebitres = $db->query($Selbalewalletdebitsql);

		$Selbalewalletdebitarr = $Selbalewalletdebitres->fetch_assoc();

		return $totreceivedamt-$Selbalewalletdebitarr['totdebitamt'];

	 }else{

		 return 0;

	 }

}

function totfundreceived($mmeids){

global $db;

	$Selbalewalletsql = "select sum(creditamt) as totreceivedamt from ewallet_tbl where memid = '".$mmeids."'";

 	$Selbalewalletres = $db->query($Selbalewalletsql);

	$Selbalewalletnum = $Selbalewalletres->num_rows;

	 if($Selbalewalletnum){

		$Selbalewalletrarr = $Selbalewalletres->fetch_assoc();

		$totreceivedamt = $Selbalewalletrarr['totreceivedamt'];

 		return $totreceivedamt;

	 }else{

		 return 0;

	 }



}



function totalfunduse($memids)

{

	global $db;

	$Selbalewalletsql = "select sum(debitamt) as totdebitamt from ewallet_tbl where memid = '".$memids."'";

	$Selbalewalletres = $db->query($Selbalewalletsql);

	$Selbalewalletnum = $Selbalewalletres->num_rows;

	 if($Selbalewalletnum){

		$Selbalewalletrarr = $Selbalewalletres->fetch_assoc();

		$totreceivedamt = $Selbalewalletrarr['totdebitamt'];

		 

		return $totreceivedamt-$Selbalewalletdebitarr['totdebitamt'];

	 }else{

		 return 0;

	 }

}



#######################################################################

function fund_wallet($GMemId){

global $db;

$seemnsql = "select sum(amount) as totmfund from member_fund_rec where memid ='".$GMemId."' and status =2";

$seemnres = $db->query($seemnsql);

$seemnarr = $seemnres->fetch_assoc();



$Gwlseemnsql = "select sum(uamount) as totmfundmuse from member_fund_use where memid ='".$GMemId."' and status =1";

$Gwlseemnres = $db->query($Gwlseemnsql);

$Gwlseemnarr = $Gwlseemnres->fetch_assoc();



$BalanceFund = $seemnarr['totmfund']-$Gwlseemnarr['totmfundmuse'];



return $BalanceFund;

}
