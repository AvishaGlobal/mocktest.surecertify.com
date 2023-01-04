<?php include("includes/config.php");?>
<?php include("includes/database.php");?>
<?php
 
	$Innssql = "delete from quizmng_tbl where q_session = '".$_SESSION['q_ses']."' and memid = '".$_SESSION['StudId']."' and ques_id = '".$_REQUEST['quesid']."'";
	$InnsNums = $db->query($Innssql);

 ?>