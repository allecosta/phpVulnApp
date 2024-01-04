<?php

require 'includes/session.php';

if (isset($_GET['return'])) {
	$return = $_GET['return'];
} else {
	$return = 'home.php';
}

if (isset($_POST['save'])) {
	$currPassword = $_POST['curr_password'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$photo = $_FILES['photo']['name'];

	if (password_verify($currPassword, $admin['password'])) {
		if (!empty($photo)) {
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/' . $photo);
			$filename = $photo;
		} else {
			$filename = $admin['photo'];
		}

		if ($password == $admin['password']) {
			$password = $admin['password'];
		} else {
			$password = password_hash($password, PASSWORD_DEFAULT);
		}

		$conn = $pdo->open();

		try {
			$sql = "UPDATE 
						users 
					SET 
						email = :email, password = :password, firstname = :firstname, lastname = :lastname, photo = :photo 
					WHERE 
						id = :id";

			$stmt = $conn->prepare($sql);
			$stmt->execute([
				'email' => $email,
				'password' => $password,
				'firstname' => $firstname,
				'lastname' => $lastname,
				'photo' => $filename,
				'id' => $admin['id']
			]);

			$_SESSION['success'] = 'Conta atualizada com sucesso.';
		} catch (PDOException $e) {
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	} else {
		$_SESSION['error'] = 'Senha incorreta.';
	}
} else {
	$_SESSION['error'] = 'Favor preencher primeiro os detalhes necessários.';
}

header('location:' . $return);
