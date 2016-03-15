<?php
error_reporting(0);
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
$friends_usn=array();
$com_det=array(array());
$friend_req=array();
$req_sent=array();
$fr_others=array();
session_start();
$userid=$_SESSION["userid"];
$con_central=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$friends=$userid."my_friends";
$friends1=mysqli_query($con_central,"SELECT usn FROM $friends WHERE friendship_status='2'");
while($row1=mysqli_fetch_assoc($friends1)){
$friends_usn[]=$row1['usn'];
$a++;
}
$fr_reqs=mysqli_query($con_central,"SELECT usn FROM $friends WHERE foreign_entry='1' AND friendship_status='1'");
while($row3=mysqli_fetch_assoc($fr_reqs)){
$friend_req[]=$row3['usn'];
$c++;
}
$reqs_sent=mysqli_query($con_central,"SELECT usn FROM $friends WHERE foreign_entry='0' AND friendship_status='1'");
while($row4=mysqli_fetch_assoc($reqs_sent)){
$req_sent[]=$row4['usn'];
$d++;
}
$lower=0;
$upper=7;
if(!isset($_POST["prev"]) AND !isset($_SESSION["lower"])){
$_SESSION["lower"]=0;
}
if(!isset($_POST["next"]) AND !isset($_SESSION["upper"])){
$_SESSION["upper"]=7;
}
if(isset($_POST["prev"])){
if($_SESSION["lower"]-8>0){
$_SESSION["lower"]=$_SESSION["lower"]-8;
}
$_SESSION["upper"]=$_SESSION["upper"]-8;
$lower=$_SESSION["lower"];
$upper=$_SESSION["upper"];
}
elseif(isset($_POST["next"])){
$_SESSION["upper"]=$_SESSION["upper"]+8;
$_SESSION["lower"]=$_SESSION["lower"]+8;
$lower=$_SESSION["lower"];
$upper=$_SESSION["upper"];
}
else{
echo"";
}
if(!isset($_POST["search"])){
$members=mysqli_query($con_central,"SELECT usn,name,branch,thumbnails FROM registered_members WHERE registered_members.usn!='$userid' ORDER BY name ASC LIMIT $lower,$upper");
}
else{
if(isset($_POST["name"])){

$name="%".test_input($_POST["name"])."%";
$members=mysqli_query($con_central,"SELECT usn,name,branch,thumbnails
FROM registered_members WHERE registered_members.usn!='$userid' AND registered_members.name like '$name' ORDER BY name ASC LIMIT $lower,$upper");
}
elseif(isset($_POST["usn"])){
$usn1="%".test_input($_POST["usn"])."%";
$members=mysqli_query($con_central,"SELECT usn,name,branch,thumbnails
FROM registered_members WHERE registered_members.usn!='$userid' AND registered_members.usn LIKE '$usn1' ORDER BY name ASC LIMIT $lower,$upper");
}
elseif(isset($_POST["branch"])){
$branch1="%".test_input($_POST["branch"])."%";
$members=mysqli_query($con_central,"SELECT usn,name,branch,thumbnails FROM registered_members WHERE registered_members.usn!='$userid' AND 
registered_members.branch like '$branch1' ORDER BY name ASC LIMIT $lower,$upper");
}
elseif(isset($_POST["email"])){
$email1="%".test_input($_POST["email"])."%";
$members=mysqli_query($con_central,"SELECT usn,name,branch,thumbnails FROM registered_members
WHERE registered_members.usn!='$userid' registered_members.email like '$email1' ORDER BY name ASC LIMIT $lower,$upper");
}
else{
echo"Could not search!";
}
}
while($row2=mysqli_fetch_row($members)){
for($i=0;$i<4;$i++){
$com_det[$b][$i]=$row2[$i];
}
$b++;
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="daring_northies.css">
<link rel="shortcut icon" href="Website_Pictures/now.ico" >
<title>Hello <?php print_r($name[0]); ?></title>
</head>
<body style="background-color:#7070B8;">
<table border="0" align="center" style="background-color:white; height:97%;">
<tr>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_profile.php"><b>My Profile</b></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_friends.php"><i>My Friends</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="single.php"><b>Chat with Strangers</b></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="photos.php"><i>My Photos</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="discussion_topic.php"><i>Trending Topics</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="chat.php"><i>CHAT</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="logout.php"><i>Logout</i><a></td>
</tr>
<tr><td colspan="7">
<div class='scrollable1'>
<h1><b><i>Search Friends:</b></i></h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<input type="text" placeholder="Search by Name" name="name">
<input type="submit" value="Search" name="search">
</form>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<input type="text" placeholder="Search by USN" name="usn">
<input type="submit" value="Search" name="search">
</form>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<input type="text" placeholder="Search by Email" name="email">
<input type="submit" value="Search" name="search">
</form>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<input type="text" placeholder="Search by Branch" name="branch">
<input type="submit" value="Search" name="search">
</form>
<hr>
</div>
<div class='scrollable2'>
	<?php
	echo"<table style='width:100%; border='1';'>";
	for($i=0;$i<$b;$i=$i+2){
	echo"<tr>";
	for($k=$i;$k<$i+2;$k++){
	if($b==$k){
	break;
	}
	echo"<td style='width:10%; height=25%;'><img src=".$com_det[$k][3]." width=100%;></td>
			<td style='width:40%; height=25%; valign:top;'>";
			for($j=0;$j<$b;$j++){
			$f=0;
			if(!strcasecmp($friend_req[$j],$com_det[$k][0])){
			echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
			<input type='hidden' value=".$com_det[$k][0]." name='accept'>
			<input type='submit' value='Accept' name='action'>
			</form>";
			$f=1;
			break;
			}
			if(!strcasecmp($req_sent[$j],$com_det[$k][0])){
			echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
			<input type='hidden' value=".$com_det[$k][0]." name='cancel'>
			<input type='submit' value='Cancel' name='action'>
			</form>";
			$f=1;
			break;
			}
			if(!strcasecmp($friends_usn[$j],$com_det[$k][0])){
			echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
			<input type='hidden' value=".$com_det[$k][0]." name='remove'>
			<input type='submit' value='Remove' name='action'>
			</form>";
			$f=1;
			break;
			}
			}
			if($f!=1){
			echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
			<input type='hidden' value=".$com_det[$k][0]." name='send'>
			<input type='submit' value='Add' name='action'>
			</form>";
			}
		echo "<form action='friends_my_profile.php' method='get'>
		       <br>".$com_det[$k][1]."<br>".$com_det[$k][2]."<br>
			<input type='submit' value=".$com_det[$k][0]." name='usn_view_profile'>
			  </form></td>";
	}
	echo"</tr>";
	}
	if($b-7>0){
	echo"<tr><td></td><td></td><td></td><td>
	<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
	<input type='submit' value='Previous' name='prev'>
	<input type='submit' value='Next' name='next'>
	</form>
	</td></tr>";
	}
	echo"</table>";
	?>
	</div>
</div>
<div class='scrollable3' style='overflow:auto;'>
<?php
$g1=0;
echo"<table align='center' cellpadding='0' cellspacing='0' border='1' valign='top' style='background-color:white; height:100%;'>";
$for_details=mysqli_query($con_central,"SELECT usn,name,thumbnails FROM registered_members WHERE usn!='$userid'");
while($row6=mysqli_fetch_row($for_details)){
for($i=0;$i<3;$i++){
$details[$g1][$i]=$row6[$i];
}
$g1++;
}
for($i=0;$i<$c;$i++){
if(($i+1)%3==0 || $i==0){
echo"<tr>";
}
for($j=0;$j<$g1;$j++){
if(!strcasecmp($friend_req[$i],$details[$j][0])){
break;
}
}
echo"<td valign='top'><form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
	<img src=".$details[$j][2]." ><br>".$details[$j][1]."<br><input type='hidden' value=".$details[$j][0]." name='accept'>
	<input type='submit' name='action' value='Accept'>
	</form></td>";
if($i%3==0 && $i!=1){
echo"</tr>";
}
}
echo"</table>";
?>
</div>
</td></tr>
</table>
</body>
</html>
<?php
$action=isset($_POST["action"])?$_POST["action"]:null;
switch($action){
case 'Add':{
$fr_usn=test_input($_POST["send"]);
$ins_fr_mine="INSERT INTO $friends(usn,friendship_status,own_usn,foreign_entry) VALUES('$fr_usn',1,'$userid',0)";
if(!mysqli_query($con_central,$ins_fr_mine)){
echo"Could not sent a friend request because ".mysqli_error($con_central);
}
$real_friends=$fr_usn."my_friends";
$ins_fr_other="INSERT INTO $real_friends(usn,friendship_status,own_usn,foreign_entry) VALUES('$userid',1,'$fr_usn',1)";
if(!mysqli_query($con_central,$ins_fr_other)){
echo"Friend request didnt reach because ".mysqli_error($con_central);
}
else{
echo"Friend request sucessfully sent!";
}

break;
}
case 'Cancel':{
$fr_usn=$_POST["cancel"];
$del_fr_mine="DELETE FROM $friends WHERE usn='$fr_usn'";
if(!mysqli_query($con_central,$del_fr_mine)){
echo"Could not delete friend request because".mysqli_error($con_central);
}
$real_friends=$fr_usn."my_friends";
$del_fr_other="DELETE FROM $real_friends WHERE usn='$userid'";
if(!mysqli_query($con_central,$del_fr_other)){
echo"Could not delete friend request from other".mysqli_error($con_central);
}
header('Location:search_friends');
break;
}
case 'Remove':{
$remove=$_POST["remove"];
$remove_mine="DELETE FROM $friends WHERE usn='$remove' AND friendship_status=2";
if(!mysqli_query($con_central,$remove_mine)){
echo"Could not unfriend yours".mysqli_error($con_central);
}
$real_friends=$remove."my_friends";
$remove_his="DELETE FROM $real_friends WHERE usn='$userid' AND friendship_status=2";
if(!mysqli_query($con_central,$remove_his)){
echo"Could not unfriend his".mysqli_query($con_central);
}
break;
}
case 'Accept':{
$accept=$_POST["accept"];
$real_friends=$accept."my_friends";
$add_friend_other="UPDATE $real_friends SET friendship_status=2 WHERE friendship_status=1 AND usn='$userid'";
if(!mysqli_query($con_central,$add_friend_other)){
echo"Could not add to as your friend".mysqli_error($con_central);
}
else{
$add_self_friend="UPDATE $friends SET friendship_status=2 WHERE friendship_status=1 AND usn='$accept'";
if(!mysqli_query($con_central,$add_self_friend)){
echo"Could not add friend because:".mysqli_error($con_self);
}
else{
echo"Sucessfully added to your friend list";
$adding_notifi_self="INSERT INTO notification(type,from_usn,from_branch) VALUES(1,'$accept','$userid')";
if(!mysqli_query($con_central,$adding_notifi_self)){
echo"Could not notify because".mysqli_error($con_central);
}
$adding_noti_other="INSERT INTO notification(type,from_usn,from_branch) VALUES(1,'$userid','$accept')";
if(!mysqli_query($con_central,$adding_noti_other)){
echo"Could not notify".mysqli_error($con_central);
}
$comments=$userid."self_comments";
$own_wall="INSERT INTO $comments(usn,foreign_usn,type) VALUES('$userid',3,'$accept')";
if(!mysqli_query($con_central,$own_wall)){
echo"could not write to your wall".mysqli_error($con_central);
}
$real_comments=$accept."self_comments";
$friend_wall="INSERT INTO $real_comments(usn,foreign_usn,type) VALUES('$accept',3,'$userid')";
if(!mysqli_query($con_central,$friend_wall)){
echo"could not write into friends wall".mysqli_error($con_central);
}
$friends_other=msyqli_query($con_central,"SELECT usn FROM $real_friends WHERE friendship_status=2 AND usn!='$userid'");
while($row5=mysqli_fetch_assoc($friends_other)){
$fr_others[]=$row5['usn'];
$e++;
}
foreach($friends_usn as $value){
$friends_connecting=$value."self_comments";
$ins_mine="INSERT INTO $friends_connecting(usn,foreign_usn,type) VALUES('$userid',3,'$value')";
if(!mysqli_query($con_central,$ins_mine)){
echo"Could not write to wall";
}
}
foreach($fr_others as $value){
$real_friends_connecting=$value."self_comments";
$ins_other="INSERT INTO $real_friends_connecting(usn,foreign_usn,type) VALUES('$userid',3,'$value')";
if(!mysqli_query($con_central,$ins_other)){
echo"Could not write to his friends notification".mysqli_error($con_central);
}
}
}
}
break;
}
}
?>