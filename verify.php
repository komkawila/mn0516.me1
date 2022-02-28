<?php
	include 'includes/session.php';
	$conn = $pdo->open();

	if(isset($_POST['login'])){
		
		$email = $_POST['email'];
		$password = $_POST['password'];

		try{

			$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE email = :email");
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch();
			if($row['numrows'] > 0){
				if($row['status']){
					if($password == $row['password']){
						if($row['type']==0){
							$_SESSION['user'] = $row['id'];
						}
						else {
							$_SESSION['admin'] = $row['id'];
						}
					}
					else{
						$_SESSION['error'] = 'รหัสผ่านไม่ถูกต้อง';
					}
				}
				else{
					$_SESSION['warning'] = 'รอยืนยันการเป็นสมาชิกจากทางร้าน';
				}
			}
			else{
				$_SESSION['error'] = 'ไม่มีบัญชีผู้ใช้นี้';
			}
		}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}

	}
	else{
		$_SESSION['error'] = 'เข้าสู่ระบบไม่สำเร็จ';
	}

	$pdo->close();

	header('location: login.php');

?>