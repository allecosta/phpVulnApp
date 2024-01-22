<header class="main-header">
	<nav class="navbar navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<a href="index.php" class="navbar-brand"><strong>Tech</strong>Shop</a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
			</div>
			<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="index.php">LOJA</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">CATEGORIA
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<?php

							$conn = $pdo->open();

							try {
								$sql = "SELECT * FROM category";
								$stmt = $conn->prepare($sql);
								$stmt->execute();

								foreach ($stmt as $row) {
									echo "
										<li><a href='category.php?category=" . $row['cat_slug'] . "'>" . $row['name'] . "</a></li>
									";
								}
							} catch (PDOException $e) {
								echo "OPS! Há algum problema na conexão: " . $e->getMessage();
							}

							$pdo->close();

							?>
						</ul>
					</li>
					<li><a href="">QUEM SOMOS</a></li>
					<li><a href="">CONTATO</a></li>
				</ul>
				<form method="POST" class="navbar-form navbar-left" action="search.php">
					<div class="input-group">
						<input type="text" class="form-control" id="navbar-search-input" name="keyword" placeholder="Pesquisar por produto" required>
						<span class="input-group-btn" id="searchBtn" style="display:none;">
							<button type="submit" class="btn btn-default btn-flat"><i class="fa fa-search"></i> </button>
						</span>
					</div>
				</form>
			</div>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown messages-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-shopping-cart"></i>
							<span class="label label-success cart_count"></span>
						</a>
						<ul class="dropdown-menu">
							<li class="header">Você tem <span class="cart_count"></span> item(s) no carrinho</li>
							<li>
								<ul class="menu" id="cart_menu"></ul>
							</li>
							<li class="footer"><a href="cart_view.php">Ir para o carrinho</a></li>
						</ul>
					</li>
					<?php

					if (isset($_SESSION['user'])) {
						$image = (!empty($user['photo'])) ? 'images/' . $user['photo'] : 'images/profile.jpg';

						echo '
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="' . $image . '" class="user-image" alt="User Image">
									<span class="hidden-xs">' . $user['firstname'] . ' ' . $user['lastname'] . '</span>
								</a>
								<ul class="dropdown-menu">
									<li class="user-header">
										<img src="' . $image . '" class="img-circle" alt="Imagem do usuario">
										<p>
											' . $user['firstname'] . ' ' . $user['lastname'] . '
											<small>Membro desde ' . date('M. Y', strtotime($user['created_on'])) . '</small>
										</p>
									</li>
									<li class="user-footer">
										<div class="pull-left">
											<a href="profile.php" class="btn btn-default btn-flat">Perfil</a>
										</div>
										<div class="pull-right">
											<a href="logout.php" class="btn btn-default btn-flat">Sair</a>
										</div>
									</li>
								</ul>
							</li>
						';
					} else {
						echo "
							<li><a href='login.php'>Entrar</a></li>
							<li><a href='signup.php'>Inscreva-se</a></li>
						";
					}

					?>
				</ul>
			</div>
		</div>
	</nav>
</header>