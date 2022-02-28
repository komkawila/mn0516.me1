<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$sales_id = $_POST['salesid'];
		$quantity = $_POST['quantity'];

		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE details SET quantity=:quantity WHERE id=:id");
			$stmt->execute(['quantity'=>$quantity, 'id'=>$id]);

			$_SESSION['success'] = 'Quantity updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();

		header('location: sales_edit_page.php?salse_id='.$sales_id);
	}

?>