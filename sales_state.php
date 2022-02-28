<?php include 'includes/session.php'; ?>
<?php
	if(!isset($_SESSION['user'])){
		header('location: index.php');
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
	        					<div class='callout callout-danger'>
	        						".$_SESSION['error']."
	        					</div>
	        				";
	        				unset($_SESSION['error']);
	        			}

	        			if(isset($_SESSION['success'])){
	        				echo "
	        					<div class='callout callout-success'>
	        						".$_SESSION['success']."
	        					</div>
	        				";
	        				unset($_SESSION['success']);
	        			}
	        		?>

	        		<div class="box box-solid">
	        			<div class="box-header with-border">
	        				<h4 class="box-title"><i class="fa fa-calendar"></i> <b>รายการสั่งซื้อ</b></h4>
	        			</div>
	        			<div class="box-body">
	        				<table class="table table-bordered" id="example1" style="text-align: center;">
	        					<thead>
											<th class="hidden"></th>
                                            <th style="width:15%;,text-align: center;">วันที่</th>
                                            <th style="width:30%;,text-align: center;">เลขพัสดุ</th>
                                            <th style="width:20%;,text-align: center;">ราคา</th>
                                            <th style="width:15%;,text-align: center;">สถานนะ</th>
                                            <th style="width:20%;,text-align: center;">รายการสั่งซื้อ</th>
	        					</thead>
	        					<tbody>
	        					<?php
	        						$conn = $pdo->open();

	        						try{
	        							$stmt = $conn->prepare("SELECT * FROM sales WHERE user_id=:user_id ORDER BY sales_date DESC");
	        							$stmt->execute(['user_id'=>$user['id']]);
	        							foreach($stmt as $row){
	        								$stmt2 = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE sales_id=:id");
	        								$stmt2->execute(['id'=>$row['id']]);
	        								$total = 0;
	        								foreach($stmt2 as $row2){
	        									$subtotal = $row2['price']*$row2['quantity'];
	        									$total += $subtotal;
	        								}
											$post_pay = $row['pay_id'] ;
											($post_pay == '0')?$post_pay="รอดำเนินการ":$post_pay = $row['pay_id'] ;

											if($row['sales_state']==0){
												$state_pay = "รอดำเดินการ" ;
												$state_bt = "
																<a href='pay.php?pay_id=".$row['id']."'>
																	<button class='btn btn-sm btn-flat btn-warning ''>
																		<i class='fa fa-edit'></i> แก้ไข
																	</button>
																</a>
															";
											} else{ 
												$state_pay = "ยืนยันชำระเงิน";
												$state_bt = "
																<button class='btn btn-sm btn-flat btn-info transact' data-id='".$row['id']."'>
																	<i class='fa fa-search'></i> ดูรายละเอียด
																</button>
															";
														}

	        								echo "
	        									<tr>
	        										<td class='hidden'></td>
	        										<td>".date('M d, Y', strtotime($row['sales_date']))."</td>
	        										<td>".$post_pay."</td>
	        										<td> ".number_format($total, 2)."</td>
	        										<td> ".$state_pay."</td>
	        										<td>
														$state_bt
													</td>
													</tr>
	        								";
	        							}

	        						}
        							catch(PDOException $e){
										echo "There is some problem in connection: " . $e->getMessage();
									}

	        						$pdo->close();
	        					?>
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
  	<?php include 'includes/profile_modal.php'; ?>
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