<?php
error_reporting(0);
$mydate=getdate(date("U"));
$unfort_time=time();
$day=$mydate[mday];
$month=$mydate[month];
$year=$mydate[year];
$hour=$mydate[hours];
$min=$mydate[minutes];
$sec=$mydate[seconds];
$name_photo=array(array());

$final_da_ti=$day." ".$month." ".$year." ".$hour." ".
		$min." ".$sec;

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

$a=0;
$b=0;
$c=0;
$d=0;
$userid=$_SESSION["userid"];
$friends_call=$userid."my_friends";
$my_friends="SELECT $friends_call.usn,registered_members.name,registered_members.thumbnails FROM $friends_call,registered_members WHERE 
			$friends_call.friendship_status=2 AND $friends_call.usn=registered_members.usn";
$con_central=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$last_lgt=mysqli_query($con_central,"SELECT unfort_log FROM ip_add ORDER BY unfort_log LIMIT 1,2");
$log=array();
while($row15=mysqli_fetch_assoc($last_lgt))
{
$log[]=$row15['unfort_log'];
}
$fetching_usn=mysqli_query($con_central,$my_friends);
$friends=array(array());
while($row1=mysqli_fetch_row($fetching_usn))
{
$friends[$a][0]=$row1[0];
$friends[$a][1]=$row1[1];
$friends[$a][2]=$row1[2];
$a++;
}
$no_of_friends=$a;

$no_of_messages=array();
for($i=0;$i<$no_of_friends;$i++)
{
$usns=$friends[$i][0];
$unseens=mysqli_query($con_central,"SELECT chat FROM chat_friends WHERE unfort_time>'$final' AND usn_friend='$userid'
									ORDER BY unfort_time DESC LIMIT 0,30");
while($row30=mysqli_fetch_assoc($unseens))
{
$no_of_messages[]=$row30['chat'];
}
$unrd_msg[$i]=sizeof($no_of_messages);
$total_msg+=sizeof($no_of_messages);
}
?>
<?php
$show_all="SELECT usn FROM $friends_call WHERE friendship_status=2";
$showing_all=mysqli_query($con_central,$show_all);
$usn_all=array();
$i=1;
while($row7=mysqli_fetch_assoc($showing_all))
{
$usn_all[]=$row7['usn'];
$i++;
}
$l=0;
$dir=0;
foreach($usn_all as $value)
{
$active="SELECT distinct(usn) FROM active_user WHERE usn='$value'";
$activating=mysqli_query($con_central,$active);
$active_usn=array();
$dir=0;
while($row8=mysqli_fetch_assoc($activating))
{
$act_usn[]=$row8['usn'];
$dir++;
}
}
$a1=0;
echo"<h2 class='text'>ACTIVE Friends</h2>";

foreach($act_usn as $value)
{
$details="SELECT name,thumbnails,usn FROM registered_members WHERE
		registered_members.usn='$value'";
$nam_pho=mysqli_query($con_central,$details);
while($row8=mysqli_fetch_row($nam_pho))
{
$name_photo[$a1][1]=$row8[1];
$name_photo[$a1][0]=$row8[0];
$name_photo[$a1][2]=$row8[2];
$a1++;
}
}
?>
<html>
<head>
<link rel="shortcut icon" href="Website_Pictures/now.ico" >
<meta http-equiv="refresh" content="10">
<title>Chat</title>
<link rel="stylesheet" type="text/css" href="daring_northies.css">
</head>
<body>
<table border="0" align="center" height=100%>
<tr>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_profile.php">My Profile</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_friends.php">My Friends</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="wall.php">My Wall</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="photos.php">My Photos</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="discussion_topic.php">Trending Topics</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="chat.php">
CHAT<?php if(isset($total_msg)) echo"<p><sup style='color:red;'>".$total_msg."unread messages</p>";?></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="logout.php">Logout<a></td>
</tr>
<tr>
<td colspan="7" valign="top">
<div class="scrollable1" style="background-color:#E6E6FA; height:100%;">
<h2 style="color:#2E2E8A; text-align:center;"><u><i>My friends</u></i></h2>
<?php
$z1=0;
for($i=0;$i<$no_of_friends;$i++)
{
for($j=0;$j<1;$j++)
{
for($k=0;$k<$a1;$k++)
if(!strcasecmp($friends[$i][0],$name_photo[$k][2])){
$z1=1;
break;
}
echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
<p id='text1'><img src=".$friends[$i][2]." >".$friends[$i][1]."<sup style='color:red;'>";
echo $unrd_msg[$i]."message</sup>:";
if($z1==1) echo"<img src='Website_Pictures/live.png' >";
echo"<input type='Submit' value=".$friends[$i][0]." name='action'/></p>
	<input type='hidden' value=".$friends[$i][0]." name='usn_com'/>
	</form><hr>";
	}
echo"<br>";
if(isset($_POST["action"])){
$_SESSION["status"]=$_POST["action"];
$_SESSION["usn_com"]=$_POST["usn_com"];
}
$z1=0;
}
?>
</div>
<div class="scrollable2" style='height:100%;'>
<?php
if(!(isset($_SESSION["status"])))
{
echo"<h3><i><b>Your IP address is:</b>".$_SERVER["REMOTE_ADDR"]."<br><b>Your PORT no is:".$_SERVER["REMOTE_PORT"]."<br>So Act Responsibly!Please...</h3>";
}
else{
$usn=$_SESSION["usn_com"];
echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
<textarea cols='70' rows='5' name='text' placeholder='Enter Message to send'></textarea>
<input type='Submit' name='send' value='Send'>
<input type='hidden' name='action1' value='message'>
</form>";
$fetch_photo="SELECT thumbnails FROM registered_members WHERE usn='$usn'";
$fetch_self_photo="SELECT thumbnails FROM registered_members WHERE usn='$userid'";
$fetching_urs=mysqli_query($con_central,$fetch_self_photo);
$my_image=array();
$other_image=array();
while($row3=mysqli_fetch_assoc($fetching_urs))
{
$my_image[]=$row3['thumbnails'];
}
$fetching_others=mysqli_query($con_central,$fetch_photo);
while($row4=mysqli_fetch_assoc($fetching_others))
{
$other_image[]=$row4['thumbnails'];
}
$g=0;
$chats="SELECT usn_own,time,chat FROM chat_friends WHERE (usn_own='$userid' AND usn_friend='$usns') OR (usn_own='$usns' AND usn_friend='$userid')";
$chatting=mysqli_query($con_central,$chats);
$show=array(array());
while($row=mysqli_fetch_row($chatting))
{
for($i=0;$i<3;$i++)
$show[$g][$i]=$row[$i];
$g++;
}

for($i=$g-1;$i>-1;$i--)
{
if(!strcasecmp($show[$i][0],$usn))
{
echo"<img src=".$other_image[0]." width='40' height='60'>";
}
else if(!strcasecmp($show[$i][0],$userid))
{
echo"<img src=".$my_image[0]." width='25' height='40'>";
}
else
{
echo"pic";
}
for($j=1;$j>0;$j--)
{
echo"<span style='color:#2E2E8A;'><i><b>".$show[$i][2]."</b><span style='font-size:65%;'>".$show[$i][1]."</span></i></span>";
}
echo"<hr>";
}
 
}
?>
</div>

<div class="scrollable3">
<iframe src="notification.php" width=100% height=99%></iframe>
</div>
</td>
</tr>
</table>
</body>
</html>
<?php
$action=isset($_POST['action1'])?$_POST['action1']:null;
switch($action){
case 'message':{
$chat=$_POST["text"];
$usn2=$_SESSION["usn_com"];
$write_my_text="INSERT INTO chat_friends(usn_own,time,chat,unfort_time,usn_friend) VALUES('$userid','$final_da_ti','$chat','$unfort_time','$usn2')";
if(!mysqli_query($con_central,$write_my_text))
{
echo"could not store".mysqli_error($con_central);
}
$write_noti="INSERT INTO notification(type,from_usn,status,to_usn) VALUES(2,'$userid',0,'$usn2')";
if(!mysqli_query($con_central,$write_noti))
{
echo"Could not write notification".mysqli_error($con_central);
}
header('Location:chat.php');
break;
}
default:{
echo"";
}
}
?>