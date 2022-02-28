<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

<?php

$id = $_GET['salse_id'];
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ตรวจสอบรายการสั่งซื้อ
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">ตรวจสอบรายการสั่งซื้อ</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <div class="pull-right">
                <form method="POST" class="form-inline" action="sales_print.php">
                </form>
              </div>
            </div>
            <div class="box box-solid">
	        			<div class="box-body">
							<?php
							$conn = $pdo->open();
							$stmt = $conn->prepare("SELECT * FROM  sales WHERE id=$id");
							$stmt->execute(['id'=>$id]);
							foreach($stmt as $row){
								$pay_amount = $row['pay_amount'] ;
								$post_pay = $row['pay_id'] ;
								($post_pay == 0)?$post_pay="รอดำเนินการ":$post_pay = $row['pay_id'] ;

								$state_pay = $row['sales_state'] ;
								($state_pay == 0)?$state_pay="รอดำเนินการ":$state_pay = "ยืนยันชำระเงิน";

								?>
										 <div class="col-sm-3">
	        									<img src="<?php echo (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/no-image.jpg'; ?>" width="100%">
	        							</div>
										<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-12 text-left"><h4 style="font-weight: 700;">รายการชำระเงิน : <?php echo $id; ?><h4></div>
											<div class="col-sm-3">
												<h4>เลขบัญชีร้าน:</h4>
												<h4>ยอดรวมที่ต้องชำระ:</h4>
												<h4>สถานะ:</h4>
												<h4>เลขพัสดุ:</h4>
                        <hr>
												<h4>ยอดรวมที่ชำระ:</h4>
                        <br>
                        <br>
                        <br>
                        <span class="pull-left">
														<a href="#active_pay" class="btn btn-success btn-flat btn-md" data-toggle="modal"><i class="fa fa-check"></i> ยืนยันการชำระเงิน</a>
													</span>
											</div>
											<div class="col-sm-9">
												<h4>กสิกร 999-9999-999
												</h4>
												<h4><?php echo $total_sales ; ?> บาท</h4>
												<h4><?php echo $state_pay ?></h4>
												<h4><?php echo $post_pay ?></h4>
                        <hr>
												<h4><?php echo $pay_amount ?> บาท</h4>
                        
											</div>
										</div>
									</div>
								<?php } ?>
	        				
	        				
                
	        			</div>
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
      </div>
    </section>
     
  </div>
  	<?php include 'includes/footer.php'; ?>
    <?php include 'includes/pay_model.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<!-- Date Picker -->
<script>
$(function(){
  //Date picker
  $('#datepicker_add').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })
  $('#datepicker_edit').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })

  //Timepicker
  $('.timepicker').timepicker({
    showInputs: false
  })

  //Date range picker
  $('#reservation').daterangepicker()
  //Date range picker with time picker
  $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
  //Date range as a button
  $('#daterange-btn').daterangepicker(
    {
      ranges   : {
        'Today'       : [moment(), moment()],
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate  : moment()
    },
    function (start, end) {
      $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    }
  )
  
});
</script>
<script>
$(function(){
  $(document).on('click', '.transact', function(e){
    e.preventDefault();
    $('#transaction').modal('show');
    var id = $(this).data('id');
    $.ajax({
      type: 'POST',
      url: 'transact.php',
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
<script>
function addIdToTextBox(id) {
    document.getElementById('myId').value = id;
}
</script>
</body>
</html>
