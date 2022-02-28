<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();
		// amount
		$stmt = $conn->prepare("SELECT *, products.product_stock AS amount, products.id AS prodid, products.name AS prodname, category.name AS catname FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();
		
		$pdo->close();

		echo json_encode($row);
	}
?>