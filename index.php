<?php
error_reporting(0);
session_start();
$con=mysqli_connect("localhost","pritish","12345","jharin_pritish");
if(mysqli_connect_errno())
{
echo"Failed to connect to server! Because".mysqli_connect_error();
}
if(isset($_SESSION["registered"]) && $_SESSION["counting"]==0)
{
echo" ".$_SESSION["registered"];
$_SESSION["counting"]=$_SESSION["counting"]+1;
}

if(!(isset($_SESSION['times1'])))
{
$_SESSION['times1']=0;
}
$g=$_SESSION['times1'];
if(isset($_COOKIE['userid']) && isset($_COOKIE['password']))
{
	$_POST['action']="login";
}
if((isset($_SESSION["message"])) && $g==0)
{
echo"<h3 style='color:red;'>".$_SESSION['message'];
$g++;
}
$_SESSION['times1']=$g;;
?>
<html>
<head>
<meta name="description" content="Byte-me">
<meta name="keywords" content="Pritish Yuvraj Enterprises,Bangalore Institute of Technology,Daring Northies">
<meta name="author" content="Pritish Yuvraj">
<link rel="shortcut icon" href="Website_Pictures/now.ico" >
<link rel="stylesheet" type="text/css" href="daring_northies.css">
<title>Byte-me!</title>
<script>

function validate_signup()
{
var name,usn,pass,repass,email,phone;
name=document.forms["signup"]["name"].value;
usn=document.forms["signup"]["usn"].value;
pass=document.forms["signup"]["password"].value;
repass=document.forms["signup"]["repass"].value;
email=document.forms["signup"]["email"].value;
phone=document.forms["signup"]["phone"].value;

if(name==null||name==""||strcmp(name,"name"))
{
	alert("Please enter Name in SIGNUP Field!");
	return false;
}
if(pass==null||pass=="")
{
	alert("Please enter the Password in SIGNUP Field!");
	return false;
}
if(repass==null||repass=="")
{
	alert("Please enter Repassword in SIGNUP Field!");
	return false;
}
if(email==null||email=="")
{
	alert("Please enter Email in SIGNUP Field!");
	return false;
}
if(phone==null||phone==""||strcmp(phone,"Phone Number"))
{
	alert("Please enter Phone Number in Signup Field!");
	return false;
}
}
</script>

<script>
function validate_my_form()
{
var name,pass;
name=document.forms["login"]["userid"].value;
pass=document.forms["login"]["password"].value;

if(name==null||name=="")
{
	alert("Please enter User ID in Login Field!");
	return false;
}
if(pass==null||pass=="")
{
	alert("Please enter the Password in login Field!");
	return false;
}

}

</script>
</head>

<body background="Website_pictures/agra_fort_india-normal.jpg" style="background-size: 100%;">
<table align="center" border="0" width="1000" height="85%">

<tr class="header1">

<td class="header1"><img src="Website_pictures/2723-be-daring-be-different-be-impractical-be-yourself.png"></td>

<td class="header2" style="text-align:left;">

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" style="color:white;" name="login" onsubmit="return validate_my_form();">

LoginId(USN):<input type="text" name="userid">
Password:<input type="password" name="password">
<input type="hidden" name="action" value="login">

<input type="submit" value="LOGIN">
Remember me:
<input type="checkbox" name="remember" value="YES">

</form>
</td>

</tr>

<tr>

<td colspan="2">

<form class="singup" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data"
				name="signup" onsubmit="return validate_signup();">
<br><br>
<ul class="try">
<i><b><u>All columns are to be filled</u></b></i>
<li><input type="text" name="name" maxlength="30" placeholder="Enter Your Name"></li><?php echo $n1; ?>
<li><input type="text" name="usn" maxlength="10" placeholder="Enter Your USN:"></li><?php echo $u1; ?>
<li><input type="password" name="password" maxlength="10" placeholder="Password"><i></li><?php echo $p1; ?>
<li><input type="password" name="repass" maxlength="10" placeholder="Re-Enter Password"></i></li>
<li><input type="email" name="email" maxlength="30" placeholder="Enter your Email"></li>
<li><input type="tel" placeholder="Phone Number" name="phone"></li><?php echo p1 ?>
<br><li>Upload your Cute Profile Pic:</li>
<input type="file" name="file" id="file" placeholder="Photo Location">
<li>Are u Single?:<input type="checkbox" name="whatsapp" value="YES"><br><i>By clicking you agree to use 'CHAT WITH SINGLES' feature</i></li>
<li>Semester:<select name="room_no">
<option value="1">1st</option>
<option value="2">2nd</option>
<option value="3">3rd</option>
<option value="4">4th</option>
<option value="5">5th</option>
<option value="6">6th</option>
<option value="7">7th</option>
<option value="8">8th</option>
</select></li>


<li><select name="branch">
<option value="computer science and engineering">Computer Science & Engineering</option>
<option value="electrical and electronics engineering">Electrical & Electronics Engineering</option>
<option value="electronics and communication engineering">Electronics & communication Engineering</option>
<option value="mechanical engineering">Mechanical Engineering</option>
<option value="civil engineering">Civil Engineering</option>
<option value="information science and engineering">Information Science & Engineering</option>
<option value="instrumentation technology and engineering">Instrumentation Technology & Engineering</option>
<option value="telecommunication engineering">Telecommunication Engineering</option>
<option value="industrial engineering and managment">Industrial Engineering & Managment</option>
</select></li>
<input type="hidden" value="signup" name="action">

<input type="Submit" value="SIGNUP">

</td></tr>
<tr>
<td colspan="2">
<h1 style="text-align:center; color:white;"><b><i><u>Byte-me</u></i></b></h1>
<p style="text-align:right; color:align; font-size:125%;">
<a style='color:white;' href="https://www.facebook.com/pritish.yuvraj"><b>Developer: Pritish Yuvraj<br>Contact NO: 9620287432</b></p>
</td>
</tr>
</table>
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

case 'login':
{
	if(isset($_COOKIE['userid']) && isset($_COOKIE['password']))
	{
	$user_id=$_COOKIE['userid'];	
	$password=$_COOKIE['password'];
	echo"<h1 style='color:red;'>"."Hello i m in";
	}
	else
	{
	$user_id=test_input($_POST['userid']);
	$password=test_input($_POST['password']);
	}
	
	if(isset($_POST["remember"]))
	{
	setcookie("userid",$user_id,time()+60*60*24*7);
	setcookie("password",$password,time()+60*60*24*7);
	}	
$_SESSION["frip"]=0;
	$query_login="SELECT usn FROM registered_members WHERE usn='$user_id' AND password='$password'";
$Logging_in=mysqli_query($con,$query_login);
	while($row=mysqli_fetch_assoc($Logging_in))
	{
	$_SESSION['userid']=$user_id;
	header('Location:my_profile.php');
	}
	echo"<h2 style='color:white;'>User entered invalid username or password</h2>";
	break;
}

case 'signup':
{
$email=test_input($_POST['email']);
$whatsapp=$_POST['whatsapp'];
$room_no=$_POST['room_no'];
$branch=$_POST['branch'];	
$cmp1=strcmp($_POST['name'],"name");
$cmp2=strcmp($_POST['usn'],"1BI13");
$cmp3=strcmp($_POST['password'],$_POST['repass']);
$cmp4=strcmp($_POST['phone'],"Phone Number");
	if($cmp1!=0 && (isset($cmp1)))
	{
	$name=test_input($_POST['name']);
	}
	else
	{
	$n1="Enter a valid name";
	}

	if($cmp2!=0 && (isset($cmp2)))
	{
	$usn=test_input($_POST['usn']);
	}
	else
	{
	$u1="Enter a valid USN";
	}
	
	if($cmp3==0 && (isset($cmp3)))
	{
	$password=test_input($_POST['password']);
	}
	else
	{
	$p1="Password and Re-entered password columns do not match!";
	}

	if($cmp4!=0 && (isset($cmp4)))
	{
	$tel=test_input($_POST['phone']);
	}
	else
	{
	$n1="Wrong phone Number entered";
	}
		
//Photo Upload algorithm

$usn=$_POST['usn'];
mkdir($usn);
copy('Website_Pictures/redirect.php',$usn.'/index.php');
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 2000000)
&& in_array($extension, $allowedExts))
  {
  $size = 50; // the thumbnail height

	$filedir =$usn.'/'; // the directory for the original image
	$thumbdir =$usn.'/'; // the directory for the thumbnail image
	$prefix = 'thumbsup_'; // the prefix to be added to the original name

	$maxfile = '2000000';
	$mode = '0666';
	
	$userfile_name = $_FILES["file"]["name"];
	$userfile_tmp = $_FILES["file"]["tmp_name"];
	$userfile_size = $_FILES["file"]["size"];
	$userfile_type = $_FILES["file"]["type"];
	
	if (isset($_FILES["file"]["name"])) 
	{
		$prod_img = $filedir.$userfile_name;

		$prod_img_thumb = $thumbdir.$prefix.$userfile_name;
		move_uploaded_file($userfile_tmp, $prod_img);
		chmod ($prod_img, octdec($mode));
		
		$sizes = getimagesize($prod_img);

		$aspect_ratio = $sizes[1]/$sizes[0]; 

		if ($sizes[1] <= $size)
		{
			$new_width = $sizes[0];
			$new_height = $sizes[1];
		}else{
			$new_height = $size;
			$new_width = abs($new_height/$aspect_ratio);
		}

		$destimg=ImageCreateTrueColor($new_width,$new_height)
			or die('Problem In Creating image');
		$srcimg=ImageCreateFromJPEG($prod_img)
			or die('Problem In opening Source Image');
		if(function_exists('imagecopyresampled'))
		{
			imagecopyresampled($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg))
			or die('Problem In resizing');
		}else{
			Imagecopyresized($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg))
			or die('Problem In resizing');
		}
		ImageJPEG($destimg,$prod_img_thumb,90)
			or die('Problem In saving');
		imagedestroy($destimg);
  
       $profile_pic_location=$prod_img;
	$thumbnails=$prod_img_thumb;
	  }
  }
  
else
  {
  echo"Invalid photo upload";
  }
$sql_regestring_princi_db="INSERT INTO registered_members
(usn,name,password,email,phone,whatsapp,roomno,branch,thumbnails,photo_add)VALUES
('$usn','$name','$password','$email',$tel,'$whatsapp',$room_no,'$branch','$prod_img_thumb','$profile_pic_location')";

if(!mysqli_query($con,$sql_regestring_princi_db))
{
echo"<span style='color:white;'>Failed to create user account try different usn or email</span>";     //line 128
}
else
{
	$photo=$usn."photo_add_self";
	$photos=mysqli_query($con,"CREATE TABLE $photo (unique_no INT NOT NULL AUTO_INCREMENT,photo_add VARCHAR(255),usn CHAR(30),
						thumbnails CHAR(80),location CHAR(80),caption varchar(1000),PRIMARY KEY(unique_no))");
	$query8="INSERT INTO $photo(photo_add,usn,thumbnails) VALUES ('$profile_pic_location','$usn','$thumbnails')";
	if(!mysqli_query($con,$query8)){ 
	echo"";
	}
	else{
	echo"<h1 style='color:white;'><i>User Successfully registered!Please login</i></h1>";
	$friends=$usn."my_friends";
	$sql_friends=mysqli_query($con,"CREATE TABLE $friends
	(usn CHAR(30) UNIQUE NOT NULL,friendship_status INT,own_usn CHAR(30),foreign_entry INT,PRIMARY KEY(usn),time CHAR(30))");
	/*
1. For photo
2. For comments
3. For Friendship
4. For Rejection
*/	
	$comments=$usn."self_comments";
	$wall=mysqli_query($con,"CREATE TABLE $comments(usn CHAR(30),unique_no INT,foreign_usn CHAR(30),type CHAR(30),comment VARCHAR(255),time char(30))");
	}	
}
$_SESSION["registered"]="USER SUCESSFULLY REGISTERED TO LITERATI";
$_SESSION["counting"]=0;
break;
}
default:
{
echo" ";
break;
}
}
?>