<?php

require 'includes/session.php';
require_once 'includes/header.php';

?>

<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">

		<?php require_once 'includes/navbar.php'; ?>

		<div class="content-wrapper">
			<div class="container">
				<section class="content">
					<div class="row">
						<div class="col-sm-9">
							<?php

							$conn = $pdo->open();

							$sql = "SELECT COUNT(*) AS numrows FROM products WHERE name LIKE :keyword";
							$stmt = $conn->prepare($sql);
							$stmt->execute(['keyword' => '%' . $_POST['keyword'] . '%']);
							$row = $stmt->fetch();

							if ($row['numrows'] < 1) {
								echo '<h1 class="page-header">Nenhum resultado encontrado para <i>' . $_POST['keyword'] . '</i></h1>';
							} else {
								echo '<h1 class="page-header">Buscar resultados por <i>' . $_POST['keyword'] . '</i></h1>';

								try {
									$inc = 3;
									$sql = "SELECT * FROM products WHERE name LIKE :keyword";
									$stmt = $conn->prepare($sql);
									$stmt->execute(['keyword' => '%' . $_POST['keyword'] . '%']);

									foreach ($stmt as $row) {
										$highlighted = preg_filter('/' . preg_quote($_POST['keyword'], '/') . '/i', '<b>$0</b>', $row['name']);
										$image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
										$inc = ($inc == 3) ? 1 : $inc + 1;

										if ($inc == 1) echo "<div class='row'>";
										echo "
											<div class='col-sm-4'>
												<div class='box box-solid'>
													<div class='box-body prod-body'>
														<img src='" . $image . "' width='100%' height='230px' class='thumbnail'>
														<h5><a href='product.php?product=" . $row['slug'] . "'>" . $highlighted . "</a></h5>
													</div>
													<div class='box-footer'>
														<strong>&#82;&#36; " . number_format($row['price'], 2, ',') . "</strong>
													</div>
												</div>
											</div>
										";

										if ($inc == 3) echo "</div>";
									}

									if ($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>";
									if ($inc == 2) echo "<div class='col-sm-4'></div></div>";
								} catch (PDOException $e) {
									echo "OPS! Há algum problema de conexão: " . $e->getMessage();
								}
							}

							$pdo->close();

							?>
						</div>
						<div class="col-sm-3">
							<?php require_once 'includes/sidebar.php'; ?>
						</div>
					</div>
				</section>
			</div>
		</div>

		<?php require_once 'includes/footer.php'; ?>

	</div>

	<?php require 'includes/scripts.php'; ?>

</body>

</html>