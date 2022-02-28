<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['pay_id'];
		$pay_amount = $_POST['pay_amount'];
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$filename);	
		}
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE sales SET photo=:photo ,pay_amount=:pay_amount WHERE id=:id");
			$stmt->execute(['photo'=>$filename,'pay_amount'=>$pay_amount, 'id'=>$id]);
			$_SESSION['success'] = 'แก้ไขรายการสำเร็จ';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'แก้ไขรายการไม่สำเร็จ';
	}
	$locations = "location: pay.php?pay_id=$id";
	header($locations);
?>