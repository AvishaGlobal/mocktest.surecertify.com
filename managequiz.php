<?php include("includes/config.php");?>
<?php include("includes/database.php");?>
<?php
$Fsesql = "select * from quizmng_tbl where q_session = '".$_SESSION['q_ses']."' and memid = '".$_SESSION['StudId']."' and ques_id = '".$_REQUEST['quesid']."' and option_id = '".$_REQUEST['optvalue']."'";
$Fseres = $db->query($Fsesql);
$FseNumss = $Fseres->num_rows;
//echo $FseNumss;
if($FseNumss==0)
{
	$Innssql = "insert into quizmng_tbl set q_session = '".$_SESSION['q_ses']."', memid = '".$_SESSION['StudId']."', ques_id = '".$_REQUEST['quesid']."', option_id = '".$_REQUEST['optvalue']."', upd_date = '".time()."', visit_later = ''";
	$InnsNums = $db->query($Innssql);
}else{
		$Innssql = "update quizmng_tbl set option_id = '".$_REQUEST['optvalue']."', upd_date = '".time()."', visit_later = '' where q_session = '".$_SESSION['q_ses']."' and memid = '".$_SESSION['StudId']."' and ques_id = '".$_REQUEST['quesid']."' and option_id = '".$_REQUEST['optvalue']."'";
	$InnsNums = $db->query($Innssql);

}
?>