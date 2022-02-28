<?php
	// include 'session.php';

	// if(isset($_SESSION['user'])){
	// 	$conn = $pdo->open();

	// 	$stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products on products.id=cart.product_id WHERE user_id=:user_id");
	// 	$stmt->execute(['user_id'=>$user['id']]);

	// 	$total = 0;
	// 	foreach($stmt as $row){
	// 		$subtotal = $row['price'] * $row['quantity'];
	// 		$total += $subtotal;
	// 	}

	// 	$pdo->close();

	// }
?> 


<div class="modal fade" id="insert_cert">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center"><b>ยืนยันการชำระเงิน</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="sales.php?pay=0" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="contact" class="col-sm-5 control-label" >จำนวนเงินที่ชำระ</label>

                    <div class="col-sm-7">
                      <input class="form-control"  type="number" name="total" id="total" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="photo" class="col-sm-5 control-label">หลักฐานการชำระเงิน</label>

                    <div class="col-sm-7">
                      <input class="form-control"  type="file" id="photo" name="photo" required>
                    </div>
                </div>
                
                <hr>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" ><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>