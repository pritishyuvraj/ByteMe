<?php
error_reporting(0);
session_start();
$userid=$_SESSION['userid'];
$con_central=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$a=0;
$b=0;
$c=0;
$d=0;
$e=0;
?>

<html>
<head>
<link rel="shortcut icon" href="Website_Pictures/now.ico" >
<link rel="stylesheet" type="text/css" href="daring_northies.css">
<title>Hello <?php print_r($userid); ?></title>
</head>
<body style="background-color:#7070B8;">
<table border="0" align="center" style='background-color:white; height:100%;'>

<tr>
<td colspan="6"><h1 class="footer3">Welcome to Facebook</h1></td>
</tr>
<tr>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_profile.php">My Profile</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="my_friends.php">My Friends</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="search_friends.php"><i>Search Friends</i></a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="photos.php">My Photos</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="discussion_topic.php">Trending Topics</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="chat.php">CHAT with buddies</a></td>
<td style="width: 200px;" class="navigator"><a class="navig_hover" href="logout.php">Logout<a></td>
</tr>

<tr>

<td colspan="1" rowspan="100"><div class="scrollable1" style="width:100%;">
<h2 style='color:#2E2E8A;'><i>Current Topics:</i></h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
method="post">
<ul><div>
<select name="topics">
<option value="Movies">Movies</option>
<option value="Technical">Technical</option>
<option value="Trending">Trending</option>
<option value="Others">Other Topics</option>
</select>

<input type="hidden" value="topics_type" name="action">
<input type="Submit" value="Order by Topics">
</ul></form>
<?php
if(isset($_POST["topics"]))
{
$read_user_choice=$_POST["topics"];

$bring_out_top_nm="SELECT topic_name FROM cen_dis_topic WHERE topics='$read_user_choice' ORDER BY topic_no DESC";
$bringing=mysqli_query($con_central,$bring_out_top_nm);
$disp_top=array();

while($row3=mysqli_fetch_assoc($bringing))
{
	$disp_top[]=$row3['topic_name'];
	$a++;
}

	for($x=0;$x<$a;$x++)
	{
	echo "<form action='$_SERVER[PHP_SELF]' method='post'>
	<div style='background-color:#EBEBF5;'><input type='Submit' value='$disp_top[$x]' name='topic_name3'></div>
	<input type='hidden' value='showing_topics' name='action'>
	</form>";	
	}	
echo"</div>";
}
else
{
echo"";
}
?>
</h3>
<hr><h2 style="color:#2E2E8A;"><i>Register a topic:</i></h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
method="post" enctype="multipart/form-data">
<ul>
<li><input type="text" name="topic_name5" value="Topic Name"></li>
<li>
<select name="category">
<option value="Movies">Movies</option>
<option value="Technical">Technical</option>
<option value="Trending">Trending</option>
<option value="Others">Others</option>
</select></li></ul>
<i>Upload Pic:</i><input type="file" name="file" id="file">
<textarea cols="20" rows="5" name="topic_comment" placeholder="Enter Comments"></textarea>
<input type="hidden" name="creater_usn" value="<?php echo $userid; ?>">
<input type="hidden" name="action" value="create_topic">
<input type="Submit" value="Register">
<hr></form>
<?php 

if(isset($_POST["topic_name3"]))
{
$e=strcmp($_POST["topic_name3"],$_SESSION['access_top']);
	if($e!=0)
	{
	$_SESSION['access_top']=$_POST["topic_name3"];
	}
}


if(!isset($_SESSION['access_top']))
{
$_SESSION['access_top']=$_POST["topic_name3"]; 
}
?>
</div></td>

<?php

if((isset($_POST["topic_name3"]))&& (isset($_SESSION['access_top'])))
{
$user_sel_topic=$_POST["topic_name3"];
}
else if(isset($_SESSION['access_top']))
{
$user_sel_topic=$_SESSION['access_top'];
}
else
{
echo"";
}

if(isset($user_sel_topic))
{

$user_sel_topic=$_SESSION['access_top'];
$_SESSION['topic_n_gl']=$user_sel_topic;
$retriv_abt_top="SELECT topic_name,comments,usn,topic_no,photo FROM cen_dis_topic WHERE topic_name='$user_sel_topic'";
$ret1=mysqli_query($con_central,$retriv_abt_top);

$tp_nm=array();
$com=array();
$usn=array();
$tp_no=array();
$photo_disp=array();

while($row5=mysqli_fetch_assoc($ret1))
{
$tp_nm[]=$row5['topic_name'];
$com[]=$row5['comments'];
$usn[]=$row5['usn'];
$tp_no[]=$row5['topic_no'];
$photo_disp[]=$row5['photo'];
}

$sel_usn_det="SELECT name,branch FROM registered_members WHERE usn='$usn[0]'";
$ret2=mysqli_query($con_central,$sel_usn_det);

$cre_nm=array();
$cre_pho=array();
$cre_br=array();

while($row6=mysqli_fetch_assoc($ret2))
{
$cre_nm[]=$row6['name'];
$cre_br[]=$row6['branch'];
}


$ret3=mysqli_query($con_central,"SELECT thumbnails FROM registered_members WHERE usn='$usn[0]'");

while($row7=mysqli_fetch_assoc($ret3))
{	
$cre_pho[]=$row7['photo_add'];
}


echo "<td colspan='6' style=''><div class='scrollable2' style='text-align:center; width:70%; background-color:black; color:white;'>";

if($photo_disp[0]!='NULL'){
echo"<img src=".$photo_disp[0]." 
style='background-color:black;' width=70%><hr><marque><h1 style='color:white; font-size:200%' class='text'><i>".$tp_nm[0]."<sub style='color:#2E2E8A; font-size:40%'> by :".$cre_nm[0]."</sub></h1>
<br><p style='text-align:center;'></marque>".$com[0]."</p></i></div>";
}
else{
echo"<h1 style='color:#2E2E8A; background-color:white; width:40%;' class='text'>"
.$tp_nm[0]."<sub style='color:#2E2E8A;'>by:".$cre_nm[0]."</h1><p style='text-align:right;'>".$com[0]."<hr><img src='$cre_pho[0]' width=100px height=150px /></p></div>";
}
echo"<div class='scrollable3' style='width:30%;'>
	<form action=".htmlspecialchars($_SERVER["PHP_SELF"])."
	method='post'>
	<img src='$cre_pho[0]' width=75px height=100px />
	
	<textarea cols='20' rows='6' name='tops_comments'>Comment on ".$cre_nm[0]."'s post....... </textarea>
	<input type='Submit' value='Submit Commnets'>
	<input type='hidden' value='sv_cmmts' name='action'>
	</form>";
$topic_n=$_SESSION['topic_n_gl'];
$com_by_usn="SELECT * FROM $topic_n";

$connecting=mysqli_query($con_central,$com_by_usn);

$what_com=array();
$who_com=array();
$unique=array();

while($row13=mysqli_fetch_assoc($connecting))
{
$what_com[]=$row13['comments_usn'];
$who_com[]=$row13['usn'];
$unique[]=$row13['unique_no'];
$no_of_li[]=$row13['likes'];
$b++;
}
$details=array(array());
foreach($who_com as $value){
$fetch_me_photos=mysqli_query($con_central,"SELECT name,thumbnails FROM
registered_members WHERE
registered_members.usn='$value'");
while($row14=mysqli_fetch_row($fetch_me_photos)){
for($i=0;$i<2;$i++){
$details[$e][$i]=$row14[$i];
}
$e++;
}
}
echo"<hr><div  style='width:100%;'>";
for($u=1;$u<$b;$u++)
{
echo"<div style='width:100%;'><form action=".htmlspecialchars ($_SERVER["PHP_SELF"])." method='post'>
	<input type='hidden' value=".$unique[$u]." name='like'>
	<div style='float:left; width:15%; height=40;'><img src=".$details[$u][1]."></div>
	<div style='float:left; width:85%; height=40;'><b><i><p style='text-align:left; color:#2E2E8A; font-size:125%;'> ".$details[$u][0]."</b>
	<input type='Submit' value=".$no_of_li[$u]."Likes>
	</div>".$what_com[$u]."</i></div><input type='hidden' value='like_alog' name='action'></form><hr>";
}
echo"</div></div></tr>";
}
else
{
echo"";

if(isset($_SESSION['access_top']))
{
echo $_SESSION['access_top'];
}
else
{
echo "";
}
}
if(!isset($user_sel_topic))
{
echo"<tr><td colspan='4'>
<h1>Welcome to Common Discussion Table</h1>
<p style='text-align:right;'>Hosted BY: PRITISH YUVRAJ</p>";
echo"<p><i>Here you can create topics with the use of the left column and then </i> <b>All the members registered on this website</b> <i> can see and comment on it</i>
<ul><i><li>Just enter the topic name in the bottom-left box</li><li>Then choose an appropriate type in the next bar</li><li>Give the location of any picture if you wish to enter</li><li>Now hit the Create button</li></ul>
</i><hr><b>For viewing created topics</b><ul><li><i>Just hit oder by button</li><li>Now press the topic of your choice</li></ul></i><hr>";
echo"<i>Your IP address is:</i><b>".$_SERVER["REMOTE_ADDR"]."</b><br><i>And your Port No is:</i><b>".$_SERVER["REMOTE_PORT"]."</b><br><b><i>SO Kindly act responsibly!</i></b>";
echo"</td></tr>";
}
?>



</body>
</html>

<?php

function test_input($data)
{
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
}



$action=isset($_POST['action'])?$_POST['action']:null;



switch($action){

case 'create_topic':
{

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 4000000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("Website_Pictures/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "Website_Pictures/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "Website_Pictures/" . $_FILES["file"]["name"];
		$photo_add="Website_Pictures/".$_FILES["file"]["name"];
	 }
	 
    }
  }
else
  {
  echo "Invalid file";
  $photo_add=0;
  }

$topic_name5=$_POST["topic_name5"];
$topic_type=$_POST['category'];
$comments=$_POST["topic_comment"];
echo $topic_name5;
		$up_cen_tb="INSERT INTO cen_dis_topic(usn,topics,topic_name,comments,photo)
		VALUES('$userid','$topic_type','$topic_name5','$comments','$photo_add')";
	if(!mysqli_query($con_central,$up_cen_tb))
	{
	echo "Could not register users topic".mysqli_error($con_princi_db2);
	}
	else
	{
	echo"";	
	}
$create_table_name="CREATE TABLE $topic_name5 
	(unique_no INT NOT NULL AUTO_INCREMENT,usn CHAR(30)
	,comments_usn VARCHAR(1000),likes INT DEFAULT 0,PRIMARY KEY(unique_no))";
	if(!mysqli_query($con_central,$create_table_name))
	{
	echo "<br>not create table".mysqli_error($con_princi_db4);
	}
	else
	{
	echo "Sucessfully created the table";
	$insert_table_nm="INSERT INTO $topic_name5 (usn,comments_usn)
	VALUES('$userid','$comments')";
	if(!mysqli_query($con_central,$insert_table_nm))
	{
	echo "<br>".mysqli_error($con_princi_db5);
	}
	else
	{	
	echo" sucessfully created all tables";

	$drw_al_usn="SELECT usn FROM registered_members";
	$drwing1=mysqli_query($con_central,$drw_al_usn);
	$usn_all_n=array();	
$a2=0;	
	while($row25=mysqli_fetch_assoc($drwing1))
	{
	$usn_all_n[]=$row25['usn'];
	$a2++;
	}
foreach($usn_all_n as $value)
{

$noti="INSERT INTO notification(type,from_usn,status,to_usn)
	VALUES(4,'$userid',0,'$value')";
if(!mysqli_query($con_central,$noti))
{
echo"could not write into".mysqli_error($con_to);
}
}
	}
	}
$topic_likes=$topic_name5."likes";
echo $topic_likes;
	$create_likes="CREATE TABLE $topic_likes (unique_no INT ,
		usn CHAR(30), PRIMARY KEY(`unique_no`,`usn`))";
	
	if(!mysqli_query($con_central,$create_likes))
	{
	echo "<br>".mysqli_error($con_princi_db4);
	}	
	
	
		
break;
}

case 'sv_cmmts': {
	
	$comments_by_user=test_input($_POST["tops_comments"]);
	$table=$_SESSION['topic_n_gl'];
	echo $comments_by_user;
		$inserting_comments="INSERT INTO $table(usn,comments_usn) VALUES
			('$userid','$comments_by_user')";
	$to_gen_uid="SELECT unique_no FROM $table ORDER BY unique_no LIMIT 1";	
	
	if(!mysqli_query($con_central,$inserting_comments))
	{
	echo"Cannot insert into comments".mysqli_error($con_database9);
	}
	
	$generating_uid=mysqli_query($con_central,$to_get_uid);
	$uniq=array();
	while($row15=mysqli_fetch_assoc($generating_uid))
	{
	$uniq[]=$row15['unique_no'];
	}
	$table_fr_likes=$table."likes";
	$in_likes="INSERT INTO $table_fr_likes (usn)
		VALUES('$userid')";
	if(!mysqli_query($con_central,$in_likes))
	{
	echo"wrong input".mysqli_error($con_database9);
	}
	else
	{
	header('Location:discussion_topic.php');
	}
break;
}

case 'like_alog': {
	$tb_n=$_SESSION['topic_n_gl'];
	$tb_n_d=$tb_n."likes";
	$one_like=$_POST["like"];
	
	echo "<h1 style='color:red;'>".$one_like." ".$tb_n_d." ".$one_like."</h1>";
$lik_in_com="INSERT INTO $tb_n_d (unique_no,usn) VALUES('$one_like','$userid')";
	$like_plus_one="UPDATE $tb_n SET likes=likes+1 WHERE unique_no='$one_like'";
	if(!mysqli_query($con_central,$lik_in_com))
	{
	echo"insertion".$one_like." ".$tb_n_d.mysqli_error($con_db25);
	}
	else
	{
	if(!mysqli_query($con_central,$like_plus_one))
		{
		echo"didnt go to hell?".mysqli_error($con_db25);
		}
	else
	{
	header('Location:discussion_topic.php');
	}	

	}
	

break;
}
default:
{
echo " ";
}
}
?>