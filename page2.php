<!DOCTYPE html>
<html lang="en">
<head>
  <title>Page 2 - PO</title>
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
    <header><div class="topnav">
  <a href="/public/uploads/barcode2/index.php">Vendor Master</a>
  <a class="active" href="/public/uploads/barcode2/page2.php">PO Master</a>
  <a href="/public/uploads/barcode2/page3.php">Barcode Group</a>
  <a href="/public/uploads/barcode2/page4.php">Barcode Print</a>
</div></header>
	  <br><br>
<body>

<div class="container" style="width:700px;">
  <h2>PO Details</h2>
  <br>
  <form action="#" method="POST">
    <div class="form-group">
      <label for="po_num">PO Number:</label>
      <input type="text" required class="form-control" value="<?php echo isset($_POST['po_num']) ? $_POST['po_num']:''; ?>" id="po_num" placeholder="Enter the PO Number" name="po_num">
    </div>
    <div class="form-group">
      <label for="po_date">PO Date:</label>
      <input type="date" required class="form-control" value="<?php echo isset($_POST['po_date']) ? $_POST['po_date']:''; ?>" id="po_date" placeholder="Select Date" name="po_date">
    </div>
	<div class="form-group">
      <label for="cost">Cost:</label>
      <input type="number" required class="form-control" value="<?php echo isset($_POST['cost']) ? $_POST['cost']:''; ?>" id="cost" placeholder="Enter Cost" name="cost">
    </div>
    
    <button type="submit" name="btn_submit" class="btn btn-success">Submit</button>
  </form>
  <br>

<?php
	include("connection.php");
	if(isset($_POST['btn_submit'])){
		
		$po_num = $_POST['po_num'];
		$po_date = $_POST['po_date'];
		$cost = $_POST['cost'];
		
		$check_num = mysqli_query($con,"SELECT * from po_master where po = '$po_num'");
		$cn = mysqli_fetch_array($check_num);
		
		if($cn){
			echo '<div class="alert alert-danger">
			<strong>Alert!</strong> PO Number already exists! Try with other PO Number.
			</div>';
			die();
		}
		
		
		$insert_query = mysqli_query($con,"INSERT INTO `po_master`(`po`, `date`, `cost`) VALUES ('".$po_num."','".$po_date."','".$cost."')");
		
		if($insert_query){
			echo '<div class="alert alert-success">
				  <strong>Success!</strong> New PO added successfully.
				  </div>';
		}
		else{
			echo '<div class="alert alert-danger">
			<strong>Error!</strong> PO adding failed due to unknown reason.
			</div>';
		}
		
	}
?>
</div>
</body>
</html>
