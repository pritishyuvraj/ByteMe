<?php
error_reporting(0);
$mydate=getdate(date("U"));

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
?>



<html>
<head>
<link rel="stylesheet" type="text/css" href="daring_northies.css">
<title>Hello <?php print_r($name[0]); ?></title>
</head>
<body>
<table border="0" align="center">

<tr>
<td colspan="6"><h1 class="footer3">Check Photos</h1></td>
</tr>
<tr>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_profile.php">My Profile</a></td><br>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_friends.php">My Friends</a></td><br>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="contact_us.php">My Topics</a></td><br>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="photos.php">My Photos</a></td><br>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="discussion_topic.php">Trending Topics</a></td><br>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="chat.php">CHAT with buddies</a></td><br>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="logout.php">Logout<a></td><br>

</tr>
<tr><td colspan="7">
<div class="scrollable1" style="text-align:center;">
<?php
$con_self=mysqli_connect("localhost","root","",$userid);
$all_ph="SELECT photo_add,unique_no from photo_add_self ORDER BY unique_no DESC";
$all_photos=mysqli_query($con_self,$all_ph);
$photos=array(array());
$a=0;
while($row1=mysqli_fetch_row($all_photos))
{
for($i=0;$i<2;$i++)
{
$photos[$a][$i]=$row1[0];
}
$a++;
}
for($i=0;$i<$a;$i++)
{
echo"<img src=".$photos[$i][0]." width='100' 
height='150'><br>";
$photo_all_2=$photos[$i][0];
echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
<input type='Submit' value='Show Pic'>
<input type='hidden' value=".$photos[$i][0]." name='pic_disp'>
<input type='hidden' value=".$photos[$i][1]." name='uni_no'>
</form><br>";
}
?>
</div>
<div class="scrollable2" style="text-align:center;">
<?php
if(isset($_POST["pic_disp"]))
{
echo"
<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
<input type='hidden' value='Comment' name='commenting'>";
echo"<iframe src=".$_POST["pic_disp"]." width=100% height=100%><br>";
echo"</div>
<div class='scrollable3'>
<h1>Hello</h1>
</div>";
}
else
{
echo"Welcome to photos";
}
?>
</div>
<div class="scrollable3">
<?php
echo"<h1>UPLOAD your Pics:</h1>
<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'
enctype='multipart/form-data'>
<label for='file'>Filename:</label>
<input type='file' name='file' id='file'>
<input type='submit' value='view'>
</form>";

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
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists($userid."/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      $userid."/" .$_FILES["file"]["name"]);
      echo "Stored in: " . $userid."/" . $_FILES["file"]["name"];
      $to_upload=$userid."/".$_FILES["file"]["name"];
$ins_photo="INSERT INTO photo_add_self(photo_add,usn)
	VALUES('$to_upload','$userid')";
if(!mysqli_query($con_self,$ins_photo))
{
echo"Could not write sucessfully".mysqli_error($con_self);
}
$my_friends_usn="SELECT usn FROM my_friends";
$gen=mysqli_query($con_self,$my_friends_usn);
$usn_friends=array();
$za=0;
while($row9=mysqli_fetch_assoc($gen))
{
$usn_friends[]=$row9['usn'];
}
$fr_unique=mysqli_query($con_self,"SELECT unique_no FROM photo_add_self 
			ORDER BY unique_no LIMIT 0,1");
$writ_noti="INSERT INTO notification(type,from_usn,status)
	VALUES(5,'$userid',0)";

foreach($usn_friends as $value)
{
$con_others=mysqli_connect("localhost","root","",$value);
if(!mysqli_query($con_others,$writ_noti))
{
echo"Could not write notifications".mysqli_error($con_others);
}
while($row9=mysqli_fetch_assoc($fr_unique))
{
$abc=$row9["unique_no"];
$writ_wall="INSERT INTO self_comments(usn,unique_no,foreign_usn)
	VALUES('$userid','$abc',1)";
if(!mysqli_query($con_others,$writ_wall))
{
echo"could not write to others wall".mysqli_error($con_others);	
}
}
}
	}
    }
  }

else
  {
  echo "Invalid file";
  }

?>
</div>
</td></tr></table>
</html>