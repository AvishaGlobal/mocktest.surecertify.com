<?php include("includes/config.php");?>
<?php include("includes/database.php");?>
<?php include("includes/common.php");?>
              <div class="padding-15 margin-B-10">
                <h4>Available Exams</h4>
</div>
                
                <table width="100%" class="table table-striped table-bordered">
  <tr class="ahead">
    <td bgcolor="#FFFFC1"><strong>Exams</strong></td>
    <td bgcolor="#FFFFC1"><strong>Subjects</strong></td>
    <td bgcolor="#FFFFC1"><strong>Course</strong></td>
    <td bgcolor="#FFFFC1">&nbsp;</td>
  </tr>
<?php
//$Swwlpapsql = "select * from test_series_tbl where admin_id =  '".$_SESSION['InstID']."' and subject_title IN ($Examgiving)";
$Swwlpapsql = "select * from test_series_tbl";
$Swwlpapres = mysql_query($Swwlpapsql) or die("Error1".mysql_error());
$SwwlpapNums = mysql_num_rows($Swwlpapres);
if($SwwlpapNums){
while($SwwlpapArr = mysql_fetch_array($Swwlpapres)){


$Sellsql123 = "select * from subjects where sid = '".$SwwlpapArr['subject_title']."'";
$Sellres123 = mysql_query($Sellsql123) or die("Error2".mysql_error());
$SellArr123 = mysql_fetch_array($Sellres123);

$seltotquesql = "select * from test_questions where tsid = '".$SwwlpapArr['tsid']."'";
$seltotqueres = mysql_query($seltotquesql) or die("Error3".mysql_error());
$seltotquenum = mysql_num_rows($seltotqueres);
?>
<?
			$Urls = "ins.php?SubjectIDs=".base64_encode($SwwlpapArr['tsid']);
 									  ?>
  <tr>
    <td><strong><?=$SwwlpapArr['test_title']?></strong> <br />

<strong>Duration:</strong> <?=$SwwlpapArr['duration']?> min <br />
<strong>Total Question:</strong>  <?=$seltotquenum?><br />
<strong>Total Marks:</strong> <?=$SwwlpapArr['marks']?></td>
    <td valign="top">
    <? 
	$Mnllsql = "select * from exam_subject where tsr_id = '".$SwwlpapArr['tsid']."' order by sbsid";
	$Mnllres = mysql_query($Mnllsql) or die("Error4".mysql_error());
	while($Mnllarr = mysql_fetch_array($Mnllres)){
	?>
   <strong> <?=$Mnllarr['subject_name']?> :</strong> <?=$Mnllarr['qfrom']?>-<?=$Mnllarr['qto']?> <br />
    <? } ?></td>
    <td><?=$SellArr123['s_title']?></td>
    <td><button class="btn btn-warning" onClick="location.href='<?=$Urls?>'">Start Test</button></td>
  </tr>
   
   <? } }else{ ?>
<tr>
    <td colspan="4" align="center">&nbsp;</td>
    </tr>

<? } ?>
</table>

    
                
  