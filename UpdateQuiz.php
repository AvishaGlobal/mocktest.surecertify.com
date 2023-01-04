<?php include("includes/config.php");?>
<?php include("includes/database.php");?>
<?php
$Inmdelsql = "delete from quizmng_tbl where q_session = '".$_SESSION['q_ses']."' and memid = '".$_SESSION['StudId']."' and ques_id = '".$_REQUEST['quesid']."'";
$Inmdelres = $db->query($Inmdelsql);
 $Fsesql = "select * from quizmng_tbl where q_session = '".$_SESSION['q_ses']."' and memid = '".$_SESSION['StudId']."' and ques_id = '".$_REQUEST['quesid']."'";
$Fseres = $db->query($Fsesql);
$FseNumss = $Fseres->num_rows;
//echo $FseNumss;
if($FseNumss==0)
{
	$Innssql = "insert into quizmng_tbl set q_session = '".$_SESSION['q_ses']."', memid = '".$_SESSION['StudId']."', ques_id = '".$_REQUEST['quesid']."', option_id = '".$_REQUEST['optvalue']."', upd_date = '".time()."', visit_later = 1";
	$InnsNums = $db->query($Innssql);
}else{
		$Innssql = "update quizmng_tbl set option_id = '', upd_date = '".time()."', visit_later = 1 where q_session = '".$_SESSION['q_ses']."' and memid = '".$_SESSION['StudId']."' and ques_id = '".$_REQUEST['quesid']."'";
	$InnsNums = $db->query($Innssql);

}
 ?>