<?php
	include("connection.php");
?>	
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Page 3 - Barcode Group</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
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
  <a href="/public/uploads/barcode2/page2.php">PO Master</a>
  <a class="active" href="/public/uploads/barcode2/page3.php">Barcode Group</a>
  <a href="/public/uploads/barcode2/page4.php">Barcode Print</a>
</div></header>
	  <br><br>
<div class="container" style="width:700px;">
  <h2>Barcode Group</h2>
  <br>
  <form action="#" method="POST">
    <div class="form-group">
      <label for="vendor_code">Vendor Code:</label>
	  <select class="form-control" name="vendor_code">
		<?php
		$vendor_codes = mysqli_query($con,"SELECT * from vendor_master");
		while($vc = mysqli_fetch_array($vendor_codes)){
			echo '<option value="'.$vc['code'].'">'.$vc['vendor'].'</option>';	
		}
		?>
	  </select>
    </div>
    <div class="form-group">
      <label for="po_num">PO Number:</label>
	  <select class="form-control" name="po_num">
		<?php
		$po_nums = mysqli_query($con,"SELECT * from po_master");
		while($pn = mysqli_fetch_array($po_nums)){
			
						$po_num = $pn['po'];
									
									$check_num = mysqli_query($con,"SELECT * from barcode_group where po_id = '$po_num'");
									$cn = mysqli_fetch_array($check_num);
												if($cn){
																	continue;
																				}
												
												echo '<option value="'.$pn['po'].'">'.$pn['po'].'</option>';	
											}
				?>
	  </select>
    </div>
	
	<div class="form-group">
		<label for="retail">Retail:</label>
		<label class="radio-inline"><input type="radio" name="retail" value="Y" checked>Yes</label>
		<label class="radio-inline"><input type="radio" name="retail" value="N">No</label>
	</div>	
    
    <button type="submit" name="btn_submit" class="btn btn-success">Submit</button>
  </form>
  <br>

<?php
			if(isset($_POST['btn_submit'])){
						
						$vendor_code = $_POST['vendor_code'];
								@$po_num = $_POST['po_num'];
								$retail = $_POST['retail'];
										
										if(empty($vendor_code) || empty($po_num)){
														echo '<div class="alert alert-danger">
																			<strong>Alert!</strong> Please select Vendor Code and PO number First!
																							</div>';
				die();
		}
										
										$barcode_number = $vendor_code . $po_num;
										
										$check_num = mysqli_query($con,"SELECT * from barcode_group where po_id = '$po_num'");
													$cn = mysqli_fetch_array($check_num);
													if($cn){
																		echo '<div class="alert alert-danger">
																							<strong>Alert!</strong> Barcode Group for PO Number already exists! Try with other PO Number.
																											</div>';
				die();
			}
															
															
															$insert_query = mysqli_query($con,"INSERT INTO `barcode_group`(`barcode_number`, `po_id`, `retail`, `vendor_code`) VALUES('".$barcode_number."','".$po_num."','".$retail."','".$vendor_code."')");
															
															if($insert_query){
																			echo '<div class="alert alert-success">
																								  <strong>Success!</strong> New Barcode Group added successfully.
																								  				  </div>';
		}
																	else{
																					echo '<div class="alert alert-danger">
																									<strong>Error!</strong> Barcode Group adding failed due to unknown reason.
																												</div>';
		}
																	
																}
?>
</div>
</body>
</html>
