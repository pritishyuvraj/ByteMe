<?php
error_reporting(0);
$time=time();
function test_input($data)
{
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
}
$a=0;
$b=0;
$c=0;
$d=0;
$e=0;
$stored_chat=array(array());
$my_friends_here=array();
$his_friends_here=array();
$encylopedia=array(array());
$comment=array(array());
session_start();
if(isset($_GET["friend_usn"])){
$_SESSION["friend_usn"]=$_GET["friend_usn"];
}
$friend=$_SESSION["friend_usn"];
$userid=$_SESSION["userid"];
if(!isset($_SESSION["address"]) && !isset($_SESSION["photo_no"])){
$_SESSION["address"]=$_GET["photo_addr"];
$_SESSION["photo_no"]=$_GET["photo_no"];
}
if(isset($_GET["photo_addr"])){
	$_SESSION["address"]=$_GET["photo_addr"];
	$_SESSION["photo_no"]=$_GET["photo_no"];
}
$to_disply=$_SESSION["address"];
$fr_comment=$_SESSION["photo_no"];
$con_central=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$details=mysqli_query($con_central,"SELECT registered_members.usn,registered_members.name,registered_members.thumbnails,photo_add 
		FROM registered_members");
while($row1=mysqli_fetch_row($details)){
for($i=0;$i<4;$i++){
$encylopedia[$a][$i]=$row1[$i];
}
if(!strcasecmp($encylopedia[$a][0],$userid)){
$user_det=$a;
}
if(!strcasecmp($encylopedia[$a][0],$friend)){
$friend_det=$a;
}
$a++;
}
$connecting_friends_wall=$friend."self_comments";
$comments=mysqli_query($con_central,"SELECT comment,usn FROM $connecting_friends_wall WHERE unique_no='$fr_comment'");
while($row2=mysqli_fetch_row($comments)){
for($i=0;$i<2;$i++){
$comment[$b][$i]=$row2[$i];
}
$b++;
}
$checking_friends=$userid."my_friends";
$my_friends=mysqli_query($con_central,"SELECT usn FROM $checking_friends WHERE friendship_status=2 AND (usn!='$userid' AND usn!='$friend')");
while($row4=mysqli_fetch_assoc($my_friends)){
$my_friends_here[]=$row4['usn'];
$d=0;
}
$his_friends=$friend."my_friends";
$his_friends=mysqli_query($con_central,"SELECT usn FROM $his_friends WHERE friendship_status=2 AND (usn!='$userid' AND usn!='$friend')");
while($row6=mysqli_fetch_assoc($his_friends)){
$his_friends_here[]=$row6['usn'];
$c=0;
}
$chatting=$friend."self_comments";
$view_chat=mysqli_query($con_central,"SELECT usn,comment FROM $chatting WHERE unique_no='$fr_comment' AND (foreign_usn=2 AND type='$friend') ORDER BY time DESC");
while($row7=mysqli_fetch_row($view_chat)){
for($i=0;$i<2;$i++){
$stored_chat[$e][$i]=$row7[$i];
}
$e++;
}
$_SESSION["back1"]=$encylopedia[$user_det][2];
$_SESSION["back2"]=$encylopedia[$friend_det][2];
if(!isset($_SESSION["count1"])){
$_SESSION["count1"]=1;
}
else{
$_SESSION["count"]+=1;
}
$disp_pic=array();
$disp_pic[0]=$_SESSION["back1"];
$disp_pic[1]=$_SESSION["back2"];
$rem=$_SESSION["count"]%2;
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="daring_northies.css">
</head>
<body style="background-color:white;" background="<?php echo $disp_pic[$rem]; ?>">
<table border="0" align="center" style="background-color:black; width:100%; height:10%;">
<tr>
<td style="width:125%; background-color:#7070B8;" colspan="3"></td>
</tr></table>
<table border="0" align="center" style="background-color:white; width:80%; height:200%;">
<tr>
<td style="width:20%"; valign="top">
<center><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<input type="hidden" name="action" value="backto">
	<input type="submit" value="<?php echo $encylopedia[$user_det][0]; ?>">
	</form><center>
<div><img src="<?php echo $encylopedia[$friend_det][3]; ?>" width=100%></div>
<div><p style="font-size:125%; color:#2E2E8A;"><b>Name:</b><i><?php echo $encylopedia[$friend_det][1]; ?></i></p></div><hr>	
</td>
<td style='text-align:center;' valign="top">
<div style='height:400; background-color:black;'>
<img src="<?php echo $to_disply; ?>" height=100%>
</div>
<?php
echo"<div>
	<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method=post>
	<textarea cols='60%' rows='5%' name='photo_comment'>Comment here.....</textarea>
	<input type='submit' value='comment' name='action'>
	</form>
	</div>";

echo"<div style='height:50%; width:100%;' class='scrollable2'>";
for($i=0;$i<$e;$i++){
for($j=0;$j<$a;$j++){
if(!strcasecmp($stored_chat[$i][0],$encylopedia[$j][0])){
$now=$j;
break;
}
}
echo"<form action='friends_my_profile.php' method='get'>
	<p style='color:#2E2E8A;'><div style='width:10% float:left; text-align:left;'><img src=".$encylopedia[$now][2]." ><b><i>
	<span style='font-size:150%; color:#2E2E8A;'>".$encylopedia[$now][1]."</span> :<input type='submit' value=".$encylopedia[$now][0]." name='usn_view_profile'>
	<br></b> ".$stored_chat[$i][1]."</i></p></div></center></form>";
}
echo"</div>";
?>
</td>
</table>
<?php
$action=isset($_POST["action"])?$_POST["action"]:NULL;
switch($action){
case 'comment':{
$what_comment=test_input($_POST["photo_comment"]);
$chatting1=$friend."self_comments";
$inserting_friend="INSERT INTO $chatting1(usn,unique_no,foreign_usn,comment,type,time) VALUES('$userid','$fr_comment',2,'$what_comment','$friend','$time')";
if(!mysqli_query($con_central,$inserting_friend)){
echo"could not write comments".mysqli_error($con_central);
}
$writing_notification="INSERT INTO notificatoin(type,from_usn,from_branch) VALUES(6,'$userid','$friend')";
if(!mysqli_query($con_central,$writing_notification));
foreach($his_friends_here as $values){
$chatting2=$values."self_comments";
$writing_wall="INSERT INTO $chatting2(usn,unique_no,foreign_usn,comment,time) VALUES('$userid','$fr_comment',2,'$what_comment','$friend','$time')";
if(!mysqli_query($con_central,$writing_wall));
}
foreach($my_friends_here as $value){
$chatting3=$value."self_comments";
$writing_wall_my="INSERT INTO $chatting3(usn,unique_no,foreign_usn,comment,time) VALUES('$userid','$fr_comment',2,'$what_comment','$friend','$time')";
if(!mysqli_query($con_central,$writing_wall_my)){
echo"";
}

header('Location:photo_friend.php');
}

break;
}
case 'backto':{
$_SESSION["friend_usn"]="0";
header('Location:my_profile.php');
break;
}

default: {
echo"";
break;
}
}
?>
