<?php include 'includes/session.php'; ?>
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
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        จัดการรายการสินค้าในตะกล้าของ 
      </h1>
      <ul class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>สมาชิก</li>
        <li class="active">รายการสินค้า</li>
      </ul>
    </section>

    <!-- Main content -->
    <section class="content">
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
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> สำเร็จ!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" id="add" data-id="<?php echo $user['id']; ?>" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> เพิ่มสินค้า</a>
              <a href="sales.php" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-arrow-left"></i> รออนุมัติ</a>
            </div>
            <div class="box-body">
            <table class="table table-bordered" id="example1">
								<thead>
									<th>ชื่อสินค้า</th>
									<th style="text-align: center;">ราคา</th>
									<th style="text-align: center;">จำนวน</th>
									<th style="text-align: center;">รวม</th>
									<th style="text-align: center;">จัดการ</th>
								</thead>
	        					<tbody>
	        					<?php
	        						$conn = $pdo->open();
									$total = 0;
									$total_sales = 0;
	        						try{
	        							$stmt = $conn->prepare("SELECT *,details.id AS detailid FROM details LEFT JOIN products ON products.id=details.product_id LEFT JOIN sales ON sales.id=details.sales_id WHERE details.sales_id=$id");
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
												<td >
                                                    <button type='button' class='btn btn-warning btn-sm btn-flat transact edit' data-id='".$row['detailid']."'><i class='fa fa-edit'></i> แก้ไข</button>
                                                    <button type='button' class='btn btn-danger btn-sm btn-flat transact delete' data-id='".$row['detailid']."'><i class='fa fa-trash'></i> ลบ</button>
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
    <?php include 'includes/details_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>

<script>
$(function(){

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.status', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });
  $('#add').click(function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getProducts(id);
  });

  $("#addnew").on("hidden.bs.modal", function () {
      $('.append_items').remove();
  });


});
function getProducts(id){
  $.ajax({
    type: 'POST',
    url: 'products_all.php',
    dataType: 'json',
    success: function(response){
      $('#product').append(response);
      $('.userid').val(id);
    }
  });
}
function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'details_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.detailid').val(response.id);
      $('.salesid').val(response.sales_id);
      $('#edit_product_id').val(response.product_id);
      $('#edit_sales_state').val(response.	quantity);
      $('#edit_quantity').val(response.quantity);
      $('.fullname').html('ID : '+response.id+' , วันที่ : '+response.quantity);
    }
  });
}
</script>
</body>
</html>
