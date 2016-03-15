<?php

$a=0;
$b=0;
$c=0;
$d=0;
$entire_photos=array(array());
$encylopedia=array(array());
$self_friends=array();
$his_friends=array();
session_start();
$userid=$_SESSION["userid"];
$friend_usn=$_SESSION["friend_usn"];
$con_central=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$friend_details=mysqli_query($con_central,"SELECT registered_members.usn,registered_members.name,registered_members.email,registered_members.branch,
registered_members.phone,registered_members.whatsapp,photo_add,registered_members.thumbnails FROM registered_members");
while($row1=mysqli_fetch_row($friend_details)){
for($i=0;$i<8;$i++){
$encylopedia[$a][$i]=$row1[$i];
}
if(!strcasecmp($encylopedia[$a][0],$userid)){
$user_stored=$a;
}
if(!strcasecmp($encylopedia[$a][0],$friend_usn)){
$friend_stored=$a;
}
$a++;
}
$my_friends1=$userid."my_friends";
$my_friends=mysqli_query($con_central,"SELECT usn,friendship_status,foreign_entry FROM $my_friends1");
while($row2=mysqli_fetch_row($my_friends)){
for($i=0;$i<3;$i++){
$self_friends[$b][$i]=$row2[$i];
}
$b++;
}
$dost_frie=$friend_usn."my_friends";
$dost_friends=mysqli_query($con_central,"SELECT usn,friendship_status,foreign_entry FROM $dost_frie");
while($row3=mysqli_fetch_row($dost_friends)){
for($i=0;$i<3;$i++){
$his_friends[$c][$i]=$row3[$i];
}
$c++;
}
if(isset($_GET["friendship_status"])){
$_SESSION["friendship_status"]=$_GET["friendship_status"];
$friendship_status=$_SESSION["friendship_status"];
$z=1;
}
elseif(isset($_POST["friendship_status"])){
$_SESSION["friendship_status"]=$_POST["friendship_status"];
$friendship_status=$_SESSION["friendship_status"];
$z=1;
}
else{
for($i=0;$i<$b;$i++){
if(!strcasecmp($friend_usn,$his_friends[$i][0])){
	$friendship_status=$his_friends[$i][1];
	if($friendship_status==1){
		$request_type=$his_friends[$i][2];
			}
		}
else{
	$friendship_status=0;
		}		
	}
}
$photo_dsp=$friend_usn."photo_add_self";
$show_photos=mysqli_query($con_central,"SELECT photo_add,unique_no,thumbnails FROM $photo_dsp ORDER BY unique_no DESC");
while($row5=mysqli_fetch_row($show_photos)){
for($i=0;$i<3;$i++){
$entire_photos[$d][$i]=$row5[$i];
}
$d++;
}
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="daring_northies.css">
</head>
<body style="background-color:white;">
<table border="1" align="center" style="background-color:black; width:100%; height:10%;">
<tr>
<td style="width:125%; background-color:#7070B8;" colspan="3"></td>
</tr></table>
<table border="1" align="center" style="background-color:white; width:80%; height:200%;">
<tr>
<td style="width:20%"; valign="top">
<?php 
$usn1=$encylopedia[$friend_stored][0];
$active=mysqli_query($con_central,"SELECT usn FROM active_user WHERE usn='usn1'");
$friend_active=array();
while($row4=mysqli_fetch_assoc($active)){
$friend_active[]=$row4['usn'];
}
$box_name=$encylopedia[$user_stored][1]."'s Profile";
echo"<center><form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post' style='color:#2E2E8A;' >
	<input type='hidden' name='action' value='backto'>
	<input type='submit' value=".$encylopedia[$user_stored][1]." >
	</form></center>";
echo"<div style='width:100%; color:#2E2E8A;'>";
	echo"<div style='color:#2E2E8A;'><img src=".$encylopedia[$friend_stored][6]." width=100%></div>
<div style='width: 100%;' class='navigator'><a class='navig_hover' href='photos_fr.php'><b><i>".$encylopedia[$friend_stored][1]."'s</i> Photos</b></a></div>
<div style='width: 100%;' class='navigator'><a class='navig_hover' href='photos_fr.php'><b>Message:<i>".$encylopedia[$friend_stored][1];
if(!strcasecmp($friend_active[0],$encylopedia[$friend_stored][0])){ echo"<img src='Website_Pictures/live.png' height='10' width='10'>"; }
echo "</i></b></a></div>
	<div><p style='font-size:125%; color:#2E2E8A;'><b>Name: <i></b>".$encylopedia[$friend_stored][1]."</i></p></div>
	<div><b>USN: </b><i>".$encylopedia[$friend_stored][0]."</i><br></div>
	<div><b>Email: </b><i>"; if($friendship_status==2){ echo $encylopedia[$friend_stored][2]; } else { echo "only for friends"; }
	echo "</i><br></div>
	<div><b>Mobile NO: </b><i>"; if($friendship_status==2){ echo $encylopedia[$friend_stored][4]; } else { echo "Only for friends"; }
	echo "</i><br></div>
	<div><b>Branch: </b><i>".$encylopedia[$friend_stored][3]."</i><br></div>
	<div><b>Single: </b><i>".$encylopedia[$friend_stored][5]."<i></b></div>";
echo"</div>";	
?>
<td style="width:50%;" valign="top">
<div style="width:100%;">
<table border="0"  cellpadding="0" cellspacing="0" border="0" valign="top" width=50%>
<tr>
<?php
for($i=1;$i<$d+1;$i++){
echo"<td valign='top' style='width:33%;'><form action='photo_friend.php' method='get'><img src=".$entire_photos[$i-1][2]."><br>
<input type='hidden' value=".$entire_photos[$i-1][0]." name='photo_addr'>
<input type='hidden' value=".$entire_photos[$i-1][1]." name='photo_no'>
<input type='submit' value='Show Pic'>
</form>
</td>";
if($i%3==0){
echo"</tr><tr>";
}
}
?>
</tr></table></div>
</td>
<td style="width:20%"; valign="top">
<iframe src="notification.php" width=100% height=99%>
</iframe>
</td>
</table>
</body>
</html>
<?php
$action=isset($_POST["action"])?$_POST["action"]:null;
switch($action){
case 'backto':{
$_SESSION["friend_usn"]="0";
header('Location:my_profile.php');
break;
}
default:{
echo"";
break;
}
}
?>