<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];
		$slug = $name;
		$category = $_POST['category'];
		$price = $_POST['price'];
		$amount = $_POST['amount'];
		$description = $_POST['description'];
		$filename = $_FILES['photo']['name'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM products WHERE slug=:slug");
		$stmt->execute(['slug'=>$slug]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'สินค้านี้มีอยู่แล้ว';
		}
		else{
			if(!empty($filename)){
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$dates = date("Y:m:d").date("h:i:sa");
				$new_filename = $filename.'.'.$ext;
				move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$new_filename);	
			}
			else{
				$new_filename = '';
			}

			try{
				$stmt = $conn->prepare("INSERT INTO products (category_id, name, description, slug, price, photo,product_stock) VALUES (:category, :name, :description, :slug, :price, :photo, :product_stock)");
				$stmt->execute(['category'=>$category, 'name'=>$name, 'description'=>$description, 'slug'=>$slug, 'price'=>$price, 'photo'=>$new_filename,'product_stock'=>$amount]);
				$_SESSION['success'] = 'เพิ่มสินค้าสำเร็จ';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'เพิ่มสินค้าไม่สำเร็จ';
	}

	header('location: products.php');

?>