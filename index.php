<!DOCTYPE html>
<html lang="en">
<head>
  <title>Page 1 - Vendor</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
	
	<div class="container" style="width:700px;">
	<style> /* Add a black background color to the top navigation */
.topnav {
  background-color: #333;
  overflow: hidden;
}

/* Style the links inside the navigation bar */
.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Add a color to the active/current link */
.topnav a.active {
  background-color: #04AA6D;
  color: white;
}</style>
  <h2>
    <header>
      <div class="topnav">
  <a class="active" href="/public/uploads/barcode2/index.php">Vendor Master</a>
  <a href="/public/uploads/barcode2/page2.php">PO Master</a>
  <a href="/public/uploads/barcode2/page3.php">Barcode Group</a>
  <a href="/public/uploads/barcode2/page4.php">Barcode Print</a>
</div></header>
	  <br><br>
<body>


  Vendor</h2>
  <br>
  <form action="#" method="POST">
    <div class="form-group">
      <label for="vendor">Vendor:</label>
      <input type="text" required class="form-control" value="<?php echo isset($_POST['vendor']) ? $_POST['vendor']:''; ?>" id="vendor" placeholder="Enter Vendor Name" name="vendor">
    </div>
    <div class="form-group">
      <label for="vendor_code">Vendor Code:</label>
      <input type="text" required class="form-control" value="<?php echo isset($_POST['vendor_code']) ? $_POST['vendor_code']:''; ?>" id="vendor_code" placeholder="Enter Vendor Code" name="vendor_code">
    </div>
    
    <button type="submit" name="btn_submit" class="btn btn-success">Submit</button>
  </form>
  <br>

<?php
	include("connection.php");
	if(isset($_POST['btn_submit'])){
		
		$vendor = $_POST['vendor'];
		$vendor_code = $_POST['vendor_code'];
		
		$check_name = mysqli_query($con,"SELECT * from vendor_master where vendor = '$vendor'");
		$cn = mysqli_fetch_array($check_name);
		
		if($cn){
			echo '<div class="alert alert-danger">
			<strong>Alert!</strong> Vendor Name already exists! Try with other Vendor Name.
			</div>';
			die();
		}
		
		$check_code = mysqli_query($con,"SELECT * from vendor_master where code = '$vendor_code'");
		$cc = mysqli_fetch_array($check_code);
		
		if($cc){
			echo '<div class="alert alert-danger">
			<strong>Alert!</strong> Vendor Code already exists! Try with other Vendor Code.
			</div>';
			die();
		}
		
		$insert_query = mysqli_query($con,"INSERT INTO `vendor_master`(`vendor`, `code`) VALUES ('".$vendor."','".$vendor_code."')");
		
		if($insert_query){
			echo '<div class="alert alert-success">
				  <strong>Success!</strong> New Vendor added successfully.
				  </div>';
		}
		else{
			echo '<div class="alert alert-danger">
			<strong>Error!</strong> Vendor adding failed due to unknown reason.
			</div>';
		}
		
	}
?>
</div>
</body>
</html>
