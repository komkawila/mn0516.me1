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
    <button  class="btn btn-success btn-flat" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> พิมพ์</button>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">พิมพ์</li>
      </ol>
      
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box ">
	        			<div class="box-body">
							<?php
							$conn = $pdo->open();
							$stmt = $conn->prepare("SELECT sales.sales_date AS sales_date,sales.pay_id AS pay_id,sales.sales_state AS sales_state,users.firstname AS firstname,users.lastname AS lastname,users.address AS addressw FROM  sales LEFT JOIN users ON users.id = sales.user_id WHERE sales.id=$id");
							$stmt->execute(['id'=>$id]);
							foreach($stmt as $row){
								
								$post_pay = $row['pay_id'] ;
								($post_pay == '0')?$post_pay="รอดำเนินการ":$post_pay = $row['pay_id'] ;

								$state_pay = $row['sales_state'] ;
								($state_pay == '0')?$state_pay="รอดำเนินการ":$state_pay = "ยืนยันชำระเงิน";

								?>
										<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-12 text-center"><h4 style="font-weight: 700;">ใบเสร็จรายการชำระเงิน : <?php echo $id; ?><h4></div>
                                            <br>
											<div class="col-sm-12 text-left">
												<p>ร้าน&emsp;&emsp;&emsp;&nbsp;&nbsp;:&emsp;&emsp;online by me
												<p>สมาชิก&emsp;&emsp;:&emsp;&emsp;<?php echo $row['firstname']."&emsp;".$row['lastname'] ; ?></p>
												<p>ยอดรวม&emsp;&nbsp;&nbsp;&nbsp;: &emsp;&emsp;<?php echo $total_sales ?> บาท</p>
												<p>เลขพัสดุ&emsp;&nbsp;&nbsp;:&emsp;&emsp;<?php echo $post_pay ?></p>
                                                <p>วันที่&emsp;&emsp;&emsp;:&emsp;&emsp;<?php echo  $row['sales_date'] ?></p>
											</div>
                                            
										</div>
									</div>
								<?php } ?>
	        			</div>
            <div class="box-body">
											<div class="col-sm-12 text-center"> <h4>รายการสินค้า</h4></div>
	        				<table class="table table-bordered" id="example1">
									<thead>
									<th>ชื่อสินค้า</th>
									<th style="text-align: center;">ราคา</th>
									<!-- <th style="text-align: center;">จำนวน</th> -->
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
									<td colspan="2" align="right"><b>ยอดรวม</b></td>
									<td align="right"><span > <?php echo $total_sales ?> บาท</span></td>
	        					</tbody>
	        				</table>
	        			</div>
          </div>
        </div>
      </div>
    </section>
     
  </div>
</div>
</body>
</html>
