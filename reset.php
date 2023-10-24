<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'includes/session.php';

if (isset($_POST['reset'])) {
	$email = $_POST['email'];

	$conn = $pdo->open();

	$sql = "SELECT *, COUNT(*) AS numrows FROM users WHERE email = :email"; 
	$stmt = $conn->prepare($sql);
	$stmt->execute(['email'=>$email]);
	$row = $stmt->fetch();

	if ($row['numrows'] > 0) {
		//Gerar código
		$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 15);

		try {
			$sql = "UPDATE users SET reset_code = :code WHERE id = :id";
			$stmt = $conn->prepare($sql);
			$stmt->execute(['code' => $code, 'id' => $row['id']]);
			
			$message = "
				<h2>Redifinição de Senha</h2>
				<p>Sua conta:</p>
				<p>Email: ".$email."</p>
				<p>Clique no link abaixo para redefinir a sua senha.</p>
				<a href='http://localhost/techshop/password_reset.php?code=".$code."&user=".$row['id']."'>Redefinir senha</a>
			";

			//Carregando phpmailer
			require 'vendor/autoload.php';

			$mail = new PHPMailer(true);

			try {
				//Configurações do server
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
				$mail->Subject = 'Techshop e-commerce. Resetar senha!';
				$mail->Body    = $message;

				$mail->send();

				$_SESSION['success'] = 'Link de redefinição de senha enviado.';
				
			} catch (Exception $e) {
				$_SESSION['error'] = 'OPS! Não foi possivel enviar a mensagem: '.$mail->ErrorInfo;
			}

		} catch(PDOException $e) {
			$_SESSION['error'] = $e->getMessage();
		}

	} else {
		$_SESSION['error'] = 'Email não encontrado';
	}

	$pdo->close();

} else {
	$_SESSION['error'] = 'Insira o e-mail associado à conta.';
}

header('location: password_forgot.php');
exit();
