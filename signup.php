<?php require 'includes/signup_view.php'; ?>

<body class="hold-transition register-page">
    <div class="register-box">
        <?php

        if (isset($_SESSION['error'])) {
            echo "
            <div class='callout callout-danger text-center'>
                <p>" . $_SESSION['error'] . "</p> 
            </div>
            ";

            unset($_SESSION['error']);
        }

        if (isset($_SESSION['success'])) {
            echo "
            <div class='callout callout-success text-center'>
                <p>" . $_SESSION['success'] . "</p> 
            </div>
            ";

            unset($_SESSION['success']);
        }

        ?>

        <div class="register-box-body">
            <p class="login-box-msg">Registre um novo membro</p>
            <form action="register.php" method="POST">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="firstname" placeholder="Nome" value="<?= (isset($_SESSION['firstname'])) ? $_SESSION['firstname'] : '' ?>" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="lastname" placeholder="Sobrenome" value="<?= (isset($_SESSION['lastname'])) ? $_SESSION['lastname'] : '' ?>" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?= (isset($_SESSION['email'])) ? $_SESSION['email'] : '' ?>" autocomplete="off" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Senha" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="repassword" placeholder="Digite novamente a senha" required>
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>

                <?php

                if (!isset($_SESSION['captcha'])) {
                    echo '
                        <div class="form-group" style="width:100%;">
                            <div class="g-recaptcha" data-sitekey="6LcxXmIaAAAAAFv3FBdhdKAAZ3vILm5SgSZFH94P"></div>
                        </div>
                    ';
                }

                ?>
                <hr>

                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="signup"><i class="fa fa-pencil"></i> Increva-se</button>
                    </div>
                </div>
            </form><br>
            <a href="login.php">Já sou membro</a><br>
            <a href="index.php"><i class="fa fa-home"></i> Loja</a>
        </div>
    </div>

    <?php require 'includes/scripts.php' ?>

</body>

</html>