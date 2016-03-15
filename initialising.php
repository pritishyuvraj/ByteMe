<?php
error_reporting(0);
	$con_db=mysqli_connect("localhost","pritish","12345","jharin_pritish");
	$sql_table="CREATE TABLE registered_members
	(usn CHAR(30) NOT NULL,name CHAR(50),password CHAR(30),
	email CHAR(50) NOT NULL,phone CHAR(30), whatsapp CHAR(30),
	roomno INT, branch CHAR(50),thumbnails CHAR(80),photo_add CHAR(80),PRIMARY KEY(usn),UNIQUE(email))";

	if(!mysqli_query($con_db,$sql_table))
	{
		echo"Error connecting database".mysqli_error();
	}
	else
	{
		
	$ip_add="CREATE TABLE ip_add(usn CHAR(30),ip_add_agent CHAR(30),ip_add_port CHAR(30),
		login_time CHAR(30),logout_time CHAR(30) DEFAULT 0,login_date CHAR(30),unfort_log CHAR(30))";
	if(!mysqli_query($con_db,$ip_add))
	{
	echo"Could not create IP address table";
	}
	$sql_cen_tb="CREATE TABLE cen_dis_topic
	(usn CHAR(30), topics CHAR(30), topic_no INT NOT NULL AUTO_INCREMENT,
	topic_name CHAR(30),comments varchar(1000),photo CHAR(80),primary key(topic_no))";

	$sql_active="CREATE TABLE active_user (
	usn CHAR(30), name CHAR(30),ip_add CHAR(30), log_in CHAR(30),
	relationship CHAR(30),chatted CHAR(30),photo CHAR(30),PRIMARY KEY(usn))";
	if(!mysqli_query($con_db,$sql_active))
	{
	echo"not created any sucessful active page".mysqli_query($con_db);
	}
	
	$sql_chat="CREATE TABLE chat(usn_approach CHAR(30),usn_accept CHAR(30),message VARCHAR(1000),time CHAR(30))";
	if(!mysqli_query($con_db,$sql_chat)){
	echo"not created chat table".mysqli_query($con_db);
	}
	
	
	$chat_freinds=mysqli_query($con_db,"CREATE TABLE chat_friends(usn_own CHAR(30),usn_friend CHAR(30),time CHAR(30),
										chat VARCHAR(1000),unfort_time CHAR(30),seen INT DEFAULT 0)");
	
	/*
1 for Adding friends
2 for CHat Message
3 for Rejecttion
4 for Discussion Topics
5 for Photo Upload
*/
	$notification=mysqli_query($con_db,"CREATE TABLE notification (serial_no INT NOT NULL AUTO_INCREMENT, to_usn CHAR(30),type INT, from_usn 
	CHAR(30),from_branch CHAR(30),status INT, PRIMARY KEY(serial_no))");

	}
if(!mysqli_query($con_db,$sql_cen_tb))
	{
	echo"Couldnt not create table for common disscussion!".mysql_error($con_db);
	}
	else
	{
	header('Location:index.php');
	}

?>