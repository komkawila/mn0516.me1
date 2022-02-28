<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$slug = slugify($name);
		$category = $_POST['category'];
		$price = $_POST['price'];
		$description = $_POST['description'];
		$amount = $_POST['amount'];

		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE products SET name=:name, slug=:slug, category_id=:category, price=:price, description=:description ,product_stock=:amount WHERE id=:id");
			$stmt->execute(['name'=>$name, 'slug'=>$slug, 'category'=>$category, 'price'=>$price, 'description'=>$description,'amount'=>$amount, 'id'=>$id]);
			$_SESSION['success'] = 'แก้ไขสินค้าสำเร็จ';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'แก้ไขสินค้าไม่สำเร็จ';
	}

	header('location: products.php');

?>