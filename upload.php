<?php
include('db.php');
session_start();
if($_POST['image_form_submit'] == 1)
{
	$images_arr = array();
	foreach($_FILES['images']['name'] as $key=>$val){
		$image_name = $_FILES['images']['name'][$key];
		$tmp_name 	= $_FILES['images']['tmp_name'][$key];
		$size 		= $_FILES['images']['size'][$key];
		$type 		= $_FILES['images']['type'][$key];
		$error 		= $_FILES['images']['error'][$key];
		
		############ Remove comments if you want to upload and stored images into the "uploads/" folder #############
		
		$target_dir = "uploads/";
		$target_file = $target_dir.$_REQUEST['SeriesID']."_".$_FILES['images']['name'][$key];
		if(move_uploaded_file($_FILES['images']['tmp_name'][$key],$target_file)){
			$images_arr[] = $target_file;
		
			if(preg_match_all('/\((.*?)\)/',$target_file,$match));
 			$imgidss = $match[1][0];
	$Selupdsql = "select * from test_questions where tsid = '".$_REQUEST['SeriesID']."' and tqimgid = '".$imgidss."'";
			$Selupdres = mysql_query($Selupdsql) or die("error1".mysql_error());
			$SelupdNum = mysql_num_rows($Selupdres);
			if($SelupdNum){
 			$Inssql = "update test_questions set questionimg_hindi = '".$target_file."', tqlevel = '".$_REQUEST['tqlevel']."' where tsid = '".$_REQUEST['SeriesID']."' and tqimgid = '".$imgidss."'";
			$InsRes = mysql_query($Inssql) or die("error2".mysql_error());
			}else{
 			$Inssql = "insert into test_questions set questionimg_hindi = '".$target_file."', tqlevel = '".$_REQUEST['tqlevel']."', tsid = '".$_REQUEST['SeriesID']."', tqimgid = '".$imgidss."'";
			$InsRes = mysql_query($Inssql) or die("error3".mysql_error());
			}

		}
		
		//display images without stored
//		$extra_info = getimagesize($_FILES['images']['tmp_name'][$key]);
//    	$images_arr[] = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($_FILES['images']['tmp_name'][$key]));
	}
	
	//Generate images view
	if(!empty($images_arr)){ $count=0;
	$Sns = 1;
		foreach($images_arr as $image_src){ $count++?>
			<ul class="reorder_ul reorder-photos-list">
            	<li id="image_li_<?php echo $count; ?>" class="ui-sortable-handle">
               
                	<a href="javascript:void(0);" style="float:none;" class="image_link"> <?=$Sns++?>:<br /> <img src="<?php echo $image_src; ?>" alt="" width="600"></a><br />
               	</li>
          	</ul>
	<?php }
	}
}
?>