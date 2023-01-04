<?php
$filename = "gyan.jpg";

// Content type

// Get new dimensions
list($width, $height) = getimagesize($filename);

if($width>750){
$Gpresn = ($width-750)/$width;
$percent = 1-number_format($Gpresn,2);
}else{
 $percent = 1;
}

$new_width = $width * $percent;
 $new_height = $height * $percent;


// Resample
$image_p = imagecreatetruecolor($new_width, $new_height);
$image = imagecreatefromjpeg($filename);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
$WhiteCol = imagecolorallocate($image_p, 255, 255, 255);

imageline ($image_p, 0,0, 0, $new_height, $WhiteCol); 
imageline ($image_p, 1,0, 1, $new_height, $WhiteCol); 
imageline ($image_p, 2,0, 2, $new_height, $WhiteCol); 
imageline ($image_p, 3,0, 3, $new_height, $WhiteCol); 
 
imageline ($image_p, $new_width,0, $new_width, $new_height, $WhiteCol); 
imageline ($image_p, $new_width-1,0, $new_width-1, $new_height, $WhiteCol); 
imageline ($image_p, $new_width-2,0, $new_width-2, $new_height, $WhiteCol); 
imageline ($image_p, $new_width-3,0, $new_width-3, $new_height, $WhiteCol); 
imageline ($image_p, $new_width-4,0, $new_width-4, $new_height, $WhiteCol); 

imageline ($image_p, 0,0, $new_width, 0, $WhiteCol); 
imageline ($image_p, 0,1, $new_width, 1, $WhiteCol); 
imageline ($image_p, 0,2, $new_width, 2, $WhiteCol); 
imageline ($image_p, 0,3, $new_width, 3, $WhiteCol); 

imageline ($image_p, 0,$new_height, $new_width, $new_height, $WhiteCol); 
imageline ($image_p, 0,$new_height-1, $new_width, $new_height-1, $WhiteCol); 
imageline ($image_p, 0,$new_height-2, $new_width, $new_height-2, $WhiteCol); 
imageline ($image_p, 0,$new_height-3, $new_width, $new_height-3, $WhiteCol); 
 
header('Content-Type: image/jpeg');
 
// Output
imagejpeg($image_p, $filename, 100);
?>