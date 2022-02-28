<?php
	include 'includes/session.php';

	if(isset($_POST['delete_em'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM users WHERE id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'ลบข้อมูลพนักงานสำเร็จ';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'ลบข้อมูลพนักงานไม่สำเร็จ';
	}
	
	header('location: employee.php');
	
?>