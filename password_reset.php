<?php 

require_once 'includes/session.php';

if (!isset($_GET['code']) OR !isset($_GET['user'])) {
  header('location: index.php');
  exit(); 
}

require 'includes/header.php'; ?>

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

        ?>
        <div class="login-box-body">
            <p class="login-box-msg">Entre com uma nova senha</p>
            <form action="password_new.php?code=<?= $_GET['code']; ?>&user=<?= $_GET['user']; ?>" method="POST">
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Nova senha" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="repassword" placeholder="Digite novamente a senha" required>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="reset"><i class="fa fa-check-square-o"></i> Resetar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        
    <?php include 'includes/scripts.php' ?>

</body>
</html>