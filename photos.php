<?php
$time=time();
function test_input($data)
{
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
}

$mydate=getdate(date("U"));
error_reporting(0);
$day=$mydate[mday];
$month=$mydate[month];
$year=$mydate[year];
$hour=$mydate[hours];
$min=$mydate[minutes];
$sec=$mydate[seconds];

$final_da_ti=$day." ".$month." ".$year." ".$hour." ".
		$min." ".$sec;

$final_da=$day." ".$month." ".$year;

session_start();

$ip_address_add=$_SERVER["REMOTE_ADDR"];
$ip_address_port=$_SERVER["REMOTE_PORT"];
$userid=$_SESSION['userid'];
$foriegn=$userid;
?>
<html>
<head>
<link rel="shortcut icon" href="Website_Pictures/now.ico" >
<link rel="stylesheet" type="text/css" href="daring_northies.css">
<title>Hello <?php print_r($name[0]); ?></title>
</head>
<body style='background-color:#EBEBF5;'>
<table border="0" align="center" cellpadding="0" cellspacing="0" border="0" valign="top" style="background-color:white; height:100%; width:100%;">
<tr><td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_profile.php">My Profile</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_friends.php">My Friends</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="single.php"><b>Chat with Strangers</b></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="photos.php">My Photos</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="discussion_topic.php">Trending Topics</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="chat.php">CHAT with buddies</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="logout.php">Logout<a></td><br></tr>
<tr><td colspan="7" valign="top">
<div class="scrollable1" style="text-align:center; width:20%; height:100%;">
<?php
echo"
<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'
enctype='multipart/form-data'><p style='color:#2E2E8A; text-align:left; font-size:125%; background-color:#EBEBF5; border:1px;'>
<b><i>Add New Photo:</b></i>
<input type='file' name='file' id='file'><br>
<input type='text' placeholder='Photo Location' name='loc'><br>
<input type='text' placeholder='Photo Description' name='desc'><br>
<input type='submit' value='Upload Pic'></p>
</form><hr>";
$con_central=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$photo=$userid."photo_add_self";
$all_ph="SELECT thumbnails,unique_no,photo_add,location,caption from $photo ORDER BY unique_no DESC";
$all_photos=mysqli_query($con_central,$all_ph);
$photos=array(array());
$a=0;
while($row1=mysqli_fetch_row($all_photos))
{
for($i=0;$i<5;$i++)
{
$photos[$a][$i]=$row1[$i];
}
$a++;
}
for($i=0;$i<$a;$i++)
{
echo"<img src=".$photos[$i][0]." ><br>";
$photo_all_2=$photos[$i][0];
$description=$photos[$i][3];
$location1=$photos[$i][4];
echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
<input type='Submit' value='Show Pic'>
<input type='hidden' value=".$photos[$i][2]." name='pic_disp'>
<input type='hidden' value=".$photos[$i][1]." name='uni_no'>
<input type='hidden' value=".$photos[$i][3]." name='location_disp'>
<input type='hidden' value=".$photos[$i][4]." name='caption_disp'>
</form><br>";
}

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 4000000)
&& in_array($extension, $allowedExts))
  {
  $size = 200; // the thumbnail height

	$filedir =$userid.'/'; // the directory for the original image
	$thumbdir =$userid.'/'; // the directory for the thumbnail image
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
  
      echo "Stored in: ".$prod_img;
      echo "thumbnails at:".$prod_img_thumb."<br>";
	  $to_upload=$prod_img;
	$thumbnails=$prod_img_thumb;
$captian=test_input($_POST["desc"]);
$locate=test_input($_POST["loc"]);
$ins_photo="INSERT INTO $photo(photo_add,usn,thumbnails,location,caption) VALUES('$to_upload','$userid','$thumbnails','$locate','$captian')";
if(!mysqli_query($con_central,$ins_photo))
{
echo"Could not write sucessfully".mysqli_error($con_central);
}
$friends=$userid."my_friends";
$my_friends_usn="SELECT usn FROM $friends";
$gen=mysqli_query($con_central,$my_friends_usn);
$usn_friends=array();
$za=0;
while($row9=mysqli_fetch_assoc($gen))
{
$usn_friends[]=$row9['usn'];
}
$fr_unique=mysqli_query($con_central,"SELECT unique_no FROM $photo ORDER BY unique_no DESC LIMIT 0,1");
foreach($usn_friends as $value)
{
$writ_noti="INSERT INTO notification(type,from_usn,status,to_usn) VALUES(5,'$userid',0,'$value')";
if(!mysqli_query($con_central,$writ_noti))
{
echo"Could not write notifications".mysqli_error($con_central);
}
while($row9=mysqli_fetch_assoc($fr_unique))
	{
$abc=$row9["unique_no"];
$wall_people=$value."self_comments";
$writ_wall="INSERT INTO $wall_people(usn,unique_no,foreign_usn,type,time)
	VALUES('$userid','$abc',1,'$userid','$time')";
if(!mysqli_query($con_central,$writ_wall)){
echo"could not write to others wall".mysqli_error($con_central);	
		}
	}
}
		}
	}
else{
echo "Invalid image";
}
    
  

?>

</div>
<div class="scrollable2" style="background-color:black; text-align:center; width:60%; height:100%; scroll:fixed;">
<?php
echo"
<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
<input type='hidden' value='Comment' name='commenting'>
<img src=".$_POST["pic_disp"]." width=80%>";
echo"<h1 style='color:red';><b><i>".$_POST["location_disp"]."</b></h1>";
echo"<p style='color:#2E2E8A';>".$description."</i></p>";
?>
</div>
<div class="scrollable3" style="text-align:left; height:100%;">
<?php
$un=$_POST["uni_no"];
echo"
<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
<textarea rows='4' cols='25' name='com'>Enter your comments</textarea>
<input type='hidden' name='entry_no' value=".$un.">
<input type='Submit' name='comments' value='Comment'>
</form>";


$_SESSION["un1"]=$un;
echo $_SESSION["un1"];
$wall_self=$userid."self_comments";
$fr_photo=mysqli_query($con_central,"SELECT usn FROM  $wall_self WHERE foreign_usn=2 AND (unique_no='$un' AND type='$userid')");
$usn_ph=array();
$comm=array();
$comment1=array();
$e=0;
while($row8=mysqli_fetch_assoc($fr_photo))
{
$usn_ph[$e]=$row8['usn'];
echo"<br>".$row8['comment'];
$e++;
}
$fr_photo1=mysqli_query($con_central,"SELECT comment FROM $wall_self WHERE foreign_usn=2 AND (unique_no='$un' AND type='$userid')");
while($row9=mysqli_fetch_assoc($fr_photo1))
{
$comment1[]=$row9['comment'];
}
$d=0;
$pics=array(array());
for($i=0;$i<$e;$i++)
{
$value=$usn_ph[$i];
$gen_profile_pic=mysqli_query($con_central,"SELECT thumbnails,name,usn FROM registered_members WHERE registered_members.usn='$value'");
while($row10=mysqli_fetch_row($gen_profile_pic))
{
$pics[$d][0]=$row10[0];
$pics[$d][1]=$row10[1];
$pics[$d][2]=$row10[2];
}
$d++;
}

for($i=0;$i<$d;$i++)
{
echo"<div><div style='width:20%; height:10%; float:left;'><img style='border:2px solid black;box-shadow: 10px 1px 5px grey;' 
src=".$pics[$i][0]." align='middle'></div><div style='width:70%; float:left; height:10%;'>
	<form action='friends_my_profile.php' method='get'>
	<div style='height:5%; color:#2E2E8A;'><b><i>".$pics[$i][1].":<input type='submit' value=".$pics[$i][2]." name='usn_view_profile'>
	</b><br>".$comment1[$i]."</i></div></div></div></form>";
}
if(isset($_POST["comments"]))
{
	$comment=test_input($_POST["com"]);
	$un11=$_POST["entry_no"];
$write_his="INSERT INTO $wall_self(usn,unique_no,foreign_usn,comment,type)VALUES('$userid','$un11',2,'$comment','$userid')";
			if(!mysqli_query($con_central,$write_his))
{
echo"Could not mention on his comments".mysqli_error($con_central);
}
}
?>
</div></td></tr>
</table>
</body>
</html>
