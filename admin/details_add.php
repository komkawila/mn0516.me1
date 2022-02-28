<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$id = $_POST['id'];
		$product = $_POST['product'];
		$quantity = $_POST['quantity'];
		$sales_id = $_POST['salesid'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM details WHERE product_id=:id");
		$stmt->execute(['id'=>$product]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'รายการสินค้านี้มีอยู่แล้ว';
		}
		else{
			try{
				$stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product, :quantity)");
				$stmt->execute(['sales_id'=>$sales_id, 'product'=>$product, 'quantity'=>$quantity]);

				$_SESSION['success'] = 'เพิ่มรายการสินค้าสำเร็จ';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();

		header('location: sales_edit_page.php?salse_id='.$sales_id);
	}

?>