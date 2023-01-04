<?php include("includes/config.php");?>
<?php include("includes/database.php");?>
<?php
###############################################
$TestIDds = base64_decode( $_REQUEST[ 'TsIDs' ] );
$Selssql = "select * from test_series_tbl where id = '" . $TestIDds . "'";
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
       // echo "=====================>".$SeloptNums."<br>";
        if ( $SeloptNums ==1) {
         //   echo "Come in single <br>";
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
        }else if ( $SeloptNums >1) {
          //  echo "Come in double <br>";
            $givencorrectAns = array();
            $originalcorrans = array();
            while($SeloptA = $Seloptr->fetch_assoc()){
                $givencorrectAns[] = $SeloptA['option_id'];
            }
            
             $SelcorAns = "select * from  $Tblnameanswer where tqid = '" . $SnumquesArr[ 'tqid' ] . "'";
                $SelcorRes = $db->query( $SelcorAns );
                while($SelcorArr = $SelcorRes->fetch_assoc()){
                  $originalcorrans[]= $SelcorArr['is_correct']; 
                }
            
            $GetEqualValue = array_equal($givencorrectAns, $originalcorrans);
            if($GetEqualValue==1){
                $TotCtMarks += $SelcorArr[ 'correct_marks' ];
                    $Corret = $Corret + 1;
            }else{
                $Wrong = $Wrong + 1;
                    $TotWrMarks += $SelcorArr[ 'wrong_marks' ];
            }
         //   echo $GetEqualValue;
        }else {
            $NotTest = $NotTest + 1;
        }
    }
    ############################################################

 
                $Totquestions = $NotTest+$Wrong+$Corret;
                $totctmarks = $Corret*2;
                $TotWrMarks = 0;
                $percentact = ($totctmarks/$TotMarks)*100;
               
                    $FnMarks = $TotCtMarks - $TotWrMarks;
                  
                 $Innsql = "update member_exam_tbl set totques = '".$Totquestions."', totcorrect = '".$Corret."', tot_in_correct = '".$Wrong."', tot_un_attempt = '".$NotTest."', tot_correct_marks = '".$totctmarks."', tot_incorrect_marks = '".$TotWrMarks."', tot_marks = '".$TotMarks."', precentage = '".$percentact."' where memid = '" . $_SESSION[ 'StudId' ] . "' and examsession = '" . $_SESSION[ 'q_ses' ] . "'";
                // echo $Innsql;
                $Innarr = $db->query($Innsql);
         header("Location:https://surecertify.com/view-result/".base64_encode($_SESSION[ 'q_ses' ]));        

?>