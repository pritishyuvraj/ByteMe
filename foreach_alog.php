<?php
$z=0;
$y=0;
$con1=mysqli_connect("localhost","root","","1bi133");
$sql1="SELECT usn, name FROM my_friends WHERE friendship_status=1";
$ret1=mysqli_query($con1,$sql1);
$name1=array();
$usn1=array();
while($row1=mysqli_fetch_assoc($ret1))
{
$name1[]=$row1['name'];
$usn1[]=$row1['usn'];
$z++;
}
mysqli_close($con1);
$con2=mysqli_connect("localhost","root","","principal_database");
$sql2="SELECT usn,name FROM registered_members";
$ret2=mysqli_query($con2,$sql2);
$usn2=array();
while($row2=mysqli_fetch_assoc($ret2))
{
$usn2[]=$row2['usn'];
}
$photo1=array();
foreach($usn2 as $value)
{
for($a=0;$a<$z;$a++)
{
if($value==$usn1[$a])
{
$sql3="SELECT photo_add FROM profile_pic WHERE usn='$value'";
$ret3=mysqli_query($con2,$sql3);	

	while($row3=mysqli_fetch_assoc($ret3))
	{
	$photo1[]=$row3['photo_add'];
	}
}
}
}
$photo2=implode(",",$photo1);
?>
<html>
<body>


<?php
foreach($photo1 as $value)
{
echo"<img src='$value' width=220px height=350px/>";
}

?>
</body>
</html>