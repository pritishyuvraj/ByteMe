<?php
error_reporting(0);
$a=0;
$mydate=getdate(date("U"));
$un_time=time();
$day=$mydate[mday];
$month=$mydate[month];
$year=$mydate[year];
$hour=$mydate[hours];
$min=$mydate[minutes];
$sec=$mydate[seconds];

$final_da_ti=$day." ".$month." ".$year." ".$hour." ".
		$min." ".$sec;

session_start();
$userid=$_SESSION['userid'];
$con=mysqli_connect("localhost","pritish","12345","jharin_pritish");
$write_log_out="UPDATE ip_add SET logout_time='$final_da_ti',unfort_log='$un_time'	WHERE usn='$userid'";
$write_active_user="DELETE FROM active_user WHERE usn='$userid'";
if(!mysqli_query($con,$write_active_user)){
echo"Could not delete from active user";
}
else{
$a++;
}
if(!mysqli_query($con,$write_log_out)){
echo"could not log_out from main directory".mysqli_error($con);
}
else{
$a++;
}
if($a==2){
$_SESSION['userid']="";
setcookie("userid","",time()-3600);
setcookie("password","",time()-3600);
$_SESSION['message']="USER LOGGED OUT";
$_SESSION['times1']=0;
header('Location:index.php');
}
?>