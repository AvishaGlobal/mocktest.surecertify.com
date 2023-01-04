<? include("../../includes/config.php");?>
<? include("../../includes/database.php");?>
<? include("../../includes/common.php");?>
<?
 ###############################################
$TestIDds = base64_decode($_REQUEST['TsIDs']);
$Selssql = "select * from test_series_tbl where tsid = '".$TestIDds."'";
$Selsres = $db->query($Selssql);
$SelsNum = $Selsres->num_rows;
$SelsArrys = $Selsres->fetch_assoc();
$Timing = $SelsArrys['duration']*60;
 $TotMarks = $SelsArrys['marks']; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::Online Exam: Test Series</title>
<link href="teststyle11.css" rel="stylesheet" type="text/css" />

 <script>
 var isNS = (navigator.appName == "Netscape") ? 1 : 0;
  if(navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);
  function mischandler(){
   return false;
 }
  function mousehandler(e){
 	var myevent = (isNS) ? e : event;
 	var eventbutton = (isNS) ? myevent.which : myevent.button;
    if((eventbutton==2)||(eventbutton==3)) return false;
 }
 document.oncontextmenu = mischandler;
 document.onmousedown = mousehandler;
 document.onmouseup = mousehandler;
  </script>
  <script language="javascript" type="text/javascript" src="jsaa4a2.js"></script>
  <?
			$Snumquessql = "select * from test_questions where tsid = '".base64_decode($_REQUEST['TsIDs'])."'  order by quesorder";
 			$SnumquesRes = $db->query($Snumquessql);
			$SnumquesNum = $SnumquesRes->num_rows;
			$QuesMArks = $TotMarks/$SnumquesNum;
			$Msn = 1;
			$Corret = 0;
			$Wrong = 0;
			$NotTest = 0;
			while($SnumquesArr = $SnumquesRes->fetch_assoc()){
			$vsv = $Msn++;
			$Seloptq = "select * from quizmng_tbl where q_session = '".$_SESSION['q_ses']."' and memid = '".$_SESSION['StudId']."' and ques_id = '".$SnumquesArr['tqid']."'";
 			$Seloptr = $db->query($Seloptq);
			$SeloptNums = $Seloptr->num_rows;
 			if($SeloptNums){
			$SeloptA = $Seloptr->fetch_assoc();
			if($SeloptA['visit_later']!=1){
  			############################################################
				$SelcorAns = "select * from  test_answer where tqid = '".$SnumquesArr['tqid']."'";
				$SelcorRes = $db->query($SelcorAns);
				$SelcorArr = $SelcorRes->fetch_assoc();
				$crtAns = $SelcorArr['is_correct'];
  				if($SeloptA['option_id']==$crtAns){
				$TotCtMarks += $SelcorArr['correct_marks'];
				$Corret = $Corret +1;
				}else{
				$Wrong = $Wrong+1;
				$TotWrMarks += $SelcorArr['wrong_marks']; 
				}
			}else{
			$NotTest = $NotTest+1;
			}
			############################################################
			}else{
			$NotTest = $NotTest+1;
			}
			}
############################################################

			?>  
 </head>
<body onselectstart="return false;" style="-moz-user-select: none;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td width="16%" valign="top"><table width="181" border="0" cellspacing="0" cellpadding="0" style="width:250px; ">
      <tr>
        <td width="177" height="60" align="center" valign="middle" bgcolor="#6E91B9<h4 style="color:#fff;margin: 0;padding: 14px 15px;font-size: 22px;"><font>My</font> <span>Certification</span></h4></td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#4F6A25" style="border-right:1px solid #000000; color:#FFFFFF; font-weight:bold; height:25px;"><table width="100%" class="legentlist">
          <tr class="trborder">
            <td height="30" colspan="2" valign="middle" bgcolor="#6E91B9">Result</td>
          </tr>
          <tr class="trborder">
            <td width="5%" height="25" align="center" valign="middle" bgcolor="#666666">&nbsp;
                <?=$Corret?></td>
            <td width="45%" bgcolor="#666666">Correct Ans </td>
          </tr>
          <tr class="trborder">
            <td height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;
                <?=$Wrong?></td>
            <td bgcolor="#CCCCCC">Incorrect Ans </td>
          </tr>
          <tr>
            <td height="25" align="center" valign="middle" bgcolor="#666666">&nbsp;
                <?=$NotTest?></td>
            <td bgcolor="#666666">Un-attempted</td>
          </tr>
          <tr>
            <td height="25" align="center" valign="middle" bgcolor="#6E91B9">&nbsp;<? echo $NotTest+$Wrong+$Corret ?></td>
            <td bgcolor="#6E91B9">Total Question </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#4F6A25" style="border-right:1px solid #000000; color:#FFFFFF; font-weight:bold; height:25px;">&nbsp;</td>
      </tr>
    <tr>
        <td align="left" valign="middle" bgcolor="#4F6A25" style="border-right:1px solid #000000; color:#FFFFFF; font-weight:bold; height:25px;"><table width="100%" class="legentlist">
        <?
        $FnMarks = $TotCtMarks - $TotWrMarks;
		?>
          <tr class="trborder">
            <td height="30" colspan="2" valign="middle" bgcolor="#6E91B9">Marks Details</td>
          </tr>
          <tr class="trborder">
            <td width="5%" height="25" align="center" valign="middle" bgcolor="#666666">&nbsp;
                <?=$TotCtMarks?></td>
            <td width="45%" bgcolor="#666666">Correct Marks </td>
          </tr>
          <tr class="trborder">
            <td height="25" align="center" valign="middle" bgcolor="#CCCCCC">&nbsp;
                <?=$TotWrMarks?></td>
            <td bgcolor="#CCCCCC">Incorrect Marks </td>
          </tr>
          
          <tr>
            <td height="25" align="center" valign="middle" bgcolor="#6E91B9">&nbsp;<? echo $FnMarks; ?></td>
            <td bgcolor="#6E91B9">/<?=$TotMarks?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#4F6A25" style="border-right:1px solid #000000; color:#FFFFFF; font-weight:bold; height:25px;">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="middle" bgcolor="#4F6A25" style="border-right:1px solid #000000; color:#FFFFFF; font-weight:bold; height:25px;"><table width="100%">
            <tr height="20" width="100%" class='pages'>
              <td bgcolor="#6E91B9">&nbsp;</td>
            </tr>
            <tr height="20" width="100%" class='pages'>
              <td bgcolor="#000000"><div id="sideNav">
                <table width="100%" class="legentlist">
                  <tr class="trborder">
                    <td colspan="4" valign="middle" bgcolor="#6E91B9"><span class="">&nbsp;</span><b>Legends</b></td>
                    </tr>
                  <tr class="trborder">
                    <td width="5%" valign="middle" bgcolor="#6E91B9"><span class="solved">&nbsp;</span></td>
                    <td width="45%" nowrap="nowrap" bgcolor="#6E91B9">Attempted</td>
                    <td width="45%" nowrap="nowrap" bgcolor="#6E91B9"><span class="marked">&nbsp;</span></td>
                    <td width="45%" nowrap="nowrap" bgcolor="#6E91B9">Visit Later</td>
                  </tr>
                  
                  <tr>
                    <td valign="middle" bgcolor="#6E91B9"><span class="unsolved">&nbsp;</span></td>
                    <td nowrap="nowrap" bgcolor="#6E91B9">Un-attempted</td>
                    <td nowrap="nowrap" bgcolor="#6E91B9">&nbsp;</td>
                    <td nowrap="nowrap" bgcolor="#6E91B9">&nbsp;</td>
                  </tr>
                </table>
              </div></td>
            </tr>
            <tr height="20" width="100%" class='pages'>
              <td bgcolor="#6E91B9">&nbsp;</td>
            </tr>
            <tr height="20" width="100%" class='pages'>
              <td bgcolor="#6E91B9" id="Suggestions"><input name="TsIDs" type="hidden" id="TsIDs" value="<?=$_REQUEST['TsIDs']?>" />
                <input name="mdlev" type="hidden" id="mdlev" value="<?=$_REQUEST['mdlev']?>" /></td>
            </tr>
            
            <tr height="20" width="100%" class='pages'>
              <td height="80" valign="bottom" bgcolor="#6E91B9"><!--<img src="images/logo.jpg" width="279" />--></td>
            </tr>
             
        </table></td>
      </tr>
    </table></td>
    <td width="84%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" align="right" bgcolor="#6E91B9"></td>
      </tr>
      <tr>
        <td height="25" align="right" bgcolor="#4F692A" style="border-bottom:1px solid #000000;"><a href="../index.php?PageURL=mocktest" style="background-color:#FFF; color:#000;">My Account</a></td>
      </tr>
      <tr>
        <td><div class="paper" id="paper">
                         
    <div id="qnpaper" class="qnpaper">
	<?php
	$Squstionsql = "select * from test_questions where tsid = '".base64_decode($_REQUEST['TsIDs'])."' order by quesorder";
	$SqustionRes = $db->query($Squstionsql);
	$sns = 1;
	while($SqustionArr = $SqustionRes->fetch_assoc()){
	$selansssql  = "select * from test_answer where tqid = '".$SqustionArr['tqid']."'";
	$selanssrres = $db->query($selansssql);
	$selanssrArr = $selanssrres->fetch_assoc();
	##########################################################################
	$Seloptq = "select * from quizmng_tbl where q_session = '".$_SESSION['q_ses']."' and memid = '".$_SESSION['StudId']."' and ques_id = '".$SqustionArr['tqid']."'";
			$Seloptr = $db->query($Seloptq);
			$SeloptNums = $Seloptr->num_rows;
			if($SeloptNums){
			$SeloptA = $Seloptr->fetch_assoc();
					if($SeloptA['visit_later']==1){
					$Clss = "ansVisitL";
					$Visiable = "none";
					}else{
					$Clss = "solving";
					$Visiable = "block";
					}
			}else{
			$Clss = "unsolved";
			$Visiable = "none";
			}
		#######################################################################
	?>
        <a id='firstqn'></a><div class='fullQ' id='q_1'><div class='qHead'><table>
		<tr><td class='q_no'><div class='<?=$Clss?>'><?=$sns++?></div><a id='qnLink-<?=$sns?>'></a></td>
			<td class='q_txt'><div id='q_txt_1'><div class='question'> 
            <?php if($SqustionArr['qstype']=='text'){?>
              <p> <?=$SqustionArr['question']?></p>
              <?php }else{ ?>
			<img src="admin/<?=$SqustionArr['questionimg']?>" style="max-width:680px;"  />
            <?php } ?>
			</div><div class='option'> </div></div></td>
			<td class='q_rt'><div class='marks'><?=number_format($QuesMArks,2)?> Mark/s</div><div class='paraview'></div></td>
		</tr></table></div><div class='answer'> <div id='answer-area'>
		<div class='tdanswer'><div class='optionss'> Answer:
		<? 
		$Chars = 64;
		for($i=1;$i<=$selanssrArr['answer'];$i++){?>
		<input type='radio' id='ans-<?=$sns-1?>-<?=$i?>' name='ans-<?=$sns-1?>' align='left' value='<?=$i?>' <? if($SeloptA['option_id']==$i){?> checked="checked"<? } ?> disabled="disabled"> <?=chr($Chars+$i)?>
		<? } ?>
		 &nbsp;</div></div>
		  
		 
		<div class='tdvisitL'><div id='vl_<?=$sns-1?>' class='visitLaters'><input  type='checkbox' name='later' value='Mark' id ='visitLater_<?=$sns-1?>' <? if($SeloptA['visit_later']==1){?> checked="checked" style="color:#000099;" <? } ?> disabled="disabled"><label for='visitLater_1'>Visit Later</label></div></div>
		</div></div></div>
		<? 
		$SelcorAns = "select * from  test_answer where tqid = '".$SqustionArr['tqid']."'";
		$SelcorRes = $db->query($SelcorAns);
		$SelcorArr = $SelcorRes->fetch_assoc();
		$crtAns = $SelcorArr['is_correct'];
		?>
		<div class='answer' style="color:#0000FF; font-weight:bold;">Correct Answer : <?=chr($Chars+$crtAns)?><br />
		<? if($SelcorArr['ansdetails']){?>
		<div align="justify" style="padding:10px; color:#000000; font-weight:normal;"><?=$SelcorArr['ansdetails']?></div>
		<? } ?>
		</div>
		<? }?>
    </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#4F6A25" style="border-top:1px solid #000000; height:25px;">&nbsp;</td>
  </tr>
 </table>
</body>
</html>
 