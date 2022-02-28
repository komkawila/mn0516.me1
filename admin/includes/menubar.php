

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img style="object-fit: cover;width: 45px; height:45px;"
                    src="<?php echo (!empty($admin['photo'])) ? '../images/'.$admin['photo'] : '../images/profile.jpg'; ?>"
                    class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $admin['firstname'].' '.$admin['lastname']; ?></p>
                <a><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">รายงาน</li>
            <li><a href="home.php"><i class="fa fa-dashboard"></i> <span>รายงาน</span></a></li>
            <li class="header">รายการขาย</li>
            <li><a href="report_year.php?year="><i class="fa fa-dashboard"></i> <span>รายการขายรายปี</span></a></li>
            <li><a href="report_mont.php?month="><i class="fa fa-dashboard"></i> <span>รายการขายรายเดือน</span></a></li>
            <li><a href="report_day.php?day="><i class="fa fa-dashboard"></i> <span>รายการขายรายวัน</span></a></li>
            
            <li class="header">รายสั่งซื้อ</li>
            <li><a href="sales_active.php"><i class="fa fa-money"></i> <span>อนุมัติแล้ว</span></a></li>
            <li><a href="sales.php"><i class="fa fa-money"></i> <span>รออนุมัติ</span></a></li>
            <li class="header">จัดการ</li>
            <?php 
        if($admin['type' ]== 1){echo '<li><a href="employee.php"><i class="fa fa-users"></i> <span>พนักงาน</span></a></li>';}
      ?>
            <!-- <li><a href="employee.php"><i class="fa fa-users"></i> <span>พนักงาน</span></a></li> -->
            <li><a href="users.php"><i class="fa fa-users"></i> <span>สมาชิก</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-barcode"></i>
                    <span>สินค้า</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="products.php"><i class="fa fa-circle-o"></i> รายการสินค้า</a></li>
                    <li><a href="category.php"><i class="fa fa-circle-o"></i> ประเภทสินค้า</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>