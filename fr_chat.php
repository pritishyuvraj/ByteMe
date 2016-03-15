<?php
$no_of_seconds=4;
error_reporting(0);
$chatted=array(array());
$encylopedia=array(array());
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
$real_time=time();
$a=0;
$b=0;
session_start();

if(!isset($_SESSION["count"])){
$_SESSION["count"]=0;
$live_time=array(array());
$did_it=array(array());
}
else{
$did_it=$_SESSION["live"];
$times=$_SESSION["count"];
$_SESSION["count"]=$_SESSION["count"]+1;
}
$d1=$_SESSION["count"];
$live_time[$d1][0]=time();
$_SESSION["live"]=$live_time;
$final=$did_it[$times][0];

$userid=$_SESSION["userid"];
$friend=$_SESSION["friend_usn"];
$con_central=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$disp=mysqli_query($con_central,"SELECT registered_members.usn,registered_members.name,thumbnails,photo_add FROM registered_members WHERE 
		registered_members.usn='$userid' OR registered_members.usn='$friend'");
while($row3=mysqli_fetch_row($disp)){
for($i=0;$i<4;$i++){
$encylopedia[$b][$i]=$row3[$i];
}
if(!strcasecmp($encylopedia[$b][0],$userid)){
$user_det=$b;
}
if(!strcasecmp($encylopedia[$b][0],$friend)){
$friend_det=$b;
}
$b++;
}
$check_active=mysqli_query($con_central,"SELECT usn FROM active_user WHERE usn='$friend'");
while($row1=mysqli_fetch_assoc($check_active)){
$valletbox[]=$row1['usn'];
}
$call_messages_mine=mysqli_query($con_central,"SELECT usn_own,chat,unfort_time FROM chat_friends WHERE (usn_own='$userid' AND usn_friend='$friend')
					OR (usn_own='$friend' AND usn_friend='$userid') ORDER BY unfort_time DESC LIMIT 0,30");
while($row2=mysqli_fetch_row($call_messages_mine)){
for($i=0;$i<3;$i++){
$chatted[$a][$i]=$row2[$i];
}
$a++;
}
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="daring_northies.css">
</head>
<body style="background-color:white;">
<table border="0" align="center" style="background-color:black; width:100%; height:10%;">
<tr>
<td style="width:125%; background-color:#7070B8;" colspan="3"></td>
</tr></table>
<table border="0" align="center" style="background-color:white; width:80%; height:200%;">
<tr>
<td style="width:20%"; valign="top">
<center><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<input type="hidden" name="action" value="backto">
	<input type="submit" value="<?php echo $encylopedia[$user_det][1]; ?>">
	</form><center>
<div><img src="<?php echo $encylopedia[$friend_det][3]; ?>" width=100%></div>
<div><p style="font-size:125%; color:#2E2E8A;"><b>Name:</b><i><?php echo $encylopedia[$friend_det][1]; ?></i></p></div>	
</td>
<td valign="top">
<?php
echo"<table border='0' style='width:50%;'>
	<tr><td colspan='2' style='height:5%; border-width:5px; border-style:inset;'><form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
	<img style='border:2px solid black;box-shadow: 10px 1px 5px grey;' src=".$encylopedia[$user_det][2]." >
	<textarea cols=75% rows=5% name='chat_cont'>Chat here.....</textarea>
	<input type='submit' value='Send' name='action'>
	</form></td></tr>";
	for($i=0;$i<$a;$i++){
	if(!strcasecmp($chatted[$i][0],$userid)){
	echo"<tr><td style='width:5%; height:5%;'><img style='border:2px solid black;box-shadow: 10px 1px 5px grey;' src=".$encylopedia[$user_det][2]." ></td>
		<td style='color:#2E2E8A; text-align:right; width:80%; height:5%;'><b><i><sup style='font-size:50%;'>".$chatted[$i][2]."</sup>".
		$chatted[$i][1]."</b><i></td></tr>";
			
	}
	if(!strcasecmp($chatted[$i][0],$friend)){
			echo"<tr><td style='width:5%; height:5%;'><img style='border:2px solid black;box-shadow: 10px 1px 5px grey;' src=".$encylopedia[$friend_det][2]." ></td>
		<td style='color:#E6E6FF; font-size:125%; text-align:left; width:80%; height:5%; color:#2E2E8A;'><b><i><sup style='font-size:50%;'>".$chatted[$i][2]."</sup>".
		$chatted[$i][1]."</b><i></td></tr>";
	
	}		
}
echo"</table>";
?>
</td>
</tr>
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
case 'Send':{
$chat_content=$_POST["chat_cont"];
$user_name=$encylopedia[$friend_det][0];
$insert_self="INSERT INTO chat_friends(usn_own,usn_friend,time,chat,unfort_time) VALUES('$userid','$user_name','$final_da_ti','$chat_content','$real_time')";
if(!mysqli_query($con_central,$insert_self)){
echo"Could not write on chat page".mysqli_error($con_central);
}
$write_noti="INSERT INTO notification(type,from_usn,status,to_usn) VALUES(2,'$userid',0,'$user_name')";
if(!mysqli_query($con_central,$write_noti)){
echo"could not mention on notification".mysqli_error($con_central);
}
else{
header('Location:fr_chat.php');
}
break;
}
default:{
echo"";
break;
}
}
?>