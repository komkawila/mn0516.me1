<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
	$slug = 'tablets';

	$month = date('m');
	$conn = $pdo->open();

	$count2 = 0 ;
	try{
	$inc = 3;	
	$stmt2 = $conn->prepare("SELECT *, SUM(quantity) AS total_qty FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE MONTH(sales_date) = '$month' GROUP BY details.product_id ORDER BY total_qty DESC LIMIT 6");
	$stmt2->execute();
	foreach ($stmt2 as $row2) {
		$count22 =$count2 + 0 ;
		}
	}
	catch(PDOException $e){
		echo "There is some problem in connection: " . $e->getMessage();
	}

	try{
        $inc = 3;	
        $stmt = $conn->prepare("SELECT * FROM products ");
        $stmt->execute();
        $count = 0 ;
        foreach ($stmt as $row) {
            $count = $count + 1;
        }
      
	}
	catch(PDOException $e){
		echo "There is some problem in connection: " . $e->getMessage();
	}

	$pdo->close();

?>

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
	        					<div class='alert alert-danger'>
	        						".$_SESSION['error']."
	        					</div>
	        				";
	        				unset($_SESSION['error']);
	        			}
	        		?>
	        		
		            <h2>สินค้าขายดี </h2>
		           
					<?php
					if ($count2 == 0) {
						?>
						 <div class="callout callout-warning text-start">
						<p>ไม่พบรายการสินค้า</p>
					</div>
						<?php
					}else{

						$month = date('m');
		       			$conn = $pdo->open();
						   

		       			try{
		       			 	$inc = 3;	
						    $stmt = $conn->prepare("SELECT *, SUM(quantity) AS total_qty FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE MONTH(sales_date) = '$month' GROUP BY details.product_id ORDER BY total_qty DESC LIMIT 6");
						    $stmt->execute();
						    foreach ($stmt as $row) {
								$count2 = $count2 + 1;
						    	$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
						    	$inc = ($inc == 3) ? 1 : $inc + 1;
	       						if($inc == 1) echo "<div class='row'>";
	       						echo "
	       							<div class='col-sm-4' >
	       								<div class='box box-solid ' style='border: 5px solid #00a65a; border-radius: 20px;'>
		       								<div class='box-body prod-body' style='border-radius: 20px;'>
		       									<img src='".$image."' width='100%' height='230px' class='thumbnail' >
		       									<h5><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></h5>
		       								</div>
		       								<div class='box-footer' style='border-radius: 20px; display:flex; '>
		       									<b> ราคา ".number_format($row['price'], 2)."</b>
		       									<p style='margin-left:auto;'> จำนวน ".$row['product_stock']." ชิ้น</p>
                                                   
		       								</div>
	       								</div>
	       							</div>
	       						";
	       						if($inc == 3) echo "</div>";
						    }
						    if($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>"; 
							if($inc == 2) echo "<div class='col-sm-4'></div></div>";
						}
						catch(PDOException $e){
							echo "There is some problem in connection: " . $e->getMessage();
						}

						$pdo->close();


					}
					
					?>
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
			 <div class="row">
                        <div class="col-sm-9">
                            <h2>รายการสินค้าทั้งหมด  <?php echo $count; ?> รายการ</h2>
                           
                            <?php
		       			
		       			$conn = $pdo->open();

		       			try{
		       			 	$inc = 3;	
						    $stmt = $conn->prepare("SELECT * FROM products ");
						    $stmt->execute();
						    foreach ($stmt as $row) {
						    	$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
						    	$inc = ($inc == 3) ? 1 : $inc + 1;
	       						if($inc == 1) echo "<div class='row'>";
	       						echo "
	       							<div class='col-sm-4'>

<div class='box box-solid' style='border: 5px solid #00a65a; border-radius: 20px;'>
		       								<div class='box-body prod-body'>
		       									<img src='".$image."' width='100%' height='230px' class='thumbnail'>
		       									<h5><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></h5>
		       								</div>
                                                 
		       								<div class='box-footer' style='border-radius: 20px; display:flex; '>
		       									<b> ราคา ".number_format($row['price'], 2)."</b>
		       									<p style='margin-left:auto;'> จำนวน ".$row['product_stock']." ชิ้น</p>
                                                   
		       								</div>
	       								</div>
	       							</div>
	       						";
	       						if($inc == 3) echo "</div>";
						    }
						    if($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>"; 
							if($inc == 2) echo "<div class='col-sm-4'></div></div>";
						}
						catch(PDOException $e){
							echo "There is some problem in connection: " . $e->getMessage();
						}

						$pdo->close();

		       		?>
                        </div>
                        <div class="col-sm-3">
                            <?php include 'includes/sidebar.php'; ?>
                        </div>
                    </div>
					<div class="row">
                        <div class="col-sm-9">
                            <h2>รายการสินค้าทั้งหมด  <?php echo $count; ?> รายการ</h2>
                           
                            <?php
		       			
		       			$conn = $pdo->open();

		       			try{
		       			 	$inc = 3;	
						    $stmt = $conn->prepare("SELECT * FROM products ");
						    $stmt->execute();
						    foreach ($stmt as $row) {
						    	$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
						    	$inc = ($inc == 3) ? 1 : $inc + 1;
	       						if($inc == 1) echo "<div class='row'>";
	       						echo "
	       							<div class='col-sm-4'>

<div class='box box-solid' style='border: 5px solid #00a65a; border-radius: 20px;'>
		       								<div class='box-body prod-body'>
		       									<img src='".$image."' width='100%' height='230px' class='thumbnail'>
		       									<h5><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></h5>
		       								</div>
                                                 
		       								<div class='box-footer' style='border-radius: 20px; display:flex; '>
		       									<b> ราคา ".number_format($row['price'], 2)."</b>
		       									<p style='margin-left:auto;'> จำนวน ".$row['product_stock']." ชิ้น</p>
                                                   
		       								</div>
	       								</div>
	       							</div>
	       						";
	       						if($inc == 3) echo "</div>";
						    }
						    if($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>"; 
							if($inc == 2) echo "<div class='col-sm-4'></div></div>";
						}
						catch(PDOException $e){
							echo "There is some problem in connection: " . $e->getMessage();
						}

						$pdo->close();

		       		?>
                        </div>
                        <div class="col-sm-3">
                            <?php include 'includes/sidebar.php'; ?>
                        </div>
                    </div>
	      </section>
	     
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>