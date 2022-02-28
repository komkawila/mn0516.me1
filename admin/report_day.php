<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php 
  include 'includes/menubar.php'; 
  $getday = $_GET['day'] ;
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      รายการรายวัน
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">ดำเนินการสำเร็จ</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <div class="pull-right">
                เลือกวันที่ : 
              <input type="date" id="select_day" value=<?php echo $getday;  ?>>

              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>ลำดับ</th>
                  <th>ประเภทสินค้า</th>
                  <th>รูปสินค้า</th>
                  <th>ชื่อสินค้า</th>
                  <th>ราคา</th>
                  <th>จำนวนสินค้า</th>
                  <th>สมาชิกที่ซื้อสินค้า</th>
                  <th>วันที่</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();
                    $c = 0 ;
                    try{
                      $stmt = $conn->prepare("SELECT category.name AS cname,products.photo,products.name,products.price,details.quantity,users.firstname,users.lastname,sales.sales_date 
                      FROM `details` 
                      LEFT JOIN `sales` ON details.sales_id = sales.id 
                      LEFT JOIN `products` ON details.product_id = products.id 
                      LEFT JOIN `users` ON sales.user_id = users.id 
                      LEFT JOIN `category` ON products.category_id = category.id
                      WHERE sales.sales_date = '$getday'");
                      $stmt->execute();
                      foreach($stmt as $row){
                        
                        $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';

                        $c = $c+1 ;
                        echo "
                          <tr>
                          <td class='hidden'></td>
                            <td>".$c."</td>
                            <td>".$row['cname'] ."</td>
                            <td>
                              <img src='".$image."' height='30px' width='30px'>
                            </td>
                            <td>".$row['name'] ."</td>
                            <td>".$row['price'] ."</td>
                            <td>".$row['quantity'] ."</td>
                            <td>".$row['firstname']." ".$row['lastname']."</td>
                            <td>".$row['sales_date'] ."</td>
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
    <?php include 'includes/profile_modal2.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<!-- Date Picker -->
<script>
$(function(){
  $('#select_day').change(function(){
    window.location.href = 'report_day.php?day='+$(this).val();
  });
});
</script>

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
</body>
</html>
