<?php require 'includes/product_view.php'; ?>

<body class="hold-transition skin-blue layout-top-nav">
	<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s);
			js.id = id;
			js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12';
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<div class="wrapper">

		<?php require_once 'includes/navbar.php'; ?>

		<div class="content-wrapper">
			<div class="container">
				<section class="content">
					<div class="row">
						<div class="col-sm-9">
							<div class="callout" id="callout" style="display:none">
								<button type="button" class="close"><span aria-hidden="true">&times;</span></button>
								<span class="message"></span>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<img src="<?= (!empty($product['photo'])) ? 'images/' . $product['photo'] : 'images/noimage.jpg'; ?>" width="100%" class="zoom" data-magnify-src="images/large-<?= $product['photo']; ?>">
									<br><br>
									<form class="form-inline" id="productForm">
										<div class="form-group">
											<div class="input-group col-sm-5">
												<span class="input-group-btn">
													<button type="button" id="minus" class="btn btn-default btn-flat btn-lg"><i class="fa fa-minus"></i></button>
												</span>
												<input type="text" name="quantity" id="quantity" class="form-control input-lg" value="1">
												<span class="input-group-btn">
													<button type="button" id="add" class="btn btn-default btn-flat btn-lg"><i class="fa fa-plus"></i></button>
												</span>
												<input type="hidden" value="<?= $product['prodid']; ?>" name="id">
											</div>
											<button type="submit" class="btn btn-primary btn-lg btn-flat"><i class="fa fa-shopping-cart"></i> Adicionar ao carrinho</button>
										</div>
									</form>
								</div>
								<div class="col-sm-6">
									<h1 class="page-header"><?= $product['prodname']; ?></h1>
									<h3><strong>&#36; <?= number_format($product['price'], 2); ?></strong></h3>
									<p><strong>Categoria:</strong> <a href="category.php?category=<?= $product['cat_slug']; ?>"><?= $product['catname']; ?></a></p>
									<p><strong>Descrição:</strong></p>
									<p><?= $product['description']; ?></p>
								</div>
							</div><br>
							<div class="fb-comments" data-href="http://localhost/techshop/product.php?product=<?= $slug; ?>" data-numposts="10" width="100%"></div>
						</div>
						<div class="col-sm-3">
							<?php require 'includes/sidebar.php'; ?>
						</div>
					</div>
				</section>
			</div>
		</div>

		<?php

		$pdo->close();

		require_once 'includes/footer.php';

		?>

	</div>

	<?php require 'includes/scripts.php'; ?>

	<script>
		$(function() {
			$('#add').click(function(e) {
				e.preventDefault();
				var quantity = $('#quantity').val();
				quantity++;
				$('#quantity').val(quantity);
			});
			$('#minus').click(function(e) {
				e.preventDefault();
				var quantity = $('#quantity').val();
				if (quantity > 1) {
					quantity--;
				}
				$('#quantity').val(quantity);
			});
		});
	</script>
</body>

</html>