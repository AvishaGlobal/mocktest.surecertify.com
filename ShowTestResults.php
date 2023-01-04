<?php include("includes/config.php");?>
<?php include("includes/database.php");?>
<?php
###############################################
$TestIDds = base64_decode( $_REQUEST[ 'TsIDs' ] );
$Selssql = "select * from test_series_tbl where tsid = '" . $TestIDds . "'";
$Selsres = $db->query( $Selssql );
$SelsNum = $Selsres->num_rows;
$SelsArrys = $Selsres->fetch_assoc();
$Timing = $SelsArrys[ 'duration' ] * 60;
$TotMarks = $SelsArrys[ 'marks' ];
if($SelsArrys['paper_lang']){
$_SESSION['PLang'] = $SelsArrys['paper_lang'];
}else{
$_SESSION['PLang'] = "E";
}


if($_SESSION['PLang']=='E'){
							$Tblname = "test_questions";
							$Tblnameanswer = "test_answer";
						}else if($_SESSION['PLang']=='H'){
							$Tblname = "test_questions_hindi";
							$Tblnameanswer = "test_answer_hindi";
						}
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>::Online Exam: Test Series</title>
    <link href="css/teststyle.css" rel="stylesheet" type="text/css"/>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>



    <script>
//        var isNS = ( navigator.appName == "Netscape" ) ? 1 : 0;
//        if ( navigator.appName == "Netscape" ) document.captureEvents( Event.MOUSEDOWN || Event.MOUSEUP );
//
//        function mischandler() {
//            return false;
//        }
//
//        function mousehandler( e ) {
//            var myevent = ( isNS ) ? e : event;
//            var eventbutton = ( isNS ) ? myevent.which : myevent.button;
//            if ( ( eventbutton == 2 ) || ( eventbutton == 3 ) ) return false;
//        }
//        document.oncontextmenu = mischandler;
//        document.onmousedown = mousehandler;
//        document.onmouseup = mousehandler;
    </script>
    <script language="javascript" type="text/javascript" src="jsaa4a2.js"></script>
    <?php
    $Snumquessql = "select * from $Tblname where tsid = '" . base64_decode( $_REQUEST[ 'TsIDs' ] ) . "'  order by quesorder";
     $SnumquesRes = $db->query( $Snumquessql );
    $SnumquesNum = $SnumquesRes->num_rows;
    $QuesMArks = $TotMarks / $SnumquesNum;
    $Msn = 1;
    $Corret = 0;
    $Wrong = 0;
    $NotTest = 0;
    while ( $SnumquesArr = $SnumquesRes->fetch_assoc() ) {
        $vsv = $Msn++;
        $Seloptq = "select * from quizmng_tbl where q_session = '" . $_SESSION[ 'q_ses' ] . "' and memid = '" . $_SESSION[ 'StudId' ] . "' and ques_id = '" . $SnumquesArr[ 'tqid' ] . "'";
        $Seloptr = $db->query( $Seloptq );
        $SeloptNums = $Seloptr->num_rows;
        if ( $SeloptNums ) {
            $SeloptA = $Seloptr->fetch_assoc();
            if ( $SeloptA[ 'visit_later' ] != 1 ) {
                ############################################################
                $SelcorAns = "select * from  $Tblnameanswer where tqid = '" . $SnumquesArr[ 'tqid' ] . "'";
                $SelcorRes = $db->query( $SelcorAns );
                $SelcorArr = $SelcorRes->fetch_assoc();
                $crtAns = $SelcorArr[ 'is_correct' ];
                if ( $SeloptA[ 'option_id' ] == $crtAns ) {
                    $TotCtMarks += $SelcorArr[ 'correct_marks' ];
                    $Corret = $Corret + 1;
                } else {
                    $Wrong = $Wrong + 1;
                    $TotWrMarks += $SelcorArr[ 'wrong_marks' ];
                }
            } else {
                $NotTest = $NotTest + 1;
            }
            ############################################################
        } else {
            $NotTest = $NotTest + 1;
        }
    }
    ############################################################

    ?>
</head>

<body onselectstart="return false;" style="-moz-user-select: none;">
    <div class="row">
        <div class="col-md-3 ddata">
            
            <div class="maiinleft">

                <div class="logo-ad"><h4 style="color:#fff;margin: 0;padding: 14px 15px;font-size: 22px;"><font>My</font> <span>Certification</span></h4></div>
                <div id="left1">
                    <p class="hd"><strong>Result</strong></p>
                    <p><?=$Corret?> <span>Correct Ans</span></p>
                     <p><?=$Wrong?> <span>Incorrect Ans</span></p>
                    <p><?=$NotTest?> <span>Un-attempted</span></p>
                     <p><? echo $NotTest+$Wrong+$Corret ?> <span>Total Question</span></p>
                </div>

                <div id="left2">
                    <?
                    $FnMarks = $TotCtMarks - $TotWrMarks;
                    ?>
                    <p class="hd"><strong>Marks Details</strong></p>
                    <p><?=$TotCtMarks?> <span>Correct Marks</span></p>
                    <p><?=$TotWrMarks?> <span>Incorrect Marks</span></p>
                    <p><? echo $FnMarks; ?> / <?=$TotMarks?>
                </div>


                <div id="left3">
                    <p class="hd"><strong>Legends</strong></p>
                    <p>Attempted <span class="solved">&nbsp;</span></p>
                    <p>Visit Later <span class="marked">&nbsp;</span></p>
                    <p>Un-attempted <span class="unsolved">&nbsp;</span></p>
                    
                </div>

            </div>
            <img src="bt.png" class="bt">
        </div>


        <div class="col-md-9 pr-0">
            <div class="right-box">
                <div class="logo-ad shoxs"><img src="images/logo.png" height="40"/></div>
                <h4 class="hiddenxs"><a href="../index.php?PageURL=mocktest" style="background-color:#FFF; color:#000;">My Account</a></h4>
                <div id="qnpaper" class="qnpaper">
                    <?php
                    $Squstionsql = "select * from $Tblname where tsid = '" . base64_decode( $_REQUEST[ 'TsIDs' ] ) . "' order by quesorder";
                    $SqustionRes = $db->query( $Squstionsql );
                    $sns = 1;
                    while ( $SqustionArr = $SqustionRes->fetch_assoc() ) {
                        $selansssql = "select * from $Tblnameanswer where tqid = '" . $SqustionArr[ 'tqid' ] . "'";
                        $selanssrres = $db->query( $selansssql );
                        $selanssrArr = $selanssrres->fetch_assoc();
                        ##########################################################################
                        $Seloptq = "select * from quizmng_tbl where q_session = '" . $_SESSION[ 'q_ses' ] . "' and memid = '" . $_SESSION[ 'StudId' ] . "' and ques_id = '" . $SqustionArr[ 'tqid' ] . "'";
                        $Seloptr = $db->query( $Seloptq );
                        $SeloptNums = $Seloptr->num_rows;
                        if ( $SeloptNums ) {
                            $SeloptA = $Seloptr->fetch_assoc();
                            if ( $SeloptA[ 'visit_later' ] == 1 ) {
                                $Clss = "ansVisitL";
                                $Visiable = "none";
                            } else {
                                $Clss = "solving";
                                $Visiable = "block";
                            }
                        } else {
                            $Clss = "unsolved";
                            $Visiable = "none";
                        }
                        #######################################################################
                        ?>
                        <div class="ans-box">
                  <div class='<?=$Clss?>'> <?=$sns++ ?></div>
       				<div class='question'>
                                    <?php if($SqustionArr['qstype']=='text'){?>
                                    <p>
                                        <?=$SqustionArr['question']?>
                                    </p>
                                    <?php }else{ ?>
                                    <img src="admin/<?=$SqustionArr['questionimg']?>" style="max-width:680px;"/>
                                    <?php } ?>
                                </div>
       							<div class='marks'>
                                <?=number_format($QuesMArks,2)?>Mark/s</div>
                                <div class='optionss'> Answer:
                                        <? 
		$Chars = 64;
		for($i=1;$i<=$selanssrArr['answer'];$i++){?>
                                        <input type='radio' id='ans-<?=$sns-1?>-<?=$i?>' name='ans-<?=$sns-1?>' align='left' value='<?=$i?>' <? if($SeloptA[ 'option_id']==$i){?> checked="checked"
                                        <? } ?>disabled="disabled">
                                        <?=chr($Chars+$i)?>
                                        <? } ?>
                                        &nbsp;</div>
                                <div class='tdvisitL'>
                                    <div id='vl_<?=$sns-1?>' class='visitLaters'><input type='checkbox' name='later' value='Mark' id='visitLater_<?=$sns-1?>' <? if($SeloptA[ 'visit_later']==1){?> checked="checked" style="color:#000099;"
                                        <? } ?>disabled="disabled"><label for='visitLater_1'>Visit Later</label>
                                    </div>
                                </div>
                            <?php
		$SelcorAns = "select * from  $Tblnameanswer where tqid = '".$SqustionArr['tqid']."'";
		$SelcorRes = $db->query($SelcorAns);
		$SelcorArr = $SelcorRes->fetch_assoc();
		$crtAns = $SelcorArr['is_correct'];
		?>
                            <div class='answer-box' style="color:#0000FF; font-weight:bold;">Correct Answer :
                                <?=chr($Chars+$crtAns)?><br/>
                                <? if($SelcorArr['ansdetails']){?>
                                <div align="justify"  style="color:#666; font-weight:normal;">
                                    <?=$SelcorArr['ansdetails']?>
                               
                                </div>
                                <? } ?>         
                                 </div>
       						</div>
       
                            <? }?>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $(".bt").click(function(){
    $(".ddata").toggleClass("sho");
  });
});
</script>
</html>