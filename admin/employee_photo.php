<?php
	include 'includes/session.php';

	if(isset($_POST['uploadem'])){
		$id = $_POST['id'];
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE users SET photo=:photo WHERE id=:id");
			$stmt->execute(['photo'=>$filename, 'id'=>$id]);
			$_SESSION['success'] = 'แก้ไขรูปพนักงานสำเร็จ';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();

	}
	else{
		$_SESSION['error'] = 'แก้ไขรูปพนักงานไม่สำเร็จ';
	}

	header('location: employee.php');
?>