<html>
<title>Notification Bar</title>
<body style='background-color:#EBEBF5;'><center>
<h2 style='color:#2E2E8A;'><center>Notifications:</center></h2><hr>
<?php

$a1=0;
$a2=0;
session_start();
if(isset($_SESSION["userid"]))
{
$userid=$_SESSION["userid"];
}
$con_central=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$noti="SELECT from_usn,type FROM notification WHERE to_usn='$userid' ORDER BY serial_no DESC LIMIT 0,30";
$notification=mysqli_query($con_central,$noti);
$en_noti=array(array());
while($row1=mysqli_fetch_row($notification))
{
for($i=0;$i<2;$i++)
$en_noti[$a1][$i]=$row1[$i];
$a1++;
}
$photo_usn_1=array(array());
$ab=0;
for($i=0;$i<$a1;$i++)
{
$usn_pic=$en_noti[$i][0];
$photo="SELECT thumbnails,name FROM registered_members WHERE usn='$usn_pic'";
$ret_photo=mysqli_query($con_central,$photo);
while($row2=mysqli_fetch_row($ret_photo))
{
for($k=0;$k<2;$k++)
$photo_usn_1[$ab][$k]=$row2[$k];
$ab++;
}
}
for($i=0;$i<$a1;$i++)
{
if($en_noti[$i][1]==1)
{
$en_noti[$i][1]="is your friend now";
}
elseif($en_noti[$i][1]==2)
{
$en_noti[$i][1]="Sent you a message";
}
elseif($en_noti[$i][1]==3)
{
$en_noti[$i][1]="Rejected your friend request";
}
elseif($en_noti[$i][1]==4)
{
$en_noti[$i][1]="Posted on Discussion topic";
}
elseif($en_noti[$i][1]==5)
{
$en_noti[$i][1]="Uploaded a new pic";
}
}

echo"<table border='0' style='background-color:#EBEBF5;'>";
for($i=0;$i<$ab;$i++)
{
echo"<tr><td rowspan='3'><img style='border:2px solid black;box-shadow: 10px 1px 5px grey;'	src=".$photo_usn_1[$i][0]."></td></tr>
	<tr><td style='color:#2E2E8A; '><b>".$photo_usn_1[$i][1]."</b></td></tr>
	<tr><td><i>".$en_noti[$i][1]."</i></td>
	<td colspan='2'><hr></td></tr><tr><td colspan='2'><hr></td></tr>";
}
echo"</table>";
?>

</center>
</body>
</html>