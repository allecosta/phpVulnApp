<?php 

require_once 'includes/session.php';

if (isset($_SESSION['user'])) {
  header('location: cart_view.php');
  exit();
}

require 'includes/header.php'; 

?>

<body class="hold-transition login-page">
	<div class="login-box">
		<?php

		if (isset($_SESSION['error'])) {
			echo "
			<div class='callout callout-danger text-center'>
				<p>".$_SESSION['error']."</p> 
			</div>
			";

			unset($_SESSION['error']);
		}

		if (isset($_SESSION['success'])) {
			echo "
			<div class='callout callout-success text-center'>
				<p>".$_SESSION['success']."</p> 
			</div>
			";

			unset($_SESSION['success']);
		}

		?>

		<div class="login-box-body">
			<p class="login-box-msg">Faça login para iniciar sua sessão</p>

			<form action="verify.php" method="POST">
				<div class="form-group has-feedback">
					<input type="email" class="form-control" name="email" placeholder="Email" autocomplete="off" required>
					<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" class="form-control" name="password" placeholder="Senha" required>
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<button type="submit" class="btn btn-primary btn-block btn-flat" name="login"><i class="fa fa-sign-in"></i> Entrar</button>
					</div>
				</div>
			</form>
		<br>
		<a href="password_forgot.php">Esqueci minha senha</a><br>
		<a href="signup.php" class="text-center">Registre uma nova conta</a><br>
		<a href="index.php"><i class="fa fa-home"></i> Loja</a>
		</div>
	</div>
	
	<?php require_once 'includes/scripts.php' ?>

</body>
</html>