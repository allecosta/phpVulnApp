<header class="main-header">
    <a href="#" class="logo">
        <span class="logo-mini"><strong>T</Strong>S</span>
        <span class="logo-lg"><strong>Tech</strong>Shop</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Alternar Navegação</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= (!empty($admin['photo'])) ? '../images/'.$admin['photo'] : '../images/profile.jpg'; ?>" class="user-image" alt="Imagem do usuário">
                        <span class="hidden-xs"><?= $admin['firstname'].' '.$admin['lastname']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="<?= (!empty($admin['photo'])) ? '../images/'.$admin['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="Imagem do usuário">
                            <p>
                                <?= $admin['firstname'].' '.$admin['lastname']; ?>
                                <small>Membro Desde <?= date('M. Y', strtotime($admin['created_on'])); ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#profile" data-toggle="modal" class="btn btn-default btn-flat" id="admin_profile">Atualizar</a>
                            </div>
                            <div class="pull-right">
                                <a href="../logout.php" class="btn btn-default btn-flat">Sair</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<?php require 'includes/profile_modal.php'; ?>