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
$create_likes="CREATE TABLE '$topic_name'.likes (unique_no CHAR(30) 
	NOT NULL,usn CHAR(30),likes INT DEFAULT 0, PRIMARY KEY('unique_no',
	'$userid')";

$topic_name=test_input($_POST['topic_name']);
$topic_type=$_POST['category'];
$comments=test_input($_POST['topic_comment']);

	$con_princi_db2=mysqli_connect("localhost","root","","principal_database");
	$up_cen_tb="INSERT INTO cen_dis_topic(usn,topics,topic_name,comments)
		VALUES('$userid','$topic_type','$topic_name','$comments')";
	if(!mysqli_query($con_princi_db2,$up_cen_tb))
	{
	echo "Could not register users topic".mysqli_error($con_princi_db2);
	}
	else
	{
	echo"done";	
	}


	$con_princi_db4=mysqli_connect("localhost","root","","principal_database");
	$create_table_name="CREATE TABLE '$topic_name' 
	(unique_no NOT NULL AUTO_INCREMENT,usn,comments_usn,PRIMARY KEY(unique_no)";
	if(!mysqli_query($con_princi_db4,$create_table_name))
	{
	echo "not create table".mysqli_error($create_table_name);
	}
	else
	{
	echo "Sucessfully created the table";
	}

	$con_princi_db5=mysqli_connect("localhost","root","","principal_database");
	$insert_table_nm="INSERT INTO '$topic_name'(usn,comments_usn)
	VALUES('$userid','$comments')";
	if(!mysqli_query($con_princi_db5,$insert_table_nm))
	{
	echo mysqli_error($con_princi_db5);
	}
	else
	{	
	
	}

	
	if(!mysqli_query($con_princi_db5,$create_likes))
	{
	echo mysqli_error($con_princi_db6);
	}	
	
	
		
break;
}

default:
{
echo $userid;
}

}

?>