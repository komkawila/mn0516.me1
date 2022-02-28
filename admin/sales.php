<?php include 'includes/session.php'; ?>
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
      รายการรอยืนยันชำระเงิน
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">รอดำเนินการ</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
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
          <div class="box">
            <div class="box-header with-border">
              <div class="pull-right">
                
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>รายการ(ID)</th>
                  <th>วันที่</th>
                  <th>สมาชิก</th>
                  <th>เลขพัสดุ</th>
                  <th>ราคาสินค้ารวม</th>
                  <th>รายละเอียด</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT *, sales.id AS salesid FROM sales LEFT JOIN users ON users.id=sales.user_id WHERE sales.sales_state = 0 ORDER BY sales_date DESC");
                      $stmt->execute();
                      foreach($stmt as $row){
                        $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE details.sales_id=:id");
                        $stmt->execute(['id'=>$row['salesid']]);
                        $total = 0;
                        foreach($stmt as $details){
                          $subtotal = $details['price']*$details['quantity'];
                          $total += $subtotal;
                        }
                        $pay_post;
                        ($row['pay_id']==0)?$pay_post="รอดำเนินการ":$pay_post=$row['pay_id'];
                        echo "
                          <tr>
                            <td class='hidden'></td>
                            <td>".$row['salesid'] ."</td>
                            <td>".date('M d, Y', strtotime($row['sales_date']))."</td>
                            <td>".$row['firstname'].' '.$row['lastname']. $row['salesid'] ."</td>
                            <td>".$pay_post."</td>
                            <td>".number_format($total, 2)."</td>
                            <td>
                              <a href='pay_active.php?salse_id=".$row['salesid']."' class='btn btn-success btn-sm btn-flat ' ><i class='fa fa-search'></i> ตรวจสอบ</a>
                              <a href='sales_edit_page.php?salse_id=".$row['salesid']."' class='btn btn-warning btn-sm btn-flat ' ><i class='fa fa-edit'></i> แก้ไข</a>
                              <button type='button' class='btn btn-danger btn-sm btn-flat transact delete' data-id='".$row['salesid']."'><i class='fa fa-trash'></i> ลบ</button>
                              </td>
                            
                          </tr>
                        ";
                      }
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }
                    $pdo->close();
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
     
  </div>
  	<?php include 'includes/footer.php'; ?>
    <?php include 'includes/salse_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<!-- Date Picker -->
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

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'sales_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.salesid').val(response.id);
      $('#edit_user_id').val(response.user_id);
      $('#edit_pay_id').val(response.pay_id);
      $('#edit_sales_date').val(response.sales_date);
      $('#edit_sales_state').val(response.sales_state);
      $('.fullname').html('ID : '+response.id+' , วันที่ : '+response.sales_date);
    }
  });
}
</script>
</body>
</html>
