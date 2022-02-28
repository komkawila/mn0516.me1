<?php
	include 'includes/session.php';

	$conn = $pdo->open();

	$output = array('error'=>false);

	$id = $_POST['id'];
	$qty = $_POST['qty'];

	$state_page = 0 ;

	if(isset($_SESSION['user'])){
		try{
			$amount = 0;
			$stmt3 = $conn->prepare("SELECT * ,products.product_stock AS amount FROM `cart` INNER JOIN `products` ON cart.product_id = products.id  WHERE cart.id=:id");
			$stmt3->execute(['id'=>$id]);

			foreach($stmt3 as $rw){

				$amount_ch = $rw['amount'] - $qty;
				if($amount_ch >= 0){
					$stmt = $conn->prepare("UPDATE cart SET quantity=:quantity WHERE id=:id");
					$stmt->execute(['quantity'=>$qty, 'id'=>$id]);
					$output['message'] = 'Updated';
				}else{
					// $output['message'] = 'error';
				}
				
				
			}



			
		}
		catch(PDOException $e){
			$output['message'] = $e->getMessage();
		}
	}
	else{
		foreach($_SESSION['cart'] as $key => $row){
			if($row['productid'] == $id){
				$_SESSION['cart'][$key]['quantity'] = $qty;
				$output['message'] = 'Updated';
			}
		}
	}

	$pdo->close();

	// if($state_page == 1){
		// header('location: cart_view.php');
	// }
	// else{
		echo json_encode($output);
	// }

?>