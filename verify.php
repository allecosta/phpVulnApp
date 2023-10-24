<?php

require_once 'includes/session.php';

$conn = $pdo->open();

if (isset($_POST['login'])) {
	
	$email = $_POST['email'];
	$password = $_POST['password'];

	try {
		$sql = "SELECT *, COUNT(*) AS numrows FROM users WHERE email = :email";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['email' => $email]);
		$row = $stmt->fetch();

		if ($row['numrows'] > 0) {
			if ($row['status']) {
				if (password_verify($password, $row['password'])) {
					if ($row['type']) {
						$_SESSION['admin'] = $row['id'];

					} else {
						$_SESSION['user'] = $row['id'];
					}

				} else {
					$_SESSION['error'] = 'Senha incorreta.';
				}

			} else {
				$_SESSION['error'] = 'Conta não ativada.';
			}

		} else {
			$_SESSION['error'] = 'Email não encontrado.';
		}

	} catch(PDOException $e) {
		echo "OPS! Há algum problema da conexão: " . $e->getMessage();
	}

} else {
	$_SESSION['error'] = 'Insira credenciais de login primeiro.';
}

$pdo->close();

header('location: login.php');
exit();
