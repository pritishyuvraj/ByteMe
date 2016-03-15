<?php
error_reporting(0);
session_start();
$userid=$_SESSION['userid'];
$c=0;
$b=0; 
$d=0;
$e=0;
$f=0;
$g=0;
$con_central=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$gun_powder=$userid."my_friends";
$show_friends="SELECT usn FROM $gun_powder WHERE friendship_status=2";
$name_f=array();
$usn_f=array();
$calling_friends=mysqli_query($con_central,$show_friends);
while($row=mysqli_fetch_assoc($calling_friends))
{
$usn_f[]=$row['usn'];
$b++;
}
$_SESSION['no_fr']=$b;
$show_friend_req="SELECT usn FROM $gun_powder	WHERE friendship_status=1";
$showing_req=mysqli_query($con_central,$show_friend_req);
 //line 26
while($row=mysqli_fetch_array($showing_req))      //programing fault
{
echo"<br>".$row['usn']."<br>".$row['name']."<br>".$row['entry_no']."<br>";
}
$name_acc=array();
$usn_fun=array();
while($row=mysqli_fetch_assoc($showing_req)){
$name_acc[]=$row['name'];
$usn_fun[]=$row['usn'];
}
$own_details="SELECT usn,name,branch,roomno,email,whatsapp FROM registered_members WHERE usn='$userid'";
$owing_det=mysqli_query($con_central,$own_details);
$name_u=array();
while($row=mysqli_fetch_assoc($owing_det))
{
$name_u[]=$row['name'];
}
$show_photos="SELECT thumbnails FROM registered_members WHERE usn='$usn_f[$c]'";  //trouble coding
$showing_photos=mysqli_query($gun_powder,$show_photos);
$photo_add=array();
while($row=mysqli_fetch_assoc($showing_photos))
{
$photo_add[]=$row['thumbnails'];
$c++;
}
$my_friends_real=$userid."my_friends";
$gener_usn_fri="SELECT usn FROM $my_friends_real WHERE friendship_status=2";
$gener_usn_of_fri=mysqli_query($con_central,$gener_usn_fri);
$usn_friends=array();
$name_friends=array();
while($row1=mysqli_fetch_assoc($gener_usn_of_fri))
{
	$usn_friends[]=$row1['usn'];
	
	$e++;
}
	$usn_main_db=array();
	$photo_add=array();
	$name_friends=array();
	$branch_friends=array();

foreach($usn_friends as $value)
{
	$query_for_padd="SELECT usn,thumbnails FROM registered_members WHERE usn='$value'";
	$gen_profile_pic=mysqli_query($con_central,$query_for_padd);

	while($row2=mysqli_fetch_assoc($gen_profile_pic))
	{
	$photo_add[$f]=$row2['thumbnails'];
	$usn_main_db[$f]=$row2['usn'];
	$f++;
	}

	$query_for_n_b="SELECT name,branch FROM registered_members WHERE usn='$value'";
	$gen_name_branch=mysqli_query($con_central,$query_for_n_b);

	while($row3=mysqli_fetch_assoc($gen_name_branch))
	{
	$name_friends[$g]=$row3['name'];
	$branch_friends[$g]=$row3['branch'];
	$g++;	
	}
	
}

$action=isset($_POST['action'])?$_POST['action']:null;

switch($action){

case 'accept':
{
	$entry_no=$_POST['entryno'];
	$accepting_req="UPDATE $userid.my_friends SET friendship_status=friendship_status+1	WHERE friendship_status=1 and usn='$entry_no'";
	$retrive_usn="SELECT usn FROM $userid.my_friends WHERE entry_no='$entry_no'";
	$retrivingusn=mysqli_query($con_central,$retrive_usn);
	$retrived_usn=array();
	
	while($row=mysqli_fetch_assoc($retrivingusn))
	{
	$retrived_usn[]=$row['usn'];
	}
	$set_accept=mysqli_query($con_central,$accepting_req);
	if(!mysqli_query($con_central,$cre_fr_tb))
	{
	echo"could not register chat tables".mysqli_error($con_self);
	}
	if(!mysqli_query($con_self,$accepting_req))
	{
	echo"error adding friend".mysqli_error();
	}
	else
	{
	echo"Sucessfully added into your friend list";
	}
	
	$writing_notification="INSERT INTO notification (type,from_usn,status)
			VALUES(1,'$entry_no',0)";
	if(!mysqli_query($con_self,$writing_notification))
	{
	echo"Could not write into notification bar".mysqli_error($con_self);
	}
$writing_wall="INSERT INTO self_comments(usn,foreign_usn,type)
		VALUES('$userid',3,'$entry_no')";
	if(!mysqli_query($con_self,$writing_wall)){
echo"Could not write to your own wall".mysqli_error($con_self);
}
	$writing_wall_f="INSERT INTO foreign_comments(usn,foreign_usn,type)
			VALUES('$userid',3,'$entry_no')";
if(!mysqli_query($con_self,$writing_wall_f)){
echo"Could not write to wall".mysqli_error($con_self);
}	
	mysqli_close($con_self);
	
	$con_foriegn=mysqli_connect("localhost","root","",$entry_no);
	$cre_fr_my_tb="CREATE TABLE $userid(usn CHAR(30),name CHAR(30),
	time CHAR(30),chat VARCHAR(1000),unfort_time CHAR(30),seen INT DEFAULT 0)";
	if(!mysqli_query($con_foriegn,$cre_fr_my_tb))
	{
	echo"could not register chat tables".mysqli_error($con_foriegn);
	}	
	$writing_foreign_fr="UPDATE my_friends
	SET friendship_status=friendship_status+1
	WHERE usn='$userid' and friendship_status=1";
	if(!mysqli_query($con_foriegn,$writing_foreign_fr))
	{
	echo"Error adding friends".mysqli_error();
	}
	else
	{
	echo"Sucessfully added the friend";

	$writing_notification="INSERT INTO notification (type,from_usn,status)
			VALUES(1,'$userid',0)";
	if(!mysqli_query($con_foriegn,$writing_notification))
	{
	echo"Could not write into notification bar".mysqli_error($con_self);
	}
	$writing_wall_u="INSERT INTO self_comments(usn,foreign_usn,type)
			VALUES('$entry_no',3,'$userid')";
if(!mysqli_query($con_foriegn,$writing_wall_u))
{
echo"Could not write to wall".mysqli_error($con_foriegn);
}
	mysqli_close($con_foriegn);
	
	foreach($usn_friends as $value){
	$nw_con=mysqli_connect("localhost","root","",$value);
	$writing_wall="INSERT INTO self_comments(usn,foreign_usn,type)
			VALUES('$userid',3,'$entry_no')";
	if(!mysqli_query($nw_con,$writing_wall)){
	echo"could not enter into self comments".mysqli_error($nw_con);
			}
	}
	
	}
	
break;
}
case 'reject':
{
	$entry_no=$_POST['entryno'];
	$accepting_req="UPDATE my_friends 
	SET friendship_status=friendship_status-1
	WHERE usn='$entry_no'";
	$con_self=mysqli_connect("localhost","root","",$userid);
	$retrive_usn="SELECT usn FROM my_friends WHERE entry_no='$entry_no'";
	$retrivingusn=mysqli_query($con_self,$retrive_usn);
	$retrived_usn=array();
	
	while($row=mysqli_fetch_assoc($retrivingusn))
	{
	$retrived_usn[]=$row['usn'];
	}
	$set_accept=mysqli_query($con_self,$accepting_req);
	if(!mysqli_query($con_self,$accepting_req))
	{
	echo"error adding friend".mysqli_error();
	}
	else
	{
	echo"Friend Request Rejected";
	}

	$writing_notification="INSERT INTO notification (type,from_usn,status)
			VALUES(3,'$entry_no',0)";
	if(!mysqli_query($con_self,$writing_notification))
	{
	echo"Could not write into notification bar".mysqli_error($con_self);
	}

	mysqli_close($con_self);

	$con_foriegn=mysqli_connect("localhost","root","",$retrived_usn[0]);
	$writing_foreign_fr="UPDATE my_friends
	SET friendship_status=friendship_status-1
	WHERE usn='$userid'";
	if(!mysqli_query($con_foriegn,$writing_foreign_fr))
	{
	echo"Error adding friends".mysqli_error();
	}
	else
	{
	echo"Rejected Friend request";
	
	$writing_notification="INSERT INTO notification (type,from_usn,status)
			VALUES(3,'$userid',0)";
	if(!mysqli_query($con_foriegn,$writing_notification))
	{
	echo"Could not write into notification bar".mysqli_error($con_foriegn);
	}
	foreach($usn_friends as $value){
	$nw_con=mysqli_connect("localhost","root","",$value);
	$writing_wall="INSERT INTO self_comments(usn,foreign_usn,type)
			VALUES('$userid',4,'$entry_no')";
	if(!mysqli_query($nw_con,$writing_wall)){
	echo"could not enter into self comments".mysqli_error($nw_con);
			}
	}
	mysqli_close($con_foriegn);
	header('Location:my_friends.php');

	}

break;
}

case 'send':
{
	$send_to=$_POST['usn_send_req'];
	$con_self=mysqli_connect("localhost","root","",$userid);	
	$con_foriegn=mysqli_connect("localhost","root","",$send_to);
	$con_principal=mysqli_connect("localhost","root","","principal_database");
	$gen_name_foreign="SELECT name FROM registered_members
	WHERE usn='$send_to'";
	$generating_name=mysqli_query($con_principal,$gen_name_foreign);
	$foreign_name_fr=array();
	while($row=mysqli_fetch_assoc($generating_name))
	{
	$foreign_name_fr[]=$row['name'];
	}
	print_r($foreign_name_fr[0]);
	

	$my_name=mysqli_query($con_principal,"SELECT name FROM registered_members 
			WHERE usn='$userid'");	

	$name_mine=array();
	while($row=mysqli_fetch_assoc($my_name))
	{
	$name_mine[]=$row['name'];
	}	
	mysqli_close($my_name);
	
	$sending_fr_self="INSERT INTO my_friends
	(usn,name,own_usn,friendship_status,foreign_entry) VALUES
	('$send_to','$foreign_name_fr[0]','$userid',1,0)";	


	if(!mysqli_query($con_self,$sending_fr_self))
	{
	echo"Could not sent the friend request".mysqli_error($con_self);
	}
	else
	{
	echo"Sent the friend request";
	mysqli_close($con_self);
	}
	
	

	$sending_fr_foreign="INSERT INTO my_friends
	(usn,name,own_usn,friendship_status,foreign_entry) VALUES
	('$userid','$name_mine[0]','$send_to',1,1)";

	if(!mysqli_query($con_foriegn,$sending_fr_foreign))
	{
	echo"Error connecting database".mysqli_error($con_foriegn);
	}
	else
	{
	echo"Sucessfully sent the friend request";
	mysqli_close($con_foriegn);
	}

break;
}

default:
{
echo"";
break;
}
}
?>
<html>
<head>
<title><?php print_r($name_u[0]); ?>'s Friend</title>
<link rel="shortcut icon" href="Website_Pictures/now.ico" >
<link rel="stylesheet" type="text/css" href="daring_northies.css">
</head>
<body style="background-color:#7070B8;">

<table border="0" align="center" style="background-color:white; height:100%;">

<tr>
<td colspan="6"><h1 class="footer3"><?php print_r($name_u[0]); ?>'s Friend</h1></td>
</tr>

<tr>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_profile.php">My Profile</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="single.php"><b>Chat with Strangers</b></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="search_friends.php"><i>Search Friends</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="photos.php">My Photos</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="discussion_topic.php">Trending Topics</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="chat.php">CHAT with buddies</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="logout.php">Logout<a></td>
</tr>

<?php
$usn1=$_SESSION['userid'];
$showing=$usn1."my_friends";
echo $usn1;
$printing_friends="SELECT usn FROM $showing WHERE friendship_status=2";
$printing=mysqli_query($con_central,$printing_friends);
$disp_fr_nm=array();
$disp_fr_usn=array();
while($row=mysqli_fetch_assoc($printing))
	{
	$disp_fr_usn[]=$row['usn'];
	}
echo"<tr><div>";
for($i=1;$i<$e+1;$i++)
{
$j=$i-1;

echo "<td colspan='2' style='font-size:110%; color:#2E2E8A;'><form action='friends_my_profile.php' method='get'><p style='font-size:200%; color:#2E2E8A;'><center><b><i>
<img style='border:2px solid black;box-shadow: 10px 1px 5px grey;' src='$photo_add[$j]'>".$name_friends[$j];

$view_profile=$disp_fr_usn[$j];

echo"
<input type='hidden' name='friendship_status' value='2'>
<input type='Submit' value='$view_profile' 
name='usn_view_profile'><br>";
echo $branch_friends[$j].
"</b></i></p></center></td>";
if($i%3==0){
echo"</div></tr>";
}
}

?>



<tr>
<td colspan="2">
<h5 class="footer3" style='color:#2E2E8A;'><i></h5>
<br>
<form method="post" 
action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><br>
<input type="hidden" name="usn_send_req" value="1BI13">
<input type="hidden" value="SEND FRIEND REQUEST">
<input type="hidden" value="send" name="action">
</form>
</td>

<td colspan="2"><h5 class="footer3" style='color:#2E2E8A;'><i></i></h5>
<form method="post" 
action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><br>
<input name="hidden" type="hidden" value="1BI13">
<input type="hidden" value="Accept">
<input type="hidden" value="accept" name="action">
</form>
<?php
$usn2=$_SESSION['userid'];
$printing_requests="SELECT name,usn FROM my_friends WHERE		
		friendship_status=1 AND foreign_entry=1";
$con_print_req=mysqli_connect("localhost","root","",$userid);
$printing2=mysqli_query($con_print_req,$printing_requests);
while($row=mysqli_fetch_array($printing2))
{
echo"<br>".$row['name']."<br>".$row['usn'];
}
?>
</td>

<td colspan="2"><h5 class="footer3" style='color:#2E2E8A;'><i></i></h5>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"><br>
<input name="entryno" type="hidden" value="1BI13">
<input type="hidden" value="Reject">
<input type="hidden" value="reject" name="action">
</form>
</td>
</tr>

</table>
</body>
</html>