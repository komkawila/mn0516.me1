
<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];
		$cat_slug = $name;
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM category WHERE name=:name");
		$stmt->execute(['name'=>$name]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'ประเภทสินค้านี้ มีอยู่แล้ว';
		}
		else{
			try{
				$stmt = $conn->prepare("INSERT INTO category (name,cat_slug) VALUES (:name,:cat_slug)");
				$stmt->execute(['name'=>$name,'cat_slug'=>$cat_slug]);
				$_SESSION['success'] = 'เพิ่มข้อมูลประเภทสินค้าสำเร็จ';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'เพิ่มข้อมูลประเภทสินค้าไม่สำเร็จ';
	}

	header('location: category.php');

?>