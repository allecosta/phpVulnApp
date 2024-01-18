<?php require 'includes/cart_view.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<?php

		require_once 'includes/navbar.php';
		require_once 'includes/menubar.php';

		?>

		<div class="content-wrapper">
			<section class="content-header">
				<h1><?= $user['firstname'] . ' ' . $user['lastname'] . '`s Cart' ?></h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Início</a></li>
					<li>Usuários</li>
					<li class="active">Carrinho</li>
				</ol>
			</section>
			<section class="content">
				<?php

				if (isset($_SESSION['error'])) {
					echo "
						<div class='alert alert-danger alert-dismissible'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							<h4><i class='icon fa fa-warning'></i> Error!</h4>
							" . $_SESSION['error'] . "
						</div>
					";
					unset($_SESSION['error']);
				}

				if (isset($_SESSION['success'])) {
					echo "
						<div class='alert alert-success alert-dismissible'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							<h4><i class='icon fa fa-check'></i> Success!</h4>
							" . $_SESSION['success'] . "
						</div>
					";

					unset($_SESSION['success']);
				}

				?>

				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header with-border">
								<a href="#addnew" data-toggle="modal" id="add" data-id="<?= $user['id']; ?>" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> Novo</a>
								<a href="users.php" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Usuários</a>
							</div>
							<div class="box-body">
								<table id="example1" class="table table-bordered">
									<thead>
										<th>Produto</th>
										<th>Quantidade</th>
										<th>Tools</th>
									</thead>
									<tbody>
										<?php

										$conn = $pdo->open();

										try {
											$sql = "SELECT 
														*, cart.id AS cartid 
													FROM 
														cart 
													LEFT JOIN 
														products ON products.id = cart.product_id 
													WHERE 
														user_id = :user_id
													";

											$stmt = $conn->prepare($sql);
											$stmt->execute(['user_id' => $user['id']]);

											foreach ($stmt as $row) {
												echo "
													<tr>
														<td>" . $row['name'] . "</td>
														<td>" . $row['quantity'] . "</td>
														<td>
															<button class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['cartid'] . "'><i class='fa fa-edit'></i> Editar</button>
															<button class='btn btn-danger btn-sm delete btn-flat' data-id='" . $row['cartid'] . "'><i class='fa fa-trash'></i> Excluir</button>
														</td>
													</tr>
												";
											}
										} catch (PDOException $e) {
											echo $e->getMessage();
										}

										$pdo->close();

										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<?php

		require_once 'includes/footer.php';
		require 'includes/cart_modal.php';

		?>

	</div>

	<?php require 'includes/scripts.php'; ?>

	<script>
		$(function() {
			$(document).on('click', '.edit', function(e) {
				e.preventDefault();
				$('#edit').modal('show');
				var id = $(this).data('id');
				getRow(id);
			});

			$(document).on('click', '.delete', function(e) {
				e.preventDefault();
				$('#delete').modal('show');
				var id = $(this).data('id');
				getRow(id);
			});

			$('#add').click(function(e) {
				e.preventDefault();
				var id = $(this).data('id');
				getProducts(id);
			});

			$("#addnew").on("hidden.bs.modal", function() {
				$('.append_items').remove();
			});
		});

		function getProducts(id) {
			$.ajax({
				type: 'POST',
				url: 'products_all.php',
				dataType: 'json',
				success: function(response) {
					$('#product').append(response);
					$('.userid').val(id);
				}
			});
		}

		function getRow(id) {
			$.ajax({
				type: 'POST',
				url: 'cart_row.php',
				data: {
					id: id
				},
				dataType: 'json',
				success: function(response) {
					$('.cartid').val(response.cartid);
					$('.userid').val(response.user_id);
					$('.productname').html(response.name);
					$('#edit_quantity').val(response.quantity);
				}
			});
		}
	</script>
</body>

</html>