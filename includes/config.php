<?php @session_start() ?>

<?php @ob_start() ?>

<?php

if ($_SERVER['HTTP_HOST'] == "localhost") {

	$db_server = "localhost";

	$db_user = "root";

	$db_pass = "";

	$db_name = "surecertify_db";
} else {

	$db_server = "localhost";

	$db_user = "avishbro_root";

	$db_pass = "8YZDeAF6UCnk2Re";

	$db_name = "surecertify_db";
}

ini_set("allow_call_time_pass_reference", "1");

date_default_timezone_set('Asia/Calcutta'); ///// change this zone as per your location


$serverpath = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

$rootpath = dirname($serverpath);

$path_parts = pathinfo($serverpath);

$date = getdate();

###################################################################

?>
