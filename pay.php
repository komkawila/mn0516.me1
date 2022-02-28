<?php include 'includes/session.php'; ?>
<?php



	
	if(!isset($_SESSION['user'])){
		header('location: index.php');
	}
	$id = $_GET['pay_id'];
	$total = 0;
	$total_sales = 0;
	$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id LEFT JOIN sales ON sales.id=details.sales_id WHERE details.sales_id=$id");
		$stmt->execute(['id'=>$id]);
		foreach($stmt as $row){
		$subtotal = $row['price']*$row['quantity'];
		$total += $subtotal;
		$total_sales += $total;
	}

?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
				<?php
      
	  if(isset($_SESSION['error'])){
		echo "
		  <div class='alert alert-danger alert-dismissible'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<h4><i class='icon fa fa-warning'></i> ผิดพลาด!</h4>
			".$_SESSION['error']."
		  </div>
		";
		unset($_SESSION['error']);
	  }
	  if(isset($_SESSION['success'])){
		echo "
		  <div class='alert alert-info alert-dismissible'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<h4><i class='icon fa fa-check'></i> สำเร็จ!</h4>
			".$_SESSION['success']."
		  </div>
		";
		unset($_SESSION['success']);
	  }
	?>
	        		<div class="box box-solid">
	        			<div class="box-body">
							<?php
							$conn = $pdo->open();
							$stmt = $conn->prepare("SELECT * FROM  sales WHERE id=$id");
							$stmt->execute(['id'=>$id]);
							foreach($stmt as $row){
								
								$post_pay = $row['pay_id'] ;
								($post_pay == 0)?$post_pay="รอดำเนินการ":$post_pay = $row['pay_id'] ;

								$state_pay = $row['sales_state'] ;
								($state_pay == 0)?$state_pay="รอดำเนินการ":$state_pay = "ยืนยันชำระเงิน";

								?>
										 <div class="col-sm-3">
	        									<img src="<?php echo (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/no-image.jpg'; ?>" width="100%">
	        							</div>
										<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 text-left"><h4 style="font-weight: 700;">รายการชำระเงิน : <?php echo $id; ?><h4></div>
											<div class="col-sm-3">
												<h4>เลขบัญชีร้าน:</h4>
												<h4>ยอดรวม:</h4>
												<h4>สถานะ:</h4>
												<h4>เลขพัสดุ:</h4>
												<hr>
												<h4>ยอดที่ชำระ:</h4>
											</div>
											<div class="col-sm-9">
												<h4>กสิกร 999-9999-999
													<span class="pull-right">
														<a href="#edit" class="btn btn-success btn-flat btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Edit</a>
													</span>
												</h4>
												<h4><?php echo $total_sales ; ?> บาท</h4>
												<h4><?php echo $state_pay ?></h4>
												<h4><?php echo $post_pay ?></h4>
												<hr>
												<h4><?php echo $row['pay_amount'] ?> บาท</h4>
											</div>
										</div>
									</div>
								<?php } ?>
	        				
	        				
	        			</div>
	        		</div>
	        		<div class="box box-solid">
	        			<div class="box-header with-border">
	        				<h4 class="box-title"><i class="fa fa-calendar"></i> <b>รายการสินค้า</b></h4>
	        			</div>
	        			<div class="box-body">
	        				<table class="table table-bordered" id="example1">
									<thead>
									<th>ชื่อสินค้า</th>
									<th style="text-align: center;">ราคา</th>
									<th style="text-align: center;">จำนวน</th>
									<th style="text-align: center;">รวม</th>
									</thead>
	        					<tbody>
	        					<?php
	        						$conn = $pdo->open();
									$total = 0;
									$total_sales = 0;
	        						try{
	        							$stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id LEFT JOIN sales ON sales.id=details.sales_id WHERE details.sales_id=$id");
										$stmt->execute(['id'=>$id]);
	        							foreach($stmt as $row){
										$subtotal = $row['price']*$row['quantity'];
										$total += $subtotal;
										$total_sales += $total;
	        								echo "
											<tr class='prepend_items'>
												<td>".$row['name']."</td>
												<td align='right'>".number_format($row['price'], 2)."</td>
												<td align='right'>".$row['quantity']."</td>
												<td align='right'>".number_format($subtotal, 2)."</td>
											</tr>
	        								";
	        							}

	        						}
        							catch(PDOException $e){
										echo "There is some problem in connection: " . $e->getMessage();
									}

	        						$pdo->close();
	        					?>
									<td colspan="3" align="right"><b>ยอดรวม</b></td>
									<td align="right"><span > <?php echo $total_sales ?> บาท</span></td>
	        					</tbody>
	        				</table>
	        			</div>
	        		</div>
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
  	<?php include 'includes/pay_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
	$(document).on('click', '.transact', function(e){
		e.preventDefault();
		$('#transaction').modal('show');
		var id = $(this).data('id');
		$.ajax({
			type: 'POST',
			url: 'transaction.php',
			data: {id:id},
			dataType: 'json',
			success:function(response){
				$('#date').html(response.date);
				$('#transid').html(response.transaction);
				$('#detail').prepend(response.list);
				$('#total').html(response.total);
			}
		});
	});

	$("#transaction").on("hidden.bs.modal", function () {
	    $('.prepend_items').remove();
	});
});
</script>
</body>
</html>