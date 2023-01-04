<?php include("includes/config.php"); ?>

<?php include("includes/database.php"); ?>

<html class="no-js" lang="en">

<head>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="style.css" rel="stylesheet" type="text/css" />

  <title>::Online Exam: Test Series</title>

  <link rel="stylesheet" href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />

</head>



<body>

  <?php

  $SubsIDs = explode("|", base64_decode($_REQUEST['SubjectIDs']));

  //print_r($SubsIDs);

  $_SESSION['StudId'] = $SubsIDs[1];



  $db->set_charset('utf8');

  $Selssql = "select * from test_series_tbl where id = '" . $SubsIDs[0] . "' ";

  $Selsres = $db->query($Selssql);

  $SelsNum = $Selsres->num_rows;





  $selgetmsql = "select * from member where id = '" . $_SESSION['StudId'] . "'";

  $selgetmres = $db->query($selgetmsql);

  $selgetmnum = $selgetmres->num_rows;

  if ($selgetmnum) {

    $selgetmarr = $selgetmres->fetch_assoc();
  } else {

    header("Location:https://surecertify.com/login");
  }

  ?>

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      padding: 0px;
      margin: 0px;
      font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
      font-size: 14px;
      font-weight: 400;
      color: #666;
      background: #f8f8f8;
      box-sizing: border-box;
    }

    .container {
      width: 100%;
      max-width: 1100px;
      margin: 0 auto;
    }

    .instruction_content {

      display: block;

      margin: 0 2rem 2rem;

      background: rgb(255, 247, 238);

      background: linear-gradient(33deg, rgba(255, 247, 238, 1) 18%, rgba(255, 255, 255, 1) 48%, rgba(240, 247, 251, 1) 100%);

      border-radius: 6px 6px 0 0;

      box-shadow: 0px 0px 14px 0px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      box-sizing: border-box;

    }

    .inst {
      width: 100%;
      border-collapse: collapse;
      box-sizing: border-box;
    }

    .inst tr td {
      padding: 12px;
      border: solid 1px #fff;
      border-collapse: collapse;
      background: #FFCB82;
      color: #333;
    }

    .llg img {
      max-width: 144px;
    }

    @media (max-width: 1199.98px) {
      .llg img {
        max-width: 140px;
      }
    }

    .headerbar {
      display: block;
      margin-bottom: 30px;
      box-sizing: border-box;
      padding: 1rem 2rem;
      /* box-shadow: rgb(99 99 99 / 20%) 0px 2px 8px 0px; */
      border-bottom: 1px solid #ddd;
    }

    .headerbox {
      width: 100%;
      max-width: 1100px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    a.abtn {
      display: inline-flex;
      padding: 0.6rem 1rem;
      text-align: center;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      border-radius: 55px;
      text-align: center;
      color: #fff;
      border: none;
      box-shadow: 0 3px 10px 0 rgb(243 101 35 / 30%);
      white-space: nowrap;
      background-color: #f36523;
    }

    a.tbtn {
      display: inline-flex;
      padding: 0.6rem 1rem;
      background: #f36523;
      box-shadow: 0 3px 10px 0 rgb(243 101 35 / 30%);
      color: #fff;
      text-align: center;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      border-radius: 55px;
      margin: 15px;
      transition: all 0.3s;
    }

    a.tbtn:hover {
      background: #CD6600;
    }

    .instruction_content_header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 15px;
      background: #F8F8E3;
    }

    .instruction_content_header h3 {
      color: #ffae00;
    }

    .instruction_content_detail {
      font-size: 16px;
      color: #47AA3E;
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .instruction_content_detail p span {
      font-size: 18;
      color: #FF7800;
    }

    .instruction_content_detail p span i {
      font-size: 14px;
      color: #59ecbc;
    }

    .insheight {
      padding: 1rem 2rem;
      background: #fff;
      margin: 1rem 2rem;
    }

    @media (max-width:768px) {

      .instruction_content {
        width: 92%;
      }

      .instruction_content_detail p {
        width: 100%;
        margin: 0px;
      }

    }
  </style>

  <header class="headerbar">

    <div class="headerbox">

      <div class="llg"><img src="images/logo.png" /></div>

      <div><a href="http://surecertify.com/exam-cancel" class="abtn">Cancel Exam</a></div>

    </div>

  </header>

  <div class="container">

    <div id="instruction" class="instruction_content" align="center">

      <?php

      if ($SelsNum) {

        $SelsrArr = $Selsres->fetch_assoc();





        if ($SelsrArr['paper_lang'] == 'H') {

          $Mtqutabl = "test_questions_hindi";

          $_SESSION['PLang'] = "H";
        } else if ($SelsrArr['paper_lang'] == 'E') {

          $Mtqutabl = "test_questions";

          $_SESSION['PLang'] = "E";
        } else if ($SelsrArr['paper_lang'] == 'H') {

          $Mtqutabl = "test_questions";

          $_SESSION['PLang'] = "E";
        }





        $_SESSION['q_ses'] = $_SESSION['StudId'] . "|" . base64_encode($selgetmarr['name']) . "|" . $SubsIDs[0];



        // $Innsql = "select * from member_exam_tbl where memid = '" . $_SESSION[ 'StudId' ] . "' and examid = '" . $SelsrArr[ 'tsid' ] . "' ";

        // $Innres = $db->query( $Innsql );

        // $Innnum = $Innres->num_rows;

        // if ( $Innnum ) {

        //   $Innarr = $Innres->fetch_assoc();

        //   $Tsids = base64_encode( $SelsrArr[ 'tsid' ] );

        //   if ( $Innarr[ 'status' ] == 1 ) {

        //     header( "Location:ShowTestResults.php?TsIDs=$Tsids&mdlev=" );

        //   } else {

        //     $delsql = "delete from quizmng_tbl where q_session = '" . $_SESSION[ 'q_ses' ] . "'";

        //     $delres = $db->query( $delsql );

        //     $delsql1 = "delete from member_exam_tbl where memid = '" . $_SESSION[ 'StudId' ] . "' and examid = '" . $SelsrArr[ 'tsid' ] . "' ";

        //     $delres1 = $db->query( $delsql1 );





        //   }

        // }





        $selquesssql = "select * from $Mtqutabl where tsid = '" . $SelsrArr['tsid'] . "'";

        $selquessres = $db->query($selquesssql);

        $selquessNum = $selquessres->num_rows;



      ?>

        <form id="frmstart" name="frmstart" method="post" action="">

          <div class="instruction_content_header">

            <h3><?php echo $SelsrArr['test_title']; ?></h3>

            <div>

              <input type="hidden" name="SubjectIDs" id="SubjectIDs" value="<?php echo $_REQUEST['SubjectIDs'] ?>" />

              <select name="paperLang" id="paperLang" class="frm-title-box" style="height: 32px; background: cornsilk; border: solid 2px #6666668f; padding: 4px;" onchange="frmstart.submit();">

                <?php if ($_SESSION['PLang'] == "H") { ?>

                  <option value="H" <?php if ($_SESSION['PLang'] == 'H') { ?> selected="selected" <?php } ?>>Hindi</option>

                <?php } else if ($_SESSION['PLang'] == "E") { ?>

                  <option value="E" <?php if ($_SESSION['PLang'] == 'E') { ?> selected="selected" <?php } ?>>English</option>

                <?php } else if ($_SESSION['PLang'] == "HE") { ?>

                  <option value="E" <?php if ($_SESSION['PLang'] == 'E') { ?> selected="selected" <?php } ?>>English</option>

                  <option value="H" <?php if ($_SESSION['PLang'] == 'H') { ?> selected="selected" <?php } ?>>Hindi</option>

                <?php } ?>

              </select>

            </div>

          </div>

          <div class="instruction_content_detail" style="flex:1; padding: 15px;">

            <p>Test Duration (Mins) : <span> <i class="fa fa-clock-o"></i> <?php echo $SelsrArr['duration']; ?></span></p>

            <p>Total Marks : <span> <i class="fa fa-edit"></i> <?php echo $SelsrArr['marks']; ?></span></p>

            <p>Total Question : <span> <i class="fa fa-question-circle"></i> <?php echo $selquessNum; ?></span></p>

            <p>Sections : <span> <i class="fa fa-th"></i> <?php echo $SelsNum; ?></span></p>

          </div>



        <?php } else { ?>

          <h1>Test is not updated yet! </h1>

          <p>Please wait till now!....</p>



        <?php } ?>

        </form>

    </div>



  </div>

  <div class="container">

    <div class="insheight">

      <h2>Instructions</h2>

      <?php if ($_SESSION['PLang'] == 'E') { ?>

        <div class="insenglish"><?php echo $SelsrArr['instruction_English'] ?></div>

        <p>&nbsp;</p>

      <?php } ?>

      <?php if ($_SESSION['PLang'] == 'H') { ?>

        <div class="inshindi"><?php echo $SelsrArr['instruction_Hindi']; ?></div> <?php } ?>

      <p>Read through the exam guidelines provided to you with the admit card. This is the foremost thing which a

        student should follow while going into the examination hall. Violating any instruction may lead to

        cancellation of your candidature.</p>

      <p>Take your time to read the question paper carefully from beginning to end before you start attempting the

        questions. By doing so, you can organize your thoughts and manage your time for each question to be

        answer. But don’t spend much time on this, manage your time accordingly. Say if you have three sections

        and three hours of exam then you must divide your time like 55 minutes for each section and 15 minutes

        for glancing at the entire paper.</p>

      <p>It is advisable to manage your time accordingly without panic. Schedule your time in such a way that you

        get some more time to go through the entire answer sheet again to avoid the possible mistakes. If you do

        not know the answer to a particular question, do not waste time by repeated thinking over it, rather

        move on to other questions. If you finish early, you can check these unanswered questions.</p>

      <p>Last but not the least, you must check all answers before submitting your answer sheet to the

        invigilator. You should keep last 15 minutes before the final bell to cross-check your answers. A

        thorough revision of every answer is necessary as it will help you to identify the errors and make the

        necessary corrections. There are also chances that you have left out a question or two by mistake. Your

        careless mistake can miss high marks and grades. Attempt that too and submit the paper.</p>

      <div class="agree" style="display: flex; align-items: center; justify-content: space-between;">

        <label style="flex:1"><input type="checkbox" /> I am agree with Instructions</label>

        <div class="instruction_content_foot">

          <a href="testexam.php?TsIDs=<?php echo base64_encode($SelsrArr['id']); ?>&QLang=<?php echo $_SESSION['PLang']; ?>" class="tbtn">

            <?php if ($_REQUEST['Type'] == 'Resume') { ?>

              Resume Test

            <?php } else { ?>

              Start Test

            <?php } ?>

          </a>

        </div>

      </div>

    </div>

  </div>

</body>

</html>