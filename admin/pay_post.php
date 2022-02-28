<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$pay_id = $_POST['pay_id'];
 		$sales_state = 1 ;
		$conn = $pdo->open();

		try{
			// $stmt = $conn->prepare("UPDATE sales SET pay_id=:pay_id,sales_state=:mysqli_escape_string(1)  WHERE id=:id");
			// $stmt->execute(array($id));
			$stmt = $conn->prepare("UPDATE sales SET pay_id=:pay_id, sales_state=:sales_state WHERE id=:id");
			$stmt->execute(['pay_id'=>$pay_id, 'sales_state'=>$sales_state, 'id'=>$id]);

			// $stmt = "UPDATE sales SET pay_id=:pay_id,sales_state=:1  WHERE id=:id";
			// $stmt->bindValue(':pay_id', $pay_id, PDO::PARAM_STR);

			$_SESSION['success'] = 'ยืนยันการชำระเงินสำเร็จ';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
		header('location: sales.php');
	}

?>