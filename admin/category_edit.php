<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$cat_slug = $name ;

		try{
			$stmt = $conn->prepare("UPDATE category SET name=:name ,cat_slug=:cat_slug WHERE id=:id");
			$stmt->execute(['name'=>$name,'cat_slug'=>$cat_slug, 'id'=>$id]);
			$_SESSION['success'] = 'แก้ไขข้อมูลประเภทสินค้าสำเร็จ';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'แก้ไขข้อมูลประเภทสินค้าไม่สำเร็จ';
	}

	header('location: category.php?asdasd='.$name);

?>