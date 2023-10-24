<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'includes/session.php';

if (isset($_POST['signup'])) {
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$rePassword = $_POST['repassword'];

	$_SESSION['firstname'] = $firstname;
	$_SESSION['lastname'] = $lastname;
	$_SESSION['email'] = $email;

	if (!isset($_SESSION['captcha'])) {
		require 'recaptcha/src/autoload.php';		
		// $recaptcha = new \ReCaptcha\ReCaptcha('6LcxXmIaAAAAAFSY6wjaHDl65lmpTyXu-iBYBhp3', new \ReCaptcha\RequestMethod\SocketPost());
		$recaptcha = new \ReCaptcha\ReCaptcha('6LcxXmIaAAAAAFSY6wjaHDl65lmpTyXu-iBYBhp3');
		$resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])
					->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		// $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

		if (!$resp->isSuccess()) {
			$_SESSION['error'] = 'Favor responda o recaptcha corretamente';
			header('location: signup.php');	
			exit();

		} else {
			$_SESSION['captcha'] = time() + (10 * 60);
		}

	}

	if ($password != $rePassword) {
		$_SESSION['error'] = 'As senhas não correspondem';
		header('location: signup.php');
		exit();

	} else {
		$conn = $pdo->open();
		$sql = "SELECT COUNT(*) AS numrows FROM users WHERE email=:email";
		$stmt = $conn->prepare($sql);
		$stmt->execute(['email'=> $email]);
		$row = $stmt->fetch();

		if ($row['numrows'] > 0) {
			$_SESSION['error'] = 'Email já recebido';
			header('location: signup.php');
			exit();

		} else {
			$now = date('Y-m-d');
			$password = password_hash($password, PASSWORD_DEFAULT);

			//Gerar código
			$set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$code=substr(str_shuffle($set), 0, 12);

			try {
				$sql = "INSERT INTO 
							users (email, password, firstname, lastname, activate_code, created_on) 
						VALUES 
							(:email, :password, :firstname, :lastname, :code, :now)"
						;

				$stmt = $conn->prepare($sql);
				$stmt->execute([
								'email' => $email, 
								'password' => $password, 
								'firstname' => $firstname, 
								'lastname' => $lastname, 
								'code' => $code, 
								'now' => $now
							]);
							
				$userid = $conn->lastInsertId();

				$message = "
					<h2>Obrigado por se registrar.</h2>
					<p>Sua conta/p>
					<p>Email: ".$email."</p>
					<p>Senha: ".$_POST['password']."</p>
					<p>Clique no link abaixo para ativar sua conta.</p>
					<a href='http://localhost/techshop/activate.php?code=".$code."&user=".$userid."'>Ativar conta</a>
				";

				//Carregar phpmailer
				require 'vendor/autoload.php';

				$mail = new PHPMailer(true);
				
				// Configuração do server
				try {
					$mail->isSMTP();                                     
					$mail->Host = 'smtp.gmail.com';                      
					$mail->SMTPAuth = true;                               
					$mail->Username = '';     
					$mail->Password = '';                    
					$mail->SMTPOptions = [
						'ssl' => [
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
						]
					];                         
					$mail->SMTPSecure = 'ssl';                           
					$mail->Port = 465;                                   

					$mail->setFrom('testsourcecodester@gmail.com');
					
					//Destinatários
					$mail->addAddress($email);              
					$mail->addReplyTo('testsourcecodester@gmail.com');
					
					//Conteudo
					$mail->isHTML(true);                                  
					$mail->Subject = 'Techshop e-commerce. Inscreva-se!';
					$mail->Body    = $message;

					$mail->send();

					unset($_SESSION['firstname']);
					unset($_SESSION['lastname']);
					unset($_SESSION['email']);

					$_SESSION['success'] = 'Conta criada! Verifique seu e-mail para ativar.';
					header('location: signup.php');
					exit();

				} catch (Exception $e) {
					$_SESSION['error'] = 'Não foi possível enviar a mensagem: '.$mail->ErrorInfo;
					header('location: signup.php');
					exit();
				}

			} catch(PDOException $e) {
				$_SESSION['error'] = $e->getMessage();
				header('location: register.php');
				exit();
			}

			$pdo->close();
		}
	}

} else {
	$_SESSION['error'] = 'Preencha o formulário de inscrição primeiro';
	header('location: signup.php');
	exit();
}
