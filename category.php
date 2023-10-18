<?php 

require_once 'includes/session.php';

$slug = $_GET['category'];
$conn = $pdo->open();

try {
	$sql = "SELECT * FROM category WHERE cat_slug = :slug";
	$stmt = $conn->prepare($sql);
	$stmt->execute(['slug' => $slug]);
	$category = $stmt->fetch();
	$categoryID = $category['id'];

} catch(PDOException $e) {
	echo "OPS! Há algum problema na conexão: " . $e->getMessage();
}

$pdo->close();


require_once 'includes/header.php'; 

?>

<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">

		<?php require 'includes/navbar.php'; ?>
		
		<div class="content-wrapper">
			<div class="container">
				<section class="content">
					<div class="row">
						<div class="col-sm-9">
							<h1 class="page-header"><?= $category['name']; ?></h1>
							<?php
								
							$conn = $pdo->open();

							try {
								$inc = 3;
								$sql = "SELECT * FROM products WHERE category_id = :categoryID";	
								$stmt = $conn->prepare($sql);
								$stmt->execute(['categoryID' => $categoryID]);

								foreach ($stmt as $row) {
									$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
									$inc = ($inc == 3) ? 1 : $inc + 1;

									if ($inc == 1) echo "<div class='row'>";
									echo "
										<div class='col-sm-4'>
											<div class='box box-solid'>
												<div class='box-body prod-body'>
													<img src='".$image."' width='100%' height='230px' class='thumbnail'>
													<h5><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></h5>
												</div>
												<div class='box-footer'>
													<b>&#36; ".number_format($row['price'], 2)."</b>
												</div>
											</div>
										</div>
									";

									if ($inc == 3) echo "</div>";
								}

								if($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>"; 
								if($inc == 2) echo "<div class='col-sm-4'></div></div>";

							} catch(PDOException $e) {
								echo "OPS! Há algum problema na conexão: " . $e->getMessage();
							}

							$pdo->close();

							?> 
						</div>
						<div class="col-sm-3">
							<?php require 'includes/sidebar.php'; ?>
						</div>
					</div>
				</section>
			</div>
		</div>
	
		<?php require 'includes/footer.php'; ?>

	</div>

	<?php require_once 'includes/scripts.php'; ?>

</body>
</html>