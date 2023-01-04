
              <div class="padding-15 margin-B-10">
                <h4>Exam Details</h4>
</div>
                
                <table width="100%" class="table table-striped table-bordered">
  <tr class="ahead">
    <td width="56%" nowrap="nowrap" bgcolor="#FFFFC1"><strong>Exams</strong></td>
    <td width="4%" nowrap="nowrap" bgcolor="#FFFFC1"><strong>Date</strong></td>
    <td width="3%" nowrap="nowrap" bgcolor="#FFFFC1"><strong>Mode</strong></td>
    <td width="4%" nowrap="nowrap" bgcolor="#FFFFC1"><strong>Max. Marks</strong></td>
    <td width="4%" nowrap="nowrap" bgcolor="#FFFFC1"><strong>Total Ques</strong></td>
    <td width="4%" nowrap="nowrap" bgcolor="#FFFFC1"><strong>Correct</strong></td>
    <td width="4%" nowrap="nowrap" bgcolor="#FFFFC1"><strong>In-Correct</strong></td>
    <td width="5%" nowrap="nowrap" bgcolor="#FFFFC1"><strong>Un-attempted</strong></td>
    <td width="5%" nowrap="nowrap" bgcolor="#FFFFC1"><strong>Obtained</strong></td>
    <td width="11%" nowrap="nowrap" bgcolor="#FFFFC1">&nbsp;</td>
  </tr>
	<?
							$Swwlpapsql = "select distinct q_session from quizmng_tbl where memid = '".$_SESSION['StudId']."'";
							$Swwlpapres = mysql_query($Swwlpapsql) or die(mysql_error());
							$SwwlpapNums = mysql_num_rows($Swwlpapres);
							if($SwwlpapNums){
							while($SwwlpapArr = mysql_fetch_array($Swwlpapres)){
							$Tsts = explode("|",$SwwlpapArr['q_session']);
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
			$Seloptq = "select * from quizmng_tbl where q_session = '".$SwwlpapArr['q_session']."' and memid = '".$_SESSION['StudId']."' and ques_id = '".$SnumquesArr['tqid']."'";
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
  <tr>
    <td><?=$Setearr['test_title']?></td>
    <td><?=date("d-m-Y", $SeloptA['upd_date'])?></td>
    <td>Online</td>
    <td><span class="contact-frm-name">
      <?=$Setearr['marks']?>
    </span></td>
    <td><?=$SnumquesNum?></td>
    <td><?=$Corret?></td>
    <td><?=$Wrong?></td>
    <td> <?=$NotTest?></td>
    <td><? echo $TotmarksGet; ?></td>
    <td>
    
    <a href="home.php?PageURL=ResultDetails&ExamID=<?=$SwwlpapArr['q_session']?>">View Report</a></td>
  </tr>
   
   <? } }else{ ?>
<tr>
    <td colspan="10" align="center" style="height:50px; text-align:center; color:#FF0000;">No sny exam given by you!</td>
    </tr>

<? } ?>
</table>

    
                
  