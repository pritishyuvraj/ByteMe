<html>
<body>
<h2 style='color:#2E2E8A;'><center><i>My Wall</i></center></h2><hr>
<table cellSpacing='0' cellPadding='0' border='0'>
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
$g=0;
$h=0;
$zmr=0;
$kl=0;

$encylopedia_central=array(array());
$n_ph_mine=array(array());
$n_ph_his1=array(array());
$n_ph_his=array(array());
$n_ph_mine=array(array());
$nm_ph1=array(array());
$photo=array();
$photo_add1=array();
session_start();
$userid=$_SESSION["friend_usn"];
$userid_access=$_SESSION["userid"];
$con_central=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$wall_self=$userid."self_comments";
$all_noti=mysqli_query($con_central,"SELECT usn,unique_no,foreign_usn,type,comment,time from $wall_self LIMIT 0,30");
$encylopedia=array(array());
while($row1=mysqli_fetch_row($all_noti)){
for($i=0;$i<5;$i++){
$encylopedia[$a][$i]=$row1[$i];
}
$a++;
}
for($j=$a-1;$j>-1;$j--){
if($encylopedia[$j][2]==1 || $encylopedia[$j][2]==2){

$usn_ph_hv=$encylopedia[$j][3];
$photo_no=$encylopedia[$j][1];

$encylopedia_central_bak=mysqli_query($con_central,"SELECT usn,name,thumbnails FROM registered_members");
while($row8=mysqli_fetch_row($encylopedia_central_bak)){
for($i=0;$i<3;$i++){
$encylopedia_central[$kl][$i]=$row8[$i];
}
$kl++;
}
$ret_ph_hv=mysqli_query($con_central,"SELECT name,thumbnails,usn FROM registered_members WHERE usn='$usn_ph_hv'");
$photo_disp=$usn_ph_hv."photo_add_self";
$ret_hot_photo=mysqli_query($con_central,"SELECT photo_add FROM $photo_disp WHERE unique_no='$photo_no'");

while($row2=mysqli_fetch_row($ret_ph_hv)){
for($i=0;$i<3;$i++){
$nm_ph1[$b][$i]=$row2[$i];
}
}
while($row3=mysqli_fetch_assoc($ret_hot_photo)){
$photo_add1[$c]=$row3['photo_add'];
}
echo"<tr>
<td valign='top'><div style='float:left;' class='scrollable1' width='60%'><p><h2 style='color:#2E2E8A;'>
<img style='border:2px solid black;box-shadow: 10px 1px 5px grey;'
src=".$nm_ph1[$b][1]." width='50' heigh='75'><i> ".$nm_ph1[$b][0]."</h2>";
if($encylopedia[$j][2]==1){
echo"ADDED a new photo";
}
if($encylopedia[$j][2]==2){
echo"Commented on photo";
}
echo"<form action='photo_friend.php' method='get' target='_blank'>
	<input type='hidden' value=".$photo_add1[$c]." name='photo_addr' >
	<input type='hidden' value=".$photo_no." name='photo_no'>
	<input type='hidden' value=".$usn_ph_hv." name='friend_usn'>
	<input type='submit' value='Full Story'>
	</form>";
echo"</i></p></div></td><td><div style='float:left;' class='scrollable2' width='100%'>
<img style='border:4px solid black;box-shadow: 10px 1px 5px grey;' src=".$photo_add1[$c]." width='60%'></div></td></tr>";
echo"<tr><td colspan='2'><form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
	<textarea cols='60%' rows='3%' name='photo_comment'>Enter your comments</textarea>
	<input type='hidden' value=".$photo_no." name='connect_to'>
	<input type='hidden' value=".$encylopedia[$j][3]." name='for_usn'>
	<input type='submit' name='action' value='comment'></form></td></tr>";
$m1=0;
$comment1=array(array());
$wall_writing=$usn_ph_hv."self_comments";
$calling_messages=mysqli_query($con_central,"SELECT usn,comment FROM $wall_writing WHERE (unique_no='$photo_no' AND foreign_usn=2) AND type='$usn_ph_hv' 
					ORDER BY time DESC LIMIT 0,4");
while($row7=mysqli_fetch_row($calling_messages)){
for($m=0;$m<2;$m++){
$comment1[$m1][$m]=$row7[$m];
}
$m1++;
}
for($m2=0;$m2<$m1;$m2++){
echo"<tr><td height='5'><form action='friends_my_profile.php' method='get' target='_blank'>
	<input type='submit' value=".$comment1[$m2][0]." name='usn_view_profile'></form>
	</td>";
	for($kj=0;$kj<$kl;$kj++){
	if(!strcasecmp($encylopedia_central[$kj][0],$comment1[$m2][0])){
	break;
	}
	}
	echo"<td height='2'><i><img src=".$encylopedia_central[$kj][2]." ><b>".$encylopedia_central[$kj][1]."</b>:".$comment1[$m2][1]."</i></td></tr>";
	
	
}
echo"<tr><td colspan='2'><hr style='height:2%; color:#2E2E8A;'></td></tr>";
$b++;
$c++;
}

elseif($encylopedia[$j][2]==3){
$friend_usn2=$encylopedia[$j][0];
$other_usn2=$encylopedia[$j][3];
$my_photo2=mysqli_query($con_central,"SELECT name,thumbnails FROM registered_members WHERE usn='$friend_usn2'");
$other_photo2=mysqli_query($con_central,"SELECT name,thumbnails FROM registered_members WHERE usn='$other_usn2'");
while($row4=mysqli_fetch_row($my_photo2)){
for($i=0;$i<2;$i++){
$n_ph_mine[$d][$i]=$row4[$i];
}
}
while($row5=mysqli_fetch_row($other_photo2)){
for($i=0;$i<2;$i++){
$n_ph_his[$e][$i]=$row5[$i];
}
}
echo"<tr><td valign='top'><div class='scrollable1' style='float:left;'><p style='color:#2E2E8A; font-size:100%'><i><b>".$n_ph_mine[$d][0]."</b></i><br>
	<img style='border:2px solid black;box-shadow: 10px 1px 5px grey;' src=".$n_ph_mine[$d][1]." ></p><div></td><td><div class='scrollable1' style='float:left;'><p style='font-size:100%;'>
	<i> Is now friends with :<b>".$n_ph_his[$e][0]."</b></i><br><img style='border:2px solid black;box-shadow: 10px 1px 5px grey;' src=".$n_ph_his[$e][1]." ></div></td></tr>";
$d++;
$e++;
}
elseif($encylopedia[$j][2]==4){
$friend_usn3=$encylopedia[$j][0];
$other_usn3=$encylopedia[$j][3];
$my_photo3=mysqli_query($con_central,"SELECT name,photo_add FROM registered_members,profile_pic 
WHERE registered_members.usn='$friend_usn3' AND profile_pic.usn='$friend_usn3'");
$other_photo3=mysqli_query($con_central,"SELECT name,photo_add FROM registered_members,profile_pic 
WHERE registered_members.usn='$other_usn3' AND profile_pic.usn='$other_usn3'");
while($row5=mysqli_fetch_row($my_photo3)){
for($i=0;$i<2;$i++){
$n_ph_mine1[$g][$i]=$row5[$i];
}
}
while($row6=mysqli_fetch_row($other_photo3)){
for($i=0;$i<2;$i++){
$n_ph_his1[$h][$i]=$row6[$i];
}
}
echo"<tr><td valign='top'><div class='scrollable1' style='float:left;'><p style='color:blue; font-size:200%'>".$n_ph_mine1[$g][0]."<br>
	<img src=".$n_ph_mine1[$g][1]." ></p><div></td><td><div class='scrollable1' style='float:left;'><p style='font-size:150%;'>
	Rejected friend request of :<sup style='color:blue;'>".$n_ph_his1[$h][0]."</sup><br><img src=".$n_ph_his1[$h][1]."></div></td></tr><hr>";
$g++;
$h++;
}
}
?>
</table>
</body>
</html>
<?php
$action=isset($_POST["action"])?$_POST["action"]:NULL;
switch($action){
case 'comment':{

$what_comment=test_input($_POST["photo_comment"]);
$fr_comment=$_POST["connect_to"];
$usn_meant=$_POST["for_usn"];
$adding1=$usn_meant."self_comments";
$inserting_friend="INSERT INTO $adding1(usn,unique_no,foreign_usn,comment,type,time) VALUES('$userid_access','$fr_comment',2,'$what_comment','$usn_meant','$time')";
if(!mysqli_query($con_central,$inserting_friend)){
echo"could not write comments".mysqli_error($con_central);
}
if(strcasecmp($userid_access,$usn_meant)){
if(!mysqli_query($con_central,$inserting_friend)){
echo"could not sucessfully connect ".mysqli_error($con_central);
}
}
$friends1=$usn_meant."my_friends";
$my_friends=mysqli_query($con_meanigful,"SELECT usn FROM $friends1 WHERE usn!='$userid_access' OR usn!='$usn_meant'");
$zmr=0;
$friends_usn=array();
while($row9=mysqli_fetch_assoc($my_friends)){
$friends_usn[$zmr]=$row9['usn'];
$zmr++;
}
foreach($friends_usn as $value){
$friends2=$value."self_comments";
$write_friends_wall="INSERT INTO $friends2(usn,unique_no,foreign_usn,comment,type,time)
				VALUES('$userid_access','$fr_comment',2,'$what_comment','$usn_meant','$time')";
if(!mysqli_query($con_central,$write_friends_wall)){
echo"Could not write on friends notification";
}
}
header('Location:wall.php');
break;
}
default:{
echo"";
}
}
?>