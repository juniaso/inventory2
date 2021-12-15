<?php
	include("connection.php");

?>	
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Page 4 - Barcode List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
  <script src="html2canvas.js"></script>
  
  <style>
/* Add a black background color to the top navigation */
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
}
  #display {
    text-align:center;
  }
  
 
  div#display {
    display: block;
    height: 100%;
    width: 100%;
    align-items: center;
}
@media print{
  div#display {
    display: block;
    height: auto;
    width: 500px;
    align-items: center;
}

.print {page-break-after:always;}
}
#display #field,#display center {
    margin: auto;
}
#field img{
    height: 9vh;
    max-width: 100%
}
div#code {
    font-weight: 700;
    font-size: 17px;
    text-align: justify;
    text-align-last: justify;
}
</style>
  <script>
$(document).ready(function(e) {
	
	
	var barcode_number = $("#barcode_num").val();
	
	last_num(barcode_number);
	
  
  $(document).on("change","#barcode_num",function() {
	
	var barcode_number = $(this).val();
	
	last_num(barcode_number);
	
	});	


function last_num(barcode){
	
	 $.ajax({
        url: "functions.php",
        dataType:"html",
        data: {
            data_type:'last_num',
			barcode: barcode,
		} ,
        type: "post",
		beforeSend: function()
		{
			$("#last_num").html('<i class="fa fa-spinner fa-spin"></i>');
		},
        success: function(res){
           $("#last_num").val(res);
		   $("#last_num_span").html(res);
        }
    });
	
}





 $('#save').click(function(){
    html2canvas($('#field'), {
    onrendered: function(canvas) {  
	
      var img = canvas.toDataURL("image/png");
      
      var uri = img.replace(/^data:image\/[^;]/, 'data:application/octet-stream');
      
      var link = document.createElement('a');
          if (typeof link.download === 'string') {
              document.body.appendChild(link); 
              link.download = 'barcode_'+$('#code').val()+'.png';
              link.href = uri;
              link.click();
              document.body.removeChild(link);
          } else {
              location.replace(uri);
          }
      
    }
  }); 
  })
$('#print').click(function(){
      var openWindow = window.open("", "", "_blank");
      openWindow.document.write($('#display').parent().html());	  
      openWindow.document.write('<style>'+$('style').html()+'</style>');
      openWindow.document.close();
      openWindow.focus();
      openWindow.print();
      // openWindow.close();
      setTimeout(function(){
      openWindow.close();
      },1000)
    })
});	

function generate(code){
	
	type = 'C128';
	label = '';
	
    if(code != ''){
      $.ajax({
        url:'barcode.php',
        method:"POST",
        data:{code:code,type:type,label:label},
        error:err=>{
          console.log(err)
        },
        success:function(resp){
          $('#display').append(resp);
		  $('.card-footer').show('slideUp')
          
        }
      })
    }
}
</script>  
</head>
<body>

<div class="container" style="width:700px;">
  <h2>Barcode List</h2>
  <br>
  <form action="#" method="POST">
    <div class="form-group">
      <label>Barcode Group Number:</label>
	  <select class="form-control" name="barcode_num" id="barcode_num">
		<?php
		$barcode_group_numbers = mysqli_query($con,"SELECT * from barcode_group");
		while($bgn = mysqli_fetch_array($barcode_group_numbers)){
			echo '<option value="'.$bgn['barcode_number'].'">'.$bgn['barcode_number'].'</option>';	
		}
		?>
	  </select>
    </div>
	
	<div class="form-group">
      <label for="barcodes">How Many Barcodes?</label>
      <input type="number" required class="form-control" value="1" id="vendor_code" placeholder="How Many Barcodes?" name="barcodes_qty">
    </div>
	
	<div class="form-group">
	<label>Last Number:</label>
	<input type="hidden" name="last_num" id="last_num">
	<h4><b><span id="last_num_span">-</span></b></h4>
    </div>
    
    <button type="submit" name="btn_submit" class="btn btn-success">Generate Next</button>
  </form>
  <br>

<?php
	if(isset($_POST['btn_submit'])){
		
		$barcode_num = $_POST['barcode_num'];
		$last_num = $_POST['last_num'];
		$barcodes_qty = $_POST['barcodes_qty'];
		$seq;$success=0;
		
		if(empty($barcode_num)){
			echo '<div class="alert alert-danger">
				<strong>Alert!</strong> Please select Barcode Group Number First!
				</div>';
				die();
		}
		
		
		for($i=1;$i<=$barcodes_qty;$i++){
		if($last_num=='-'){
			
			$seq = 1;
			
		}
		else{
			$last_seq = str_replace($barcode_num, "",$last_num);
			$seq = $last_seq + 1;
		
		}
		
		$new_barcode_num = $barcode_num . $seq;
		$last_num = $new_barcode_num;
		
		
		
		$check_num = mysqli_query($con,"SELECT * from barcode_list where barcode_numer = '$new_barcode_num' && barcode_group_id = '$barcode_num'");
		$cn = mysqli_fetch_array($check_num);
			if($cn){
				echo '<div class="alert alert-danger">
				<strong>Alert!</strong> '.$new_barcode_num.' Barcode already created! Refresh page and try again!.
				</div>';
				continue;
			}		
		
		
		$insert_query = mysqli_query($con,"INSERT INTO `barcode_list`(`barcode_numer`, `barcode_group_id`) VALUES ('".$new_barcode_num."','".$barcode_num."')");
		
		if($insert_query){
			
			$update_lastnum_query = mysqli_query($con,"UPDATE `barcode_group` SET `last_number`= '".$new_barcode_num."' where barcode_number = '".$barcode_num."'");
			
			echo '<input type="hidden" value="'.$new_barcode_num.'" id="code">'; 	  
			?>
			<script>
			generate(<?php echo "'".$new_barcode_num."'" ?>)
			</script>
			<?php
			$success = 1;
			
		}
		
		else{
			$success = 0;
			
		}
		}
		
		if($success == 1){
			echo '<div class="alert alert-success">
				  <strong>Success!</strong> New Barcode added successfully.
				  </div>';
			
		}
		else{
			
			echo '<div class="alert alert-danger">
			<strong>Error!</strong> Barcode adding failed due to unknown reason.
			</div>';
			
		}
		
	}
?>

<div style="text-align:center;">
<div class="" id='bcode-card' style="width:300px;margin:auto;">
            <div class="card-body">
              <div id="display"></div>
			</div>
<div class="card-footer" style="display:none;">
              <center>
                <button type="button" class=" btn-block btn btn-success btn-sm" id="print">Print</button>
              <button type="button" class=" btn-block btn btn-primary btn-sm" id="save">Download</button>  
              </center>
              
            </div>
</div>
</div>
</body>
</html>
