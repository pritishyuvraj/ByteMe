<?php
$mydate=getdate(date("U"));
error_reporting(0);
$day=$mydate[mday];
$month=$mydate[month];
$year=$mydate[year];
$hour=$mydate[hours];
$min=$mydate[minutes];
$sec=$mydate[seconds];
$final_da_ti=$day." ".$month." ".$year." ".$hour." ".
		$min." ".$sec;
$final_da=$day." ".$month." ".$year;
session_start();
$ip_address_add=$_SERVER["REMOTE_ADDR"];
$ip_address_port=$_SERVER["REMOTE_PORT"];
$userid=$_SESSION['userid'];
$con=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$show_table=mysqli_query($con,"SELECT name,branch,usn,phone,email,whatsapp,roomno,thumbnails,photo_add FROM registered_members WHERE usn='$userid'");
$name=array();
$branch=array();
$photo_small=array();
$photo_big=array();
while($row=mysqli_fetch_assoc($show_table))
{
$name[]=$row['name'];
$branch[]=$row['branch'];
$usn[]=$row['usn'];
$phone[]=$row['phone'];
$email[]=$row['email'];
$whatsapp[]=$row['whatsapp'];
$room[]=$row['roomno'];
$photo_small[]=$row['thumbnails'];
$photo_big[]=$row['photo_add'];
}
if($_SESSION["frip"]==0){
$write_log="INSERT INTO ip_add(usn,ip_add_agent,login_time,login_date)
	VALUES('$userid','$ip_address_add','$final_da_ti','$final_da')";                
if(!mysqli_query($con,$write_log))
{
echo"IP Address could not be stored".mysqli_error($con);
}
$n=$name[0];
$w=$whatsapp[0];
$p=$photo_small[0];
$write_in="INSERT INTO active_user(usn,name,ip_add,log_in,relationship,photo,chatted)
	VALUES('$userid','$n','$ip_address_add','$final_da_ti','$w','$p',0)";
if(!mysqli_query($con,$write_in)){
echo"Invalid entry to active".mysqli_error($con);
}
$_SESSION["frip"]=1;
}
mysqli_close($con);
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="daring_northies.css">
<link rel="shortcut icon" href="Website_Pictures/now.ico" >
<title>Hello <?php print_r($name[0]); ?></title>
</head>
<body style="background-color:#7070B8;">
<table border="0" align="center" style="background-color:white; height:102%;">
<tr>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="single.php"><b>Chat with Strangers</b></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_friends.php"><i>My Friends</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="search_friends.php"><i>Search Friends</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="photos.php"><i>My Photos</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="discussion_topic.php"><i>Trending Topics</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="chat.php"><i>CHAT</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="logout.php"><i>Logout</i><a></td>
</tr>
<tr>
<td colspan="7">
<div class="scrollable1" style='float:left; width:'30%'; height:100%; overflow:auto;'>
<img class="profile_pic" src="<?php echo $photo_big[0]; ?>" width="90%">
<div style='color:#2E2E8A;'><p style='font-size:125%;'><b>Name:</b><i> <?php print_r($name[0]); ?></i></div>
<div style='color:#2E2E8A;'><b>University Serial No:</b><i> <?php print_r($usn[0]); ?></i></div>
<div style='color:#2E2E8A;'><b>Branch:</b><i> <?php print_r($branch[0]); ?></i></div>
<div style='color:#2E2E8A;'><b>Phone No:</b><i> <?php print_r($phone[0]); ?></i></div>
<div style='color:#2E2E8A;'><b>Email ID:</b><i> <?php print_r($email[0]); ?></i></div>
<div style='color:#2E2E8A;'><b>Single:</b><i> <?php print_r($whatsapp[0]); ?></i></div>
<div style='color:#2E2E8A;'><b>Semester:</b><i> <?php print_r($room[0]); ?></i></p></div>
<a href='editing.php'>Change details</a>
</div>

<div class="scrollable2" style="width:60%; overflow:auto; background-color:white; height:100%;"><iframe style=" width:99%; height:98%; display:inline;" src="wall.php"></iframe>
</div>
<div class="scrollable3" style="overflow:auto; height:100%; background-image:url("Website_Pictures/background2.png");">
<iframe src="notification.php" style="width:100%; height:98%; display:inline;"></iframe></div>
</td>
</tr>
</table>
</body>
</html>
