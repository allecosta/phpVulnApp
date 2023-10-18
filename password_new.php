<?php

require_once 'includes/session.php';

if (!isset($_GET['code']) OR !isset($_GET['user'])) {
	header('location: index.php');
	exit(); 
}

$path = 'password_reset.php?code='.$_GET['code'].'&user='.$_GET['user'];

if (isset($_POST['reset'])) {
	$password = $_POST['password'];
	$rePassword = $_POST['repassword'];

	if($password != $rePassword){
		$_SESSION['error'] = 'As senhas não correspondem';
		header('location: '.$path);
		exit();

	} else{
		$conn = $pdo->open();
		$sql = "SELECT *, COUNT(*) AS numrows FROM users WHERE reset_code=:code AND id=:id";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['code' => $_GET['code'], 'id' => $_GET['user']]);
		$row = $stmt->fetch();

		if ($row['numrows'] > 0) {
			$password = password_hash($password, PASSWORD_DEFAULT);

			try {
				$sql = "UPDATE users SET password=:password WHERE id=:id";
				$stmt = $conn->prepare($sql);
				$stmt->execute(['password' => $password, 'id' => $row['id']]);

				$_SESSION['success'] = 'Senha alterada com sucesso';
				header('location: login.php');
				exit();

			} catch(PDOException $e) {
				$_SESSION['error'] = $e->getMessage();
				header('location: '.$path);
				exit();
			}

		} else {
			$_SESSION['error'] = 'O código não corresponde ao usuário';
			header('location: '.$path);
			exit();
		}

		$pdo->close();
	}

} else {
	$_SESSION['error'] = 'Insira uma nova senha primeiro';
	header('location: '.$path);
	exit();
}
