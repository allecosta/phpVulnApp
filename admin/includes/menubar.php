<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= (!empty($admin['photo'])) ? '../images/'.$admin['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="Imagem do usuario">
            </div>
            <div class="pull-left info">
                <p><?= $admin['firstname'].' '.$admin['lastname']; ?></p>
                <a><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Relatórios</li>
            <li><a href="home.php"><i class="fa fa-dashboard"></i> <span>Painel</span></a></li>
            <li><a href="sales.php"><i class="fa fa-money"></i> <span>Vendas</span></a></li>
            <li class="header">Gerenciar</li>
            <li><a href="users.php"><i class="fa fa-users"></i> <span>Usuários</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-barcode"></i>
                    <span>Produtos</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="products.php"><i class="fa fa-circle-o"></i> Produtos</a></li>
                    <li><a href="category.php"><i class="fa fa-circle-o"></i> Categoria</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>