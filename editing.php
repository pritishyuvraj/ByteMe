<?php
function test_input($data)
{
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
}
$details=array(array());
session_start();
$userid=$_SESSION["userid"];
$con_central=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$writing=mysqli_query($con_central,"SELECT name,phone,whatsapp,roomno,thumbnails FROM registered_members WHERE usn='$userid'");
while($row1=mysqli_fetch_row($writing)){
for($i=0;$i<5;$i++){
$details[0][$i]=$row1[$i];
}
}

echo"<html>
	<body>
	<ul>
	<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post' enctype='multipart/form-data'>
	<li><input type='text' name='name' value=".$details[0][0].">(Name)</li>
	<li><input type='tel' name='phone' value=".$details[0][1].">(Phone No)</li>
	<li>Are you Single?<input type='radio' name='single' value=".$details[0][2]."></li>
	<li>Semester:<select name='room_no' value=".$details[0][3]." >
	<option value='1st'>1st</option>
	<option value='2nd'>2nd</option>
	<option value='3rd'>3rd</option>
	<option value='4th'>4th</option>
	<option value='5th'>5th</option>
	<option value='6th'>6th</option>
	<option value='7th'>7th</option>
	<option value='8th'>8th</option>
	</select></li>
	<li>Upload your Cute Profile Pic:</li>
	<input type='file' name='file' id='file'>";
echo"<input type='hidden' value='edit' name='action'><br>
	<input type='submit' name='submit'>";
$action=isset($_POST["action"])?$_POST["action"]:NULL;
switch($action){
case'edit':{
$name_new=test_input($_POST["name"]);
$tel_no=test_input($_POST["phone"]);
$single=test_input($_POST["single"]);
$sem=test_input($_POST["room_no"]);
//photo Upload Algorithm
$usn=$userid;
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 2000000)
&& in_array($extension, $allowedExts))
  {
  $size = 50; // the thumbnail height

	$filedir =$usn.'/'; // the directory for the original image
	$thumbdir =$usn.'/'; // the directory for the thumbnail image
	$prefix = 'thumbsup_'; // the prefix to be added to the original name

	$maxfile = '2000000';
	$mode = '0666';
	
	$userfile_name = $_FILES["file"]["name"];
	$userfile_tmp = $_FILES["file"]["tmp_name"];
	$userfile_size = $_FILES["file"]["size"];
	$userfile_type = $_FILES["file"]["type"];
	
	if (isset($_FILES["file"]["name"])) 
	{
		$prod_img = $filedir.$userfile_name;

		$prod_img_thumb = $thumbdir.$prefix.$userfile_name;
		move_uploaded_file($userfile_tmp, $prod_img);
		chmod ($prod_img, octdec($mode));
		
		$sizes = getimagesize($prod_img);

		$aspect_ratio = $sizes[1]/$sizes[0]; 

		if ($sizes[1] <= $size)
		{
			$new_width = $sizes[0];
			$new_height = $sizes[1];
		}else{
			$new_height = $size;
			$new_width = abs($new_height/$aspect_ratio);
		}

		$destimg=ImageCreateTrueColor($new_width,$new_height)
			or die('Problem In Creating image');
		$srcimg=ImageCreateFromJPEG($prod_img)
			or die('Problem In opening Source Image');
		if(function_exists('imagecopyresampled'))
		{
			imagecopyresampled($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg))
			or die('Problem In resizing');
		}else{
			Imagecopyresized($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg))
			or die('Problem In resizing');
		}
		ImageJPEG($destimg,$prod_img_thumb,90)
			or die('Problem In saving');
		imagedestroy($destimg);
  
       $profile_pic_location=$prod_img;
	$thumbnails=$prod_img_thumb;
	  }
	   }
  
else
  {
  echo "Invalid file";
  }
$writing="UPDATE registered_members SET name='$name_new',phone='$tel_no',whatsapp='$single',roomno='$sem',
		thumbnails='$thumbnails',photo_add='$profile_pic_location' WHERE usn='$userid'";
					
if(!mysqli_query($con_central,$writing)){
echo"Could not update".mysqli_error($con_central);
}
else{
echo"done";
}
$photo=$userid."photo_add_self";
$ins_photo="INSERT INTO $photo(photo_add,usn,thumbnails,caption) VALUES('$profile_pic_location','$userid','$thumbnails','Profile Pic')";
if(!mysqli_query($con_central,$ins_photo))
{
echo"Could not write sucessfully".mysqli_error($con_central);
}
header('Location:my_profile.php');
}
default:{
echo"";
}
}
?>
	