<?php
	include 'includes/session.php';

	$conn = $pdo->open();

	if(isset($_POST['edit'])){
		$curr_password = $_POST['curr_password'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$contact = $_POST['contact'];
		$address = $_POST['address'];
		$photo = $_FILES['photo']['name'];
		if($curr_password == $user['password']){
			if(!empty($photo)){
				$filename = $photo;	
				// $ext = pathinfo($filename, PATHINFO_EXTENSION);
				// $new_filename = $filename.'_'.time().'.'.$ext;
				move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$filename);
				// move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$new_filename);	
				
			}
			else{
				$filename = $user['photo'];
			}

			if($password == $user['password']){
				$password = $user['password'];
			}
			else{
				// $password = password_hash($password, PASSWORD_DEFAULT);
			}

			try{
				$stmt = $conn->prepare("UPDATE users SET email=:email, password=:password, firstname=:firstname, lastname=:lastname, contact_info=:contact, address=:address, photo=:photo WHERE id=:id");
				$stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'contact'=>$contact, 'address'=>$address, 'photo'=>$filename, 'id'=>$user['id']]);

				$_SESSION['success'] = 'แก้ไขบัญชีผู้ใช้สำเร็จ';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
			
		}
		else{
			$_SESSION['error'] = 'รหัสผ่านผิด';
		}
	}
	else{
		$_SESSION['error'] = 'แก้ไขบัญชีผู้ใช้ไม่สำเร็จ';
	}

	$pdo->close();

	header('location: profile.php');

?>