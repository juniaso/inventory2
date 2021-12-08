<?php
include("connection.php");

if($_POST['data_type']=='last_num'){
	
	$barcode = $_POST['barcode'];
	$last_num = '-';
	
	$get_last_number = mysqli_query($con,"SELECT * from barcode_group where `barcode_number` = '$barcode'");
	$gln = mysqli_fetch_array($get_last_number);
	
	if($gln['last_number']!=""){
		
		$last_num = $gln['last_number'];
		
	}
	
	echo $last_num;
	
}


?>