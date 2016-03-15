<html>
<head>
<link rel="stylesheet" type="text/css" href="daring_northies.css">
<link rel="shortcut icon" href="Website_Pictures/now.ico" >
<title>Hello <?php print_r($name[0]); ?></title>
<meta http-equiv="refresh" content="12">
</head>
<body>
<table>
<tr>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_Profile.php"><b>My Profile</b></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_friends.php"><i>My Friends</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="search_friends.php"><i>Search Friends</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="photos.php"><i>My Photos</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="discussion_topic.php"><i>Trending Topics</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="chat.php"><i>CHAT</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="logout.php"><i>Logout</i><a></td>
</tr>
<?php
$time=time();
$a=0;
$b=0;
session_start();
$con_central=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$userid=$_SESSION["userid"];
$free_user=mysqli_query($con_central,"SELECT usn FROM active_user WHERE usn!='$userid' AND chatted='1'");
$free_people=array();
while($row1=mysqli_fetch_assoc($free_user)){
$free_people[$a]=$row1['usn'];
$a++;
}
if(!isset($_POST["chat_text"]) || isset($_POST["ignite"])){
echo"<tr><td colspan='4' valign='top'><form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
	<input type='hidden' value='change_status' name='action'>
<h3 style='color:#2E2E8A' text-align:'center';><b><i><span style='color:red;'> STEP 1:</span>Click here for the first and subsequently to find new person to chat</b></i>	<input type='submit' name='nothing'>  </h3>
	</form></td>"; //Test
}
	echo $_SESSION["status_now_changed"];
if(isset($_SESSION["status_now_changed"])){
echo"";
echo"<td colspan='3' valign='top'><form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
	<b><i>STEP 2:Restart the page(For the next chat, Re-press the STEP1 button)</b></i>
	<input type='hidden' name='action' value='next'>
	<input type='submit' name='ignite'>
	<input type='hidden' value=".$_SESSION["chat_with"]." name='reject_usn'>
	</form></td></tr>";
$check_my_status=mysqli_query($con_central,"SELECT chatted FROM active_user WHERE usn='$userid'");
$status=array();
while($row2=mysqli_fetch_assoc($check_my_status)){
$status[]=$row2['chatted'];
}
$abcdef=(int)$status[0];
if($status[0]==='1'){
if($a>0){

$no=rand();
$no=(int)($no%$a);

$chat_with=$free_people[$no];
$_SESSION["chat_with"]=$chat_with;
$changing_status_again="UPDATE active_user SET chatted='$chat_with' WHERE usn='$userid' AND chatted=1";
$changing_status_friend="UPDATE active_user SET chatted='$userid' WHERE usn='$chat_with' AND chatted=1";
if(!mysqli_query($con_central,$changing_status_again)){
echo"could not change your status".mysqli_error($con_central);
}
else{
echo"";
}
if(!mysqli_query($con_central,$changing_status_friend)){
echo"Could not change your friends status".mysqli_error($con_central);
}
else{
echo"";
}
}
else{
echo"Try again in few minutes because all are already engaged!";
}

}
elseif($status[0]!='1' && $status[0]!='0'){
$check_my_status=mysqli_query($con_central,"SELECT chatted FROM active_user WHERE usn='$userid'");
$status=array();
while($row2=mysqli_fetch_assoc($check_my_status)){
$status[]=$row2['chatted'];
}
$chat_with=$status[0];
$_SESSION["chat_with"]=$chat_with;
}
$chat_with=$_SESSION["chat_with"];
echo"<tr><td colspan='5' valign='top'><form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
	<textarea cols='50' rows='3' name='chat_text'>Chat here.....</textarea>
	<input type='submit' name='action' value='Send'>
	<input type='hidden' value=".$chat_with." name='send_to'>
	</form></td></tr>";
$select_chat=mysqli_query($con_central,"SELECT usn_approach,message FROM chat WHERE (usn_approach='$userid' AND usn_accept='$chat_with') 
				OR (usn_approach='$chat_with' AND usn_accept='$userid') ORDER BY time DESC");
while($row3=mysqli_fetch_row($select_chat)){
for($j=0;$j<2;$j++){
$chat1[$b][$j]=$row3[$j];
}
$b++;	
}
for($i=0;$i<$b;$i++){
if(!strcasecmp($chat1[$i][0],$userid)){
echo"<tr><td colspan='4' valign='top'><b><i>You:</b>".$chat1[$i][1]."</i></td></tr>";
}
elseif(!strcasecmp($chat1[$i][0],$chat_with)){
echo"<tr><td colspan='4' valign='top'><b><i>Stranger:</b>".$chat1[$i][1]."</i></td></tr>";
}
}
}
?>
</table>
</body>
</html>
<?php
$action=isset($_POST["action"])?$_POST["action"]:NULL;
switch($action){
case 'change_status':{

$change_status=mysqli_query($con_central,"UPDATE active_user SET chatted=1 WHERE usn='$userid' AND chatted=0");
$_SESSION["status_now_changed"]=1;
$status_now_changed=1;
break;
}
case 'Send': {
$message=$_POST["chat_text"];
$send_to=$_POST["send_to"];
$inserting=mysqli_query($con_central,"INSERT INTO chat(usn_approach,usn_accept,message,time) VALUES('$userid','$send_to','$message','$time')");
header('Location:single.php');
break;
}
case 'next':{
$usn_to_reject=$_POST["reject_usn"];
$start_deleting=mysqli_query($con_central,"UPDATE active_user SET chatted=1 WHERE (usn='$userid' AND chatted='$usn_to_reject') OR (usn='$usn_to_reject' AND chatted='$userid')");
$_SESSION["chat_with"]=0;
break;
}
default:{
break;
}
}
?>