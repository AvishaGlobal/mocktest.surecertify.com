<?
$Tsts = explode("|",$_REQUEST['ExamID']);
$Setesql = "select * from  test_series_tbl where tsid = '".$Tsts['2']."'";
$Seteres = mysql_query($Setesql) or die(mysql_error());
$Setearr = mysql_fetch_array($Seteres);
							################################################################################
			$Snumquessql = "select * from test_questions where tsid = '".$Tsts['2']."'  order by quesorder";
 			$SnumquesRes = mysql_query($Snumquessql) or die(mysql_error());
			$SnumquesNum = mysql_num_rows($SnumquesRes);
			$QuesMArks = $TotMarks/$SnumquesNum;
			$Msn = 1;
			$Corret = 0;
			$Wrong = 0;
			$NotTest = 0;
			while($SnumquesArr = mysql_fetch_array($SnumquesRes)){
			$vsv = $Msn++;
			$Seloptq = "select * from quizmng_tbl where q_session = '".$_REQUEST['ExamID']."' and memid = '".$_SESSION['StudId']."' and ques_id = '".$SnumquesArr['tqid']."'";
			$Seloptr = mysql_query($Seloptq) or die(mysql_error());
			$SeloptNums = mysql_num_rows($Seloptr);
			if($SeloptNums){
			$SeloptA = mysql_fetch_array($Seloptr);
			if($SeloptA['visit_later']!=1){
  			############################################################
				$SelcorAns = "select * from  test_answer where tqid = '".$SnumquesArr['tqid']."'";
				$SelcorRes = mysql_query($SelcorAns) or die(mysql_error());
				$SelcorArr = mysql_fetch_array($SelcorRes);
				$crtAns = $SelcorArr['is_correct'];
 				if($SeloptA['option_id']==$crtAns){
				$Corret = $Corret +1;
				}else{
				$Wrong = $Wrong+1;
				}
			}else{
			$NotTest = $NotTest+1;
			}
			############################################################
			}else{
			$NotTest = $NotTest+1;
			}
			}
			
			$TotmarksGet = $Corret*$Setearr['q_correct'] - $Wrong*$Setearr['q_incorrect'];
			$TotPercent = $TotmarksGet*$Setearr['marks']/100;
			$Urls = "ShowTestResults.php?TsIDs=".base64_encode($Tsts['2'])."&mdlev=".$_REQUEST['mdlev'];
 			################################################################################
?>
              <div class="padding-15 margin-B-10">
                <h4>Results Details</h4>
</div>
                
                <table width="100%" class="table table-striped table-bordered">
  <tr class="ahead">
    <td bgcolor="#FFFFC1">&nbsp;</td>
    
    <td width="5%" nowrap bgcolor="#FFFFC1"><!--<button class="btn btn-info" value="Edit">Question Report</button>--></td>
    <td width="11%" nowrap bgcolor="#FFFFC1"><!--<button class="btn btn-info" value="Edit">Solution Report</button>--></td>
    <td width="5%" nowrap bgcolor="#FFFFC1"><button class="btn btn-info" value="Edit">Score Card</button></td>
  </tr>
	 
  <tr>
    <td colspan="4"><table style="width: 100%;">       
        <tr>
            <td height="50" bgcolor="#CCFFFF" class="width20">
                <strong>Total Marks of Test</strong>            </td>
            <td bgcolor="#CCFFFF" class="textright width10"><span class="contact-frm-name">
              <?=$Setearr['marks']?>
            </span></td>
            <td bgcolor="#CCFFFF" class="spacer12px borderright"></td>
            <td bgcolor="#CCFFFF" class="spacer12px"></td>
            <td bgcolor="#CCFFFF" class="width20">
                <strong>My Marks</strong>            </td>
            <td bgcolor="#CCFFFF" class="textright width10"><?=$TotmarksGet?></td>
            <td bgcolor="#CCFFFF" class="spacer12px borderright"></td>
            <td bgcolor="#CCFFFF" class="spacer12px"></td>
            <td bgcolor="#CCFFFF" class="width25">
                <strong>Correct/Incorrect Question</strong>            </td>
            <td bgcolor="#CCFFFF" class="textright width10">
                <span id="dnn_ctr544_Scorecard_lblCorrectIncorrect"><?=$Corret?> / <?=$Wrong?></span>            </td>
        </tr>  
        <tr>
            <td height="50" bgcolor="#FFFFFF" class="width20">
                <strong>Total Question of Test</strong>            </td>
            <td bgcolor="#FFFFFF" class="textright width10"><?=$SnumquesNum?></td>
            <td bgcolor="#FFFFFF" class="spacer12px borderright"></td>
            <td bgcolor="#FFFFFF" class="spacer12px"></td>
            <td bgcolor="#FFFFFF" class="width15">
                <strong>My Percentile</strong>            </td>
            <td bgcolor="#FFFFFF" class="textright width10">
                <span id="dnn_ctr544_Scorecard_lblMyPercentile"><?=$TotPercent?></span>            </td>
            <td bgcolor="#FFFFFF" class="spacer12px borderright"></td>
            <td bgcolor="#FFFFFF" class="spacer12px"></td>
            <td bgcolor="#FFFFFF" class="width25">
                <strong>Correct Marks/Negative Marks</strong>            </td>
            <td bgcolor="#FFFFFF" class="textright width10"><?=$Corret*$Setearr['q_correct']?>
/ 	
  <?=$Wrong*$Setearr['q_incorrect']?></td>
        </tr>  
        <tr>
            <td height="50" bgcolor="#CCFFFF" class="width20">
                <strong>Total Time of Test</strong>            </td>
            <td bgcolor="#CCFFFF" class="textright width10">
                <span id="dnn_ctr544_Scorecard_lbltotalTime"><span class="contact-frm-name">
                <?=$Setearr['duration']?>
                </span> Min</span>            </td>
            <td bgcolor="#CCFFFF" class="spacer12px borderright"></td>
            <td bgcolor="#CCFFFF" class="spacer12px"></td>
            <td bgcolor="#CCFFFF" class="width15">&nbsp;</td>
            <td bgcolor="#CCFFFF" class="textright width10">&nbsp;</td>
            <td bgcolor="#CCFFFF" class="spacer12px borderright"></td>
            <td bgcolor="#CCFFFF" class="spacer12px"></td>
            <td bgcolor="#CCFFFF" class="width25">
                <strong>Left Question/Left Question Marks</strong>            </td>
            <td bgcolor="#CCFFFF" class="textright width10">
                <span id="dnn_ctr544_Scorecard_lblLeftQuestion"><?=$NotTest?> / <?=$NotTest*$Setearr['q_correct']?></span>            </td>
        </tr>  
        <tr>
            <td bgcolor="#FFFFFF" class="width20">&nbsp;</td>
            <td bgcolor="#FFFFFF" class="textright width10">&nbsp;</td>
            <td bgcolor="#FFFFFF" class="spacer12px borderright"></td>
            <td bgcolor="#FFFFFF" class="spacer12px"></td>
            <td bgcolor="#FFFFFF" class="width15">&nbsp;</td>
            <td bgcolor="#FFFFFF" class="textright width10">&nbsp;</td>
            <td bgcolor="#FFFFFF" class="spacer12px borderright"></td>
            <td bgcolor="#FFFFFF" class="spacer12px"></td>
            <td bgcolor="#FFFFFF" class="width25">
                <!--<strong>Unproductive Time/Idle Time</strong>-->            </td>
            <td bgcolor="#FFFFFF" class="textright width10">            </td>
        </tr>  
    </table></td>
    </tr>
 </table>

    
                
  