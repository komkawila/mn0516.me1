<?php
	include 'includes/session.php';

	$payid = $_GET['pay'];
	if(isset($_GET['pay'])){

		$payid = $_GET['pay'];
		$date = date('Y-m-d');
		$filename = $_FILES['photo']['name'];	
		$total = $_POST['total'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$filename);	
		}
		$conn = $pdo->open();
	
		try{
			$stmt = $conn->prepare("INSERT INTO sales (user_id, pay_id, sales_date , photo , pay_amount	) VALUES (:user_id, :pay_id, :sales_date,:photo,:pay_amount)");
			$stmt->execute(['user_id'=>$user['id'], 'pay_id'=>$payid, 'sales_date'=>$date,'photo'=>$filename , 'pay_amount'=>$total]);
			$salesid = $conn->lastInsertId();
			
			try{
				$stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
				$stmt->execute(['user_id'=>$user['id']]);

				foreach($stmt as $row){

					$amount = $row['quantity'];

					$stmt = $conn->prepare("INSERT INTO details (sales_id, product_id, quantity) VALUES (:sales_id, :product_id, :quantity)");
					$stmt->execute(['sales_id'=>$salesid, 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity']]);

					$stmt3 = $conn->prepare("SELECT * FROM products  WHERE id=:id");
					$stmt3->execute(['id'=>$row['product_id']]);

					foreach($stmt3 as $rw){
						$id = $row['id'];
						$total_amount = $rw['product_stock'] - $amount;
						if($total_amount <= 0){
							$total_amount = 0;
						}
						$stmt2 = $conn->prepare("UPDATE products SET product_stock=:amount WHERE id=:id");
						$stmt2->execute(['amount'=>$total_amount, 'id'=>$id]);
					}
					

					
				}

				$stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
				$stmt->execute(['user_id'=>$user['id']]);
				$_SESSION['success'] = 'ยืนยันการชำระเงินสำเร็จ, กรุณารอทางร้านดำเนินการ ';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	
	header('location: cart_view.php');
	
?>