<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM category WHERE id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'ลบข้อมูลประเภทสินค้าสำเร็จ';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'ลบข้อมูลประเภทสินค้าไม่สำเร็จ';
	}

	header('location: category.php');
	
?>