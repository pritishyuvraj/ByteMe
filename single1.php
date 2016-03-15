<html>
<body>
<a href="single.php">Refresh</a><br>
<a href="logout.php">Logout</a><br>
<a href="my_profile.php">My Profile</a><br>
<?php
$a=0;
session_start();
if(!isset($_SESSION["count"])){
$_SESSION["count"]=0;
}
$userid=$_SESSION["userid"];

$con_central=mysqli_connect("localhost","root","","principal_database");
$swing_mood=mysqli_query($con_central,"UPDATE active_user SET chatted=1 WHERE usn='$userid'");
$query_entire=mysqli_query($con_central,"SELECT usn,name,photo 
			FROM active_user WHERE relationship='YES' AND chatted=1");
$entire=array(array());
while($row1=mysqli_fetch_row($query_entire)){
for($i=0;$i<3;$i++){
$entire[$a][$i]=$row1[$i];
}
$enitre[$a][3]=$i;
$a++;
}
for($i=0;$i<$a;$i++){
if($entire[$i][0]==$userid)
{
$my_no=$i;
break;
}
}
echo"<h1 style='color;red;'>".$a."</h1>";

echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
<input type='submit' name='action' value='Wanna chat with singles??????'>
</form>";

if(isset($_SESSION["no"]) && $_SESSION["no"]!=$my_no){
$no=$_SESSION["no"];
$stranger_usn=$entire[$no][0];
do{
echo"I m in again";
$change_status="UPDATE active_user SET chatted=2 WHERE usn='$userid' OR usn='$stranger_usn'";
if(!mysqli_query($con_central,$change_status)){
echo"problem changing status".mysqli_error($con_central);
}
else{
echo"I m done with my work";
}
echo"<h2><sup>".$entire[$my_no][0]."   ".$entire[$my_no][1]."</sup><img src=".$entire[$my_no][2]." width='100' height='140'>";
echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
	<input type='Submit' name='start2' value='Chattiyae'>
	</form></h2>";
	echo"<br><h1>Lo chatiyao isse<sup style='color:red;'>".$entire[$no][0]." ".$entire[$no][1]."</sup><img src=".$entire[$no][2]." 
width='100' height='140'></h1>";
echo"<form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='post'>
	<input type='submit' name='chat' value='chat here'>
	<input type='submit' name='decision' value='YES'>
	</form>";
}while($_POST["decision"]=='YES');
}


?>
</body>
</html>
<?php
$action=isset($_POST["action"])?$_POST["action"]:NULL;
switch($action){
case 'Wanna chat with singles??????':{

if($a>1){
do{
$no=rand();
$no=(int)($no%$a);
}while($no==$my_no);
$_SESSION["no"]=$no;
}
header('Location:single.php');
break;
}
default:{
echo"";
break;
}
}

?>