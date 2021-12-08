<?php
	
	$dbhost = "localhost";
	$dbuser = "goodang";
	$dbpass = "goodang@123";
	$dbname = "goodang";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
	die("failed to connect");
}

