

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

<div class="modal fade" id="active_pay">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>ยืนยันการชำระเงิน</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="pay_post.php" enctype="multipart/form-data">
              <div class="form-group">
                    <label for="contact" class="col-sm-5 control-label">รายการชำระเงิน : </label>

                    <div class="col-sm-7">
                      <input type="text" class="form-control"  id="id" name="id"  value=<?php echo $id; ?>  readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact" class="col-sm-5 control-label">จำนวนเงินที่ชำระ : </label>

                    <div class="col-sm-7">
                      <input type="text" class="form-control" value=<?php echo $total_sales; ?>  readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="curr_password" class="col-sm-5 control-label">เลขพัสดุ</label>

                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="pay_id" name="pay_id" placeholder="กรุณากรอกเลขพัสดุ" required>
                    </div>
                </div>
                <hr>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> ยืนยัน</button>
              </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="active_pay2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>ยืนยันการชำระเงิน</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="pay_post.php" enctype="multipart/form-data">
              <div class="form-group">
                    <label for="contact" class="col-sm-5 control-label">รายการชำระเงิน : </label>

                    <div class="col-sm-7">
                      <input type="text" class="form-control"  id="id" name="id"  value=<?php echo $id; ?>  readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact" class="col-sm-5 control-label">จำนวนเงินที่ชำระ : </label>

                    <div class="col-sm-7">
                      <input type="text" class="form-control" value=<?php echo $total_sales; ?>  readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="curr_password" class="col-sm-5 control-label">เลขพัสดุ</label>

                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="pay_id" name="pay_id" placeholder="กรุณากรอกเลขพัสดุ" required>
                    </div>
                </div>
                <hr>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" onclick="window.print()"><i class="fa fa-check-square-o"></i> ยืนยัน</button>
              </form>
            </div>
        </div>
    </div>
</div>