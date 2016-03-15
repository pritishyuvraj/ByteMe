<?php
error_reporting(0);
$a=0;
$b=0;
$c=0;
$encylopedia=array(array());
$self_friends=array();
$his_friends=array();
session_start();
$userid=$_SESSION["userid"];
if(!isset($_SESSION["friend_usn"])){
$_SESSION["friend_usn"]=$_GET["usn_view_profile"];
}
if(isset($_SESSION["friend_usn"]) && isset($_GET["usn_view_profile"])){
	if(strcasecmp($_SESSION["friend_usn"],$_GET["usn_view_profile"])){
	$_SESSION["friend_usn"]=$_GET["usn_view_profile"];
	}
}	
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
$friends_self=$userid."my_friends";
$my_friends=mysqli_query($con_central,"SELECT usn,friendship_status,foreign_entry FROM $friends_self");
while($row2=mysqli_fetch_row($my_friends)){
for($i=0;$i<3;$i++){
$self_friends[$b][$i]=$row2[$i];
}
$b++;
}
$friends_dost=$friend_usn."my_friends";
$dost_friends=mysqli_query($con_central,"SELECT usn,friendship_status,foreign_entry FROM $friends_dost");
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
if(!strcasecmp($friend_usn,$self_friends[$i][0])){
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
$_SESSION["back1"]=$encylopedia[$user_stored][7];
$_SESSION["back2"]=$encylopedia[$friend_stored][7];
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
<table border="1" align="center" style="background-color:black; width:100%; height:10%;">
<tr>
<td style="width:125%; background-color:#7070B8;" colspan="3"></td>
</tr></table>
<table border="1" align="center" style="background-color:white; width:80%; height:300%;">
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
echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
	<input type='hidden' name='action' value='backto'>
	<input type='submit' value=".$encylopedia[$user_stored][1].">
	</form>";
echo"<div style='width:100%; color:#2E2E8A;'>";
	echo"<div style='color:#2E2E8A;'><img style='border:2px solid black;box-shadow: 10px 1px 5px grey;'src=".$encylopedia[$friend_stored][6]." width='100%'></div>";
if($friendship_status==0){
	echo" ";
	}
	elseif($friendship_status==1){
	echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>";
	if($request_type==1){
	echo" ";
			}
	else{
	echo" ";
	}		
}

else{ echo"<div style='width: 100%;' class='navigator'><a class='navig_hover' href='photos_fr.php'><b><i>".$encylopedia[$friend_stored][1]."'s</i> Photos</b></a></div>
<div style='width: 100%;' class='navigator'><a class='navig_hover' href='fr_chat.php'><b>Message:<i>".$encylopedia[$friend_stored][1]; }
if(!strcasecmp($friend_active[0],$encylopedia[$friend_stored][0])){ echo"<img src='Website_Pictures/live.png' height='10' width='10'>"; }
echo "</i></b></a></div>
	<div><p style='font-size:125%; color:#2E2E8A;'><b>Name: <i></b>".$encylopedia[$friend_stored][1]."</i></p></div>
	<div><b>USN: </b><i>".$encylopedia[$friend_stored][0]."</i><br></div>
	<div><b>Email: </b><i>"; if($friendship_status!=1 && $friendship_status!=0){ echo $encylopedia[$friend_stored][2]; } else { echo "only for friends"; }
	echo "</i><br></div>
	<div><b>Mobile NO: </b><i>"; if($friendship_status!=1 && $friendship_status!=0){ echo $encylopedia[$friend_stored][4]; } else { echo "Only for friends"; }
	echo "</i><br></div>
	<div><b>Branch: </b><i>".$encylopedia[$friend_stored][3]."</i><br></div>
	<div><b>Single: </b><i>".$encylopedia[$friend_stored][5]."<i></b></div>";
echo"</div>";	
?>
<td style="width:50%; overflow-x:hidden;" valign="top">
<div style="overflow-x:hidden; height:95%; width:100%;">
<iframe src="wall_dost.php" style="width:100%; height:100%;">
</iframe>
</div>
</td>
<td style="width:30%"; valign="top">
<table border="0">
<?php
echo "<center><h1 style='color:#2E2E8A;'><i>".$encylopedia[$friend_stored][1]."'s friends</h1></center><hr>";
$g=0;
foreach($his_friends as $value){
for($i=0;$i<$a;$i++){
if(!strcasecmp($value[0],$encylopedia[$i][0])){
if($g==0){
echo"<tr>";
$g++;
}
echo"<td valign='top'><form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='get'>
	<img src=".$encylopedia[$i][7]."><br>".$encylopedia[$i][1]."<br>
	<input type='submit' value=".$encylopedia[$i][0]." name='usn_view_profile'></form>
</td>";
if($g%3==0){
echo"</tr><tr>";
$g=0;
}
}
}
}
echo"</tr>";
?>
</table>
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
<?php
$action=isset($_POST["action"])?$_POST["action"]:null;
switch($action){
case 'Add':{
$fr_usn=$_POST["send"];
$connecting=$fr_usn."my_friends";
$ins_fr_mine="INSERT INTO $connecting(usn,friendship_status,own_usn,foreign_entry) VALUES('$fr_usn',1,'$userid',0)";
if(!mysqli_query($con_central,$ins_fr_mine)){
echo"Could not sent a friend request because ".mysqli_error($con_central);
}
$getting_friends=$fr_usn."my_friends";
$ins_fr_other="INSERT INTO $getting_friends(usn,friendship_status,own_usn,foreign_entry) VALUES('$userid',1,'$fr_usn',1)";
if(!mysqli_query($con_central,$ins_fr_other)){
echo"Friend request didnt reach because ".mysqli_error($con_central);
}
else{
echo"Friend request sucessfully sent!";
}
header('Location:friends_my_profile.php');
break;
}
case 'Cancel':{
$fr_usn=$_POST["cancel"];
$del_fr_mine="DELETE FROM my_friends WHERE usn='$fr_usn'";
if(!mysqli_query($con_self,$del_fr_mine)){
echo"Could not delete friend request because".mysqli_error($con_self);
}
$con_friend=mysqli_connect("localhost","root","",$fr_usn);
$del_fr_other="DELETE FROM my_friends WHERE usn='$userid'";
if(!mysqli_query($con_friend,$del_fr_other)){
echo"Could not delete friend request from other".mysqli_error($con_friend);
}
else{
echo"Friend request sucessfully deleted!";
}
break;
}
case 'Remove':{
$remove=$_POST["remove"];
$con_friend=mysqli_connect("localhost","root","",$remove);
$remove_mine="DELETE FROM my_friends WHERE usn='$remove' AND friendship_status=2";
if(!mysqli_query($con_self,$remove_mine)){
echo"Could not unfriend yours".mysqli_error($con_self);
}
$remove_his="DELETE FROM my_friends WHERE usn='$userid' AND friendship_status=2";
if(!mysqli_query($con_friend,$remove_his)){
echo"Could not unfriend his".mysqli_query($con_friend);
}
break;
}
case 'Accept':{
$accept=$_POST["accept"];
$con_friend=mysqli_connect("localhost","root","",$accept);
$add_friend_other="UPDATE my_friends SET friendship_status=2 WHERE friendship_status=1 AND usn='$userid'";
if(!mysqli_query($con_friend,$add_friend_other)){
echo"Could not add to as your friend".mysqli_error($con_friend);
}
else{
$add_self_friend="UPDATE my_friends SET friendship_status=2 WHERE friendship_status=1 AND usn='$accept'";
if(!mysqli_query($con_self,$add_self_friend)){
echo"Could not add friend because:".mysqli_error($con_self);
}
else{
echo"Sucessfully added to your friend list";
$adding_notifi_self="INSERT INTO notification(type,from_usn,from_branch) VALUES(1,'$accept','$userid')";
if(!mysqli_query($con_self,$adding_notifi_self)){
echo"Could not notify because".mysqli_error($con_self);
}
$adding_noti_other="INSERT INTO notification(type,from_usn,from_branch) VALUES(1,'$userid','$accept')";
if(!mysqli_query($con_friend,$adding_noti_other)){
echo"Could not notify".mysqli_error($con_friend);
}
$own_wall="INSERT INTO self_comments(usn,foreign_usn,type) VALUES('$userid',3,'$accept')";
if(!mysqli_query($con_self,$own_wall)){
echo"could not write to your wall".mysqli_error($con_self);
}
$friend_wall="INSERT INTO self_comments(usn,foreign_usn,type) VALUES('$accept',3,'$userid')";
if(!mysqli_query($con_friend,$friend_wall)){
echo"could not write into friends wall".mysqli_error($con_friend);
}
$cre_fr_tb="CREATE TABLE $accept(usn CHAR(30),name CHAR(30),time CHAR(30),chat VARCHAR(1000),unfort_time CHAR(30),seen INT DEFAULT 0)";
if(!mysqli_query($con_self,$cre_fr_tb)){
echo"Could not create chat page".mysqli_error($con_self);
}
$cre_fr_my_tb="CREATE TABLE $userid(usn CHAR(30),name CHAR(30),time CHAR(30),chat VARCHAR(1000),unfort_time CHAR(30),seen INT DEFAULT 0)";
	if(!mysqli_query($con_friend,$cre_fr_my_tb)){
	echo"could not register chat tables".mysqli_error($con_friend);
	}	
$friends_other=msyqli_query($con_friend,"SELECT usn FROM my_friends WHERE friendship_status=2");
while($row5=mysqli_fetch_assoc($friends_other)){
$fr_others[]=$row5['usn'];
$e++;
}
foreach($friends_usn as $value){
$con_fr_mine=mysqli_connect("localhost","root","",$value);
$ins_mine="INSERT INTO self_comments(usn,foreign_usn,type) VALUES('$userid',3,'$value')";
if(!mysqli_query($con_fr_mine,$ins_mine)){
echo"Could not write into notification";
}
}
foreach($fr_others as $value){
$con_fr_other=mysqli_connect("localhost","root","",$value);
$ins_other="INSERT INTO self_comments(usn,foreign_usn,type) VALUES('$userid',3,'$value')";
if(!mysqli_query($con_fr_other,$ins_other)){
echo"Could not write to his friends notification".mysqli_error($con_fr_other);
}
}
}
}
break;
}
}
?>