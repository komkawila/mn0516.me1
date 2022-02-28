<!-- Transaction History -->
<?php
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

  $old_pay_amount = 0;
  $stmt2 = $conn->prepare("SELECT * FROM sales  WHERE id=$id");
	$stmt2->execute(['id'=>$id]);
  foreach($stmt2 as $row2){
	$old_pay_amount = 	$row2['pay_amount'];
	}

?>
<div class="modal fade" id="transaction">
  
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>รายการสินค้า</b></h4>
            </div>
            <div class="modal-body">
              <p>
                วันที่ : <span id="date"></span>
              </p>
              <table class="table table-bordered">
                <thead>
                  <th>สินค้า</th>
                  <th>ราคา</th>
                  <th>จำนวน</th>
                  <th>รวม</th>
                </thead>
                <tbody id="detail">
                  <tr>
                    <td colspan="3" align="right"><b>ยอดรวม</b></td>
                    <td><span id="total"></span></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center"><b>แก้ไขรายการชำระเงิน</b></h4>
          </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="pay_edit.php" enctype="multipart/form-data">
              <div class="form-group">
                    <label for="lastname" class="col-sm-3 control-label">รายการบิล</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="pay_id" name="pay_id" value=<?php echo $id; ?>  readonly>
                    </div>
                </div>
            <div class="form-group">
                    <label for="lastname" class="col-sm-3 control-label">ยอดรวม</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="total" name="total" value=<?php echo $total_sales; ?> disabled >
                    </div>
                </div>
              <div class="form-group">
                    <label for="lastname" class="col-sm-3 control-label">เลขที่บัญชีร้าน</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="lastname" name="lastname" value="กสิกร 999-9999-999" disabled >
                    </div>
                </div>
                
              <div class="form-group">
                    <label for="pay_amount" class="col-sm-3 control-label">ยอดที่ชำระ</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="pay_amount" name="pay_amount" value=<?php echo $old_pay_amount; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label for="photo" class="col-sm-5 control-label">หลักฐานการชำระเงิน</label>
                    <div class="col-sm-5">
                      <input type="file" id="photo" name="photo">
                    </div>
                </div>
                <hr>
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>
