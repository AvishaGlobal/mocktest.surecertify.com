<?php include("../../includes/config.php");?>
<?php include("../../includes/database.php");?>
<?php include("../../includes/common.php");?>
<?php include("../../includes/Otherfunction.php");?>
<?php
if ( $_REQUEST[ 'QLang' ] ) {
    $_SESSION[ 'PLang' ] = $_REQUEST[ 'QLang' ];
}
if ( ( $_SESSION[ 'q_ses' ] == '' ) && ( $_SESSION[ 'StudId' ] == '' ) ) {
    header( "Location:NotCorrectDet.php" );
}
if ( $_REQUEST[ 'Intime' ] ) {
    $Ginval = explode( "_", $_REQUEST[ 'Intime' ] );
    $OutTime = time();
    $Difftime = $OutTime - $Ginval[ 0 ];
    $Selttmsql = "select * from  quizmng_tbl where q_session = '" . $_SESSION[ 'q_ses' ] . "' and ques_id = '" . $Ginval[ 1 ] . "' and in_time = '" . $Ginval[ 0 ] . "'";
    $Selttmres = $db->query( $Selttmsql );
    $Selttmnum = $Selttmres->num_rows;
    if ( $Selttmnum == 0 ) {
        $Upppdsql = "update quizmng_tbl set in_time = '" . $Ginval[ 0 ] . "', out_time = '" . $OutTime . "', 	tot_time = '" . $Difftime . "' where q_session = '" . $_SESSION[ 'q_ses' ] . "' and ques_id = '" . $Ginval[ 1 ] . "'";
        $Upppdres = $db->query( $Upppdsql );

    }
}

$_SESSION[ 'Intime' ] = time();
//echo $_SESSION['Intime'];
$Tscredit = base64_decode( $_REQUEST[ 'mdlev' ] );
if ( $Tscredit == 1 ) {
    $Earncredit = 10;
    $paycredit = 0;
} else if ( $Tscredit == 2 ) {
    $Earncredit = 15;
    $paycredit = 0;
} else if ( $Tscredit == 3 ) {
    $Earncredit = 20;
    $paycredit = 30;
} else if ( $Tscredit == 4 ) {
    $Earncredit = 25;
    $paycredit = 35;

}
###############################################
$TestIDds = base64_decode( $_REQUEST[ 'TsIDs' ] );
$Selssql = "select * from test_series_tbl where tsid = '" . $TestIDds . "'";
$Selsres = $db->query( $Selssql );
$SelsNum = $Selsres->num_rows;
$SelsArrys = $Selsres->fetch_assoc();
$Timing = $SelsArrys[ 'duration' ] * 60;
$TotMarks = $SelsArrys[ 'marks' ];

$Seexamsql = "select * from member_exam_tbl where memid = '" . $_SESSION[ 'StudId' ] . "' and examid = '" . base64_decode( $_REQUEST[ 'TsIDs' ] ) . "'";
$Seexamres = $db->query( $Seexamsql );
$Seexamnum = $Seexamres->num_rows;
if ( $Seexamnum ) {
    $Seexamrarr = $Seexamres->fetch_assoc();
} else {
    $Innsql = "insert into member_exam_tbl set memid = '" . $_SESSION[ 'StudId' ] . "', examsession = '" . $_SESSION[ 'q_ses' ] . "', courseid = '" . $SelsArrys[ 'subject_title' ] . "', examid = '" . $SelsArrys[ 'tsid' ] . "', examdate = '" . time() . "', starttime = '" . time() . "'";
    $Innres = $db->query( $Innsql );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>::Online Exam: Test Series</title>
    <link href="css/teststyle.css" rel="stylesheet" type="text/css"/>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <script>
        var isNS = ( navigator.appName == "Netscape" ) ? 1 : 0;
        if ( navigator.appName == "Netscape" ) document.captureEvents( Event.MOUSEDOWN || Event.MOUSEUP );

        function mischandler() {
            return false;
        }

        function mousehandler( e ) {
            var myevent = ( isNS ) ? e : event;
            var eventbutton = ( isNS ) ? myevent.which : myevent.button;
            if ( ( eventbutton == 2 ) || ( eventbutton == 3 ) ) return false;
        }
        document.oncontextmenu = mischandler;
        document.onmousedown = mousehandler;
        document.onmouseup = mousehandler;
    </script>
    <style type="text/css">
        .answerclear {
            font-size: 12px;
            font-weight: bold;
            margin-top: 4px;
            margin-bottom: 4px;
            margin-left: 10px;
        }
        
        .clears {
            padding: 8px 20px;
            background: #3B5998;
            margin-top: 4px;
            border-radius: 4px;
            color: #FFF!important;
            display: inline-block!important;
            float: left;
            margin-right: 20px;
            margin-bottom: 8px;
        }
        
        .top-a {
            display: block;
            float: left;
            padding: 4px 20px;
            background: #3B5998;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            margin: 5px 10px;
            border-radius: 4px;
        }
        
        .qnpaper {
            width: 100%;
            /*overflow: auto;*/
            float: left;
            /*height: 450px!important;*/
        }
        
        .left-box {
            position: fixed;
            height: 1000px;
        }
    </style>

    <script language="javascript" type="text/javascript" src="jsaa4a2.js"></script>
    <script language="javascript" type="text/javascript" src="updateansseries.js"></script>
    <script language="javascript" type="text/javascript" src="ClearQues.js"></script>
    <script language="javascript" type="text/javascript" src="visitLater.js"></script>
</head>

<body onselectstart="return false;" style="">


    <form id="frmfinaltest" name="frmfinaltest" method="post" action="FinalTestResults.php?TsIDs=<?php echo $_REQUEST['TsIDs']?>&mdlev=<?php echo $_REQUEST['mdlev']?>">

        <div class="row">
            <div id="leftpanel" class="col-md-3">
                <div class="left-side">
                    <div class="logo-box">
                        <img src="images/logo.png"/>
                    </div>
                    <div id="javascript_countdown_time" class="timer"></div>
                    <div id="sideNav">
                        <table class="legentlist">
                            <tr class="trborder">
                                <td valign="middle"><span class="">&nbsp;</span>
                                </td>
                                <td valign="middle"><b>Legends</b>
                                </td>
                            </tr>
                            <tr class="trborder">
                                <td valign="middle"><span class="solved">&nbsp;</span>
                                </td>
                                <td>Attempted</td>
                            </tr>
                            <tr class="trborder">
                                <td valign="middle"><span class="marked">&nbsp;</span>
                                </td>
                                <td>Review Later</td>
                            </tr>
                            <tr>
                                <td valign="middle"><span class="unsolved">&nbsp;</span>
                                </td>
                                <td>Un-attempted</td>
                            </tr>
                        </table>
                    </div>

                    <div id="qnLinks">
                        <?php
                        $Snumquessql = "select * from test_questions where tsid = '" . base64_decode( $_REQUEST[ 'TsIDs' ] ) . "' order by quesorder";
                        $SnumquesRes = $db->query( $Snumquessql );
                        $SnumquesNum = $SnumquesRes->num_rows;
                        $QuesMArks = $TotMarks / $SnumquesNum;


                        $Msn = 1;
                        while ( $SnumquesArr = $SnumquesRes->fetch_assoc() ) {
                            $vsv = $Msn++;
                            $Seloptq = "select * from quizmng_tbl where q_session = '" . $_SESSION[ 'q_ses' ] . "' and memid = '" . $_SESSION[ 'StudId' ] . "' and ques_id = '" . $SnumquesArr[ 'tqid' ] . "'";
                            $Seloptr = $db->query( $Seloptq );
                            $SeloptNums = $Seloptr->num_rows;
                            if ( $SeloptNums ) {
                                $SeloptA = $Seloptr->fetch_assoc();
                                if ( $SeloptA[ 'visit_later' ] == 1 ) {
                                    $Clss = "ansVisitL";
                                } else {
                                    $Clss = "solving";
                                }
                            } else {
                                $Clss = "unsolved";
                            }
                            ?>
                        <div>
                            <a id='qn-<?php echo $vsv?>' class='<?php echo $Clss?>' onclick="location.href='testexam.php?TsIDs=<?php echo $_REQUEST['TsIDs']?>&Pageno=<?php echo $vsv?>&QLang=<?php echo $_REQUEST['QLang']?>'">
                                <?php echo $vsv?>
                            </a>
                        </div>
                        <?php } ?>

                    </div>
                    <input name="TsIDs" type="hidden" id="TsIDs" value="<?php echo $_REQUEST['TsIDs']?>"/>
                    <input name="mdlev" type="hidden" id="mdlev" value="<?php echo $_REQUEST['mdlev']?>"/>
                    <iframe src="updatetimer.php?stime=<?php echo $Timing?>&TestIDds=<?php echo $TestIDds?>&Testlev=<?php echo base64_decode($_REQUEST['mdlev'])?>" width="1" height="1" allowtransparency="yes" style="border:0px;"></iframe>


                </div>


            </div>



            <div id="rightpanel" class="col-md-9">
                <table width="100%" border="0" cellspacing="1" cellpadding="1">

                    <tr>
                        <td height="60" align="right" bgcolor="#6e91b9"></td>
                    </tr>
                    <tr>
                        <td height="25" align="right" bgcolor="#f2f2f2" style="border-bottom:1px solid #000000; color:666;">
                            <?php
                            $Selsubsslq = "select * from exam_subject where tsr_id = '" . $TestIDds . "' order by sbsid";
                            $Selsubsres = $db->query( $Selsubsslq );
                            while ( $Selsubsarr = $Selsubsres->fetch_assoc() ) {
                                ?>
                            <a href="testexam.php?TsIDs=<?php echo $_REQUEST['TsIDs']?>&Pageno=<?php echo $Selsubsarr['qfrom']?>" class="top-a" style="font-size:10px;">
                                <?php echo $Selsubsarr['subject_name']?>
                            </a>
                            <?php } ?>
                            <div style="float:right; padding-right:20px; padding-top:6px;">
                                <?php if($SelsArrys['paper_lang']=='HE'){ 
		if($_SESSION['PLang']=='E'){
		 		$CurUrl = str_replace("QLang=E","QLang=H","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

		}else{
		 		$CurUrl = str_replace("QLang=H","QLang=E","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		}
  		?>

                                <strong>Language :</strong> &nbsp;
                                <select name="paperLang" id="paperLang" class="frm-title-box" style="height:25px;" onchange="javascript:location.href='<?php echo $CurUrl?>'">
                                    <option value="E" <?php if($_SESSION[ 'PLang']=='E' ){ ?> selected="selected"
                                        <? } ?>>English</option>
                                    <option value="H" <?php if($_SESSION[ 'PLang']=='H' ){ ?> selected="selected"
                                        <? } ?>>Hindi</option>
                                </select>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="paper" id="paper">

                                <div id="qnpaper" class="qnpaper">

                                    <?php
                                    $Squstionsql = "select * from test_questions where tsid = '" . base64_decode( $_REQUEST[ 'TsIDs' ] ) . "' order by quesorder";
                                    $SqustionRes = $db->query( $Squstionsql );
                                    $SqustionNum = $SqustionRes->num_rows;
                                    if ( isset( $_REQUEST[ 'Pageno' ] ) ) {
                                        $Pageno = $_REQUEST[ 'Pageno' ];
                                        $pinsn = ( ( $_REQUEST[ 'Pageno' ] - 1 ) * 1 ) + 1;
                                    } else {
                                        $Pageno = 1;
                                        $pinsn = 1;
                                    }
                                    $limit = 1; //PAGE_LIMIT;
                                    $offset = ( $Pageno - 1 ) * $limit;
                                    $intCount = 1;
                                    $numPages = ceil( $SqustionNum / $limit );
                                    $Squstionsql = "select * from test_questions where tsid = '" . base64_decode( $_REQUEST[ 'TsIDs' ] ) . "' order by quesorder limit $offset,$limit";
                                    $SqustionRes = $db->query( $Squstionsql );

                                    $sns = $pinsn;
                                    while ( $SqustionArr = $SqustionRes->fetch_assoc() ) {

                                        $QuesValn = $_SESSION[ 'Intime' ] . "_" . $SqustionArr[ 'tqid' ];


                                        $selansssql = "select * from test_answer where tqid = '" . $SqustionArr[ 'tqid' ] . "'";
                                        $selanssrres = $db->query( $selansssql );
                                        $selanssrArr = $selanssrres->fetch_assoc();
                                        ##########################################################################
                                        $Seloptq = "select * from quizmng_tbl where q_session = '" . $_SESSION[ 'q_ses' ] . "' and memid = '" . $_SESSION[ 'StudId' ] . "' and ques_id = '" . $SqustionArr[ 'tqid' ] . "'";
                                        $Seloptr = $db->query( $Seloptq );
                                        $SeloptNums = $Seloptr->num_rows;
                                        if ( $SeloptNums ) {
                                            $SeloptA = $Seloptr->fetch_assoc();
                                            $Correctans = $SeloptA[ 'option_id' ];
                                            $Sechvstlet = $SeloptA[ 'visit_later' ];
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
                                        //print_r($SeloptA);
                                        #######################################################################
                                        ?>
                                    <a id='firstqn'></a>
                                    <div class='fullQ' id='q_1'>
                                        <div class='qHead'>
                                            <table style="margin-bottom:60px;">
                                                <tr>
                                                    <td colspan="2">
                                                        <div class='answer' style="font-size:12p; font-weight:bold; height:25px; padding:5px; width:99%;"> Question No.
                                                            <?php echo $sns++?> </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div id='q_txt_1' style="">
                                                            <div class='question'>
                                                                <p>

                                                                    <?php if($_SESSION['PLang']=='E'){ ?>
                                                                    <?php if(($SqustionArr['questionimg']!='') && (file_exists("../../manager/".$SqustionArr['questionimg']))){?>
                                                                    <img src="../../manager/<?php echo $SqustionArr['questionimg']?>" style="max-width:720px;"/>
                                                                    <?php }else{ ?>
                                                                    <p>
                                                                        <?php echo $SqustionArr['question']?>
                                                                    </p>


                                                                    <table width="100%" cellspacing="2" cellpadding="2" border="0">
                                                                        <tr style="height:30px;">
                                                                            <td width="5%"><strong>A</strong>
                                                                            </td>
                                                                            <td width="65%">
                                                                                <?php echo $SqustionArr['option1']?>
                                                                            </td>
                                                                            <td width="5%"><strong>B</strong>
                                                                            </td>
                                                                            <td width="25%">
                                                                                <?php echo $SqustionArr['option2']?>
                                                                            </td>
                                                                        </tr>

                                                                        <tr style="height:30px;">
                                                                            <td><strong>C</strong>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $SqustionArr['option3']?>
                                                                            </td>
                                                                            <td><strong>D</strong>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $SqustionArr['option4']?>
                                                                            </td>
                                                                        </tr>
                                                                    </table>

                                                                    <?php } ?>
                                                                    <?php }else{ ?>
                                                                    <?php if(($SqustionArr['questionimg']!='') && (file_exists("../../manager/".$SqustionArr['questionimg_hindi']))){?>
                                                                    <img src="../../manager/<?php echo $SqustionArr['questionimg_hindi']?>" style="max-width:720px;  "/>
                                                                    <?php }else{ ?>
                                                                    <p>
                                                                        <?php echo $SqustionArr['question']?>
                                                                    </p>
                                                                    <table width="100%" cellspacing="2" cellpadding="2" border="0">
                                                                        <tr style="height:30px;">
                                                                            <td width="5%"><strong>A</strong>
                                                                            </td>
                                                                            <td width="65%">
                                                                                <?php echo $SqustionArr['option1']?>
                                                                            </td>
                                                                            <td width="5%"><strong>B</strong>
                                                                            </td>
                                                                            <td width="25%">
                                                                                <?php echo $SqustionArr['option2']?>
                                                                            </td>
                                                                        </tr>

                                                                        <tr style="height:30px;">
                                                                            <td><strong>C</strong>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $SqustionArr['option3']?>
                                                                            </td>
                                                                            <td><strong>D</strong>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $SqustionArr['option4']?>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <?php } ?>
                                                                    <?php } ?>
                                                                </p>
                                                            </div>
                                                            <div class='tdanswer'>
                                                                <div class='optionss'> <strong>Answer:</strong> <br/>
                                                                    <div style="padding-left:50px;">
                                                                        <?php
                                                                        //$Smqulnasql = "select * from ";
                                                                        $Chars = 64;
                                                                        for ( $i = 1; $i <= $selanssrArr[ 'answer' ]; $i++ ) {
                                                                            ?>
                                                                        <input type="text" name="gotid_<?php echo $sns?>" id="gotid_<?php echo $sns?>" style="width:1px; height:1px;"/> <input type='radio' onclick='updateAnswer(<?php echo $sns-1?>, <?php echo $i?>, this.value, <?php echo $SqustionArr[' tqid ']?>)' id='ans-<?php echo $sns-1?>-<?php echo $i?>' name='ans-<?php echo $sns-1?>' align='left' value='<?php echo $i?>' <? if($Correctans==$i){?> checked="checked"
                                                                        <? } ?>>
                                                                        <span class="ab">
                                                                            <?php echo chr($Chars+$i)?>
                                                                        </span>
                                                                        <br/>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class='q_rt'>
                                                        <div class='marks'>
                                                            <?php echo number_format($QuesMArks,1)?> Mark/s</div>
                                                        <div class='paraview'></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='q_txt' colspan="2">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class='answer'>
                                            <div id='answer-area' style="width:99%;">

                                                <div class=''>
                                                    <div class='answerclear'>
                                                        <a href='javascript:void()' onclick='clearData(<?php echo $sns-1?>, <?php echo $SqustionArr[' tqid ']?>); return false;' class='clears' style='display:<?php echo $Visiable?>' id='clear-<?php echo $sns-1?>'>Clear</a>
                                                        <a href="javascript:void(0)" class='clears' onclick="visitLater(<?php echo $sns-1?>, <?php echo $SqustionArr['tqid']?>, 1)">Mark For Review </a>

                                                        <?php
                                                        if ( $numPages == $Pageno ) {
                                                            $next1_Pageno = $numPages;
                                                            ?>
                                                        <a href="javascript:void(0)" onclick="ShowExam();" class='clears'>Save & Next</a>
                                                        <?php
                                                        } else {
                                                            $next1_Pageno = $Pageno + 1;
                                                            ?>
                                                        <a href="javascript:void(0)" class='clears' onclick="ChangeSteps('<?php echo $_REQUEST['TsIDs']?>', '<?php echo $_REQUEST['QLang']?>', '<?php echo $next1_Pageno?>', '<?php echo $QuesValn?>')">Save & Next</a>
                                                        <!-- <a href="testexam.php?TsIDs=<?php echo $_REQUEST['TsIDs']?>&QLang=<?php echo $_REQUEST['QLang']?>&Pageno=<?php echo $next1_Pageno?>" class='clears' onclick="ChangeSteps(<?php echo $_REQUEST['TsIDs']?>, <?php echo $_REQUEST['QLang']?>, <?php echo $next1_Pageno?>, <?php echo $_SESSION['Intime']; ?>, <?php echo time(); ?>)">-->
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                                <div class='tdvisitL'>
                                                    <div id='vl_<?php echo $sns-1; ?>' class='visitLaters'><input onclick='visitLater(<?php echo $sns-1; ?>, <?php echo $SqustionArr[' tqid ']; ?>, this.id)' type='hidden' name='later' value='Mark' id='visitLater_<?php echo $sns-1; ?>'> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

            </div>





    </form>
</body>
</html>
<?php
$Sfessql = "select sum(tot_time) as timeconsume from quizmng_tbl where memid = '" . $_SESSION[ 'StudId' ] . "' and q_session = '" . $_SESSION[ 'q_ses' ] . "'";
$SfesRes = $db->query( $Sfessql );
$Sfesnums = $SfesRes->num_rows;
if ( $Sfesnums ) {
    $SfesArras = $SfesRes->fetch_assoc();
    $Timing = $Timing - $SfesArras[ 'timeconsume' ];
}
?>
<script language="javascript">
    var javascript_countdown = function () {
        var time_left = 10; //number of seconds for countdown
        var output_element_id = 'javascript_countdown_time';
        var keep_counting = 1;
        var no_time_left_message = 'No time left!';

        function countdown() {
            if ( time_left < 2 ) {
                keep_counting = 0;
                alert( 'Your Time is Over' );
                document.frmfinaltest.submit();
            }

            time_left = time_left - 1;
        }

        function add_leading_zero( n ) {
            if ( n.toString().length < 2 ) {
                return '0' + n;
            } else {
                return n;
            }
        }

        function format_output() {
            var hours, minutes, seconds;
            seconds = time_left % 60;
            minutes = Math.floor( time_left / 60 ) % 60;
            hours = Math.floor( time_left / 3600 );

            seconds = add_leading_zero( seconds );
            minutes = add_leading_zero( minutes );
            hours = add_leading_zero( hours );

            return hours + ':' + minutes + ':' + seconds;
        }

        function show_time_left() {
            document.getElementById( output_element_id ).innerHTML = format_output(); //time_left;
        }

        function no_time_left() {
            document.getElementById( output_element_id ).innerHTML = no_time_left_message;
        }

        return {
            count: function () {
                countdown();
                show_time_left();
            },
            timer: function () {
                javascript_countdown.count();

                if ( keep_counting ) {
                    setTimeout( "javascript_countdown.timer();", 1000 );
                } else {
                    no_time_left();
                }
            },
            //Kristian Messer requested recalculation of time that is left
            setTimeLeft: function ( t ) {
                time_left = t;
                if ( keep_counting == 0 ) {
                    javascript_countdown.timer();
                }
            },
            init: function ( t, element_id ) {
                time_left = t;
                output_element_id = element_id;
                javascript_countdown.timer();
            }
        };
    }();

    //time to countdown in seconds, and element ID
    javascript_countdown.init( <?php echo $Timing?>, 'javascript_countdown_time' );
</script>
<script language="javascript">
    function ShowExam() {
        if ( confirm( 'Are you sure' ) ) {
            document.frmfinaltest.submit();
        }

    }
    /////////////////////////////////////////////////////////
    function ChangeSteps( TsIDs, QLang, Next1_Pageno, Intime ) {
        // alert(Intime);
        location.href = 'testexam.php?TsIDs=' + TsIDs + '&QLang=' + QLang + '&Pageno=' + Next1_Pageno + '&Intime=' + Intime;

    }
</script>
<script>
    <!--
    //edit this message to say what you want
    var message = "Function Disabled";

    function clickIE() {
        if ( document.all ) {
            alert( message );
            return false;
        }
    }

    function clickNS( e ) {
        if ( document.layers || ( document.getElementById && !document.all ) ) {
            if ( e.which == 2 || e.which == 3 ) {
                // alert(message);
                return false;
            }
        }
    }
    if ( document.layers ) {
        document.captureEvents( Event.MOUSEDOWN );
        document.onmousedown = clickNS;
    } else {
        document.onmouseup = clickNS;
        document.oncontextmenu = clickIE;
    }

    document.oncontextmenu = new Function( "return false" )
        // -->
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
    document.onkeydown = function ( e ) {
        if ( e.ctrlKey &&
            ( e.keyCode === 67 ||
                e.keyCode === 86 ||
                e.keyCode === 85 ||
                e.keyCode === 117 ) ) {
            return false;
        } else {
            return true;
        }
    };
    $( document ).keypress( "u", function ( e ) {
        if ( e.ctrlKey ) {
            return false;
        } else {
            return true;
        }
    } );

    ///////////////////////////////////////////////
</script>
<script>
    if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test( navigator.userAgent ) ) {

        //window.location = "http://demo.eduim.co.in/students/index.php";
    }
</script>