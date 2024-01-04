<?php

require 'includes/session.php';

if (isset($_POST['add'])) {
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$address = $_POST['address'];
	$contact = $_POST['contact'];

	$conn = $pdo->open();

	$sql = "SELECT *, COUNT(*) AS numrows FROM users WHERE email = :email";
	$stmt = $conn->prepare($sql);
	$stmt->execute(['email' => $email]);
	$row = $stmt->fetch();

	if ($row['numrows'] > 0) {
		$_SESSION['error'] = 'Email já recebido.';
	} else {
		$password = password_hash($password, PASSWORD_DEFAULT);
		$filename = $_FILES['photo']['name'];
		$now = date('Y-m-d');

		if (!empty($filename)) {
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/' . $filename);
		}

		try {
			$sql = "INSERT INTO 
						users (email, password, firstname, lastname, address, contact_info, photo, status, created_on) 
					VALUES 
						(:email, :password, :firstname, :lastname, :address, :contact, :photo, :status, :created_on)";

			$stmt = $conn->prepare($sql);
			$stmt->execute([
				'email' => $email,
				'password' => $password,
				'firstname' => $firstname,
				'lastname' => $lastname,
				'address' => $address,
				'contact' => $contact,
				'photo' => $filename,
				'status' => 1,
				'created_on' => $now
			]);

			$_SESSION['success'] = 'Usuário adicionado com sucesso.';
		} catch (PDOException $e) {
			$_SESSION['error'] = $e->getMessage();
		}
	}

	$pdo->close();
} else {
	$_SESSION['error'] = 'Favor, primeiro preencha o formulário do usuário.';
}

header('location: users.php');
