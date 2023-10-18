<?php 

require_once 'includes/session.php'; 
require 'includes/header.php'; 

?>

<body class="hold-transition skin-blue layout-top-nav">
	<div class="wrapper">

		<?php require_once 'includes/navbar.php'; ?>
		
		<div class="content-wrapper">
			<div class="container">
				<section class="content">
					<div class="row">
						<div class="col-sm-9">
							<h1 class="page-header">Seu Carrinho</h1>
							<div class="box box-solid">
								<div class="box-body">
								<table class="table table-bordered">
									<thead>
										<th></th>
										<th>Foto</th>
										<th>Nome</th>
										<th>Preço</th>
										<th width="20%">Quantidade</th>
										<th>Subtotal</th>
									</thead>
									<tbody id="tbody">
									</tbody>
								</table>
								</div>
							</div>
							<?php
								if (isset($_SESSION['user'])) {
									echo "<div id='paypal-button'></div>";
								} else {
									echo "<h4>Você precisa fazer <a href='login.php'>Login</a> para check-out.</h4>";
								}
							?>
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

		require 'includes/footer.php'; 
		
		?>
	</div>

	<?php require_once 'includes/scripts.php'; ?>

	<script>
		var total = 0;
		$(function() {
			$(document).on('click', '.cart_delete', function(e) {
				e.preventDefault();
				var id = $(this).data('id');
				$.ajax({
					type: 'POST',
					url: 'cart_delete.php',
					data: {id:id},
					dataType: 'json',
					success: function(response) {
						if (!response.error) {
							getDetails();
							getCart();
							getTotal();
						}
					}
				});
			});

			$(document).on('click', '.minus', function(e) {
				e.preventDefault();
				var id = $(this).data('id');
				var qty = $('#qty_'+id).val();
				if (qty > 1) {
					qty--;
				}
				$('#qty_'+id).val(qty);
				$.ajax({
					type: 'POST',
					url: 'cart_update.php',
					data: {
						id: id,
						qty: qty,
					},
					dataType: 'json',
					success: function(response) {
						if (!response.error) {
							getDetails();
							getCart();
							getTotal();
						}
					}
				});
			});

			$(document).on('click', '.add', function(e) {
				e.preventDefault();
				var id = $(this).data('id');
				var qty = $('#qty_'+id).val();
				qty++;
				$('#qty_'+id).val(qty);
				$.ajax({
					type: 'POST',
					url: 'cart_update.php',
					data: {
						id: id,
						qty: qty,
					},
					dataType: 'json',
					success: function(response) {
						if (!response.error) {
							getDetails();
							getCart();
							getTotal();
						}
					}
				});
			});

			getDetails();
			getTotal();

		});

		function getDetails() {
			$.ajax({
				type: 'POST',
				url: 'cart_details.php',
				dataType: 'json',
				success: function(response) {
					$('#tbody').html(response);
					getCart();
				}
			});
		}

		function getTotal() {
			$.ajax({
				type: 'POST',
				url: 'cart_total.php',
				dataType: 'json',
				success:function(response) {
					total = response;
				}
			});
		}
	</script>

	<!-- Paypal Express -->
	<script>
		paypal.Button.render({
			
			// Mudança para produção se o aplicativo estiver ativo
			env: 'sandbox', 

			client: {
				sandbox:    'AEfYxns5l1tnCle5stC4-vpS0mg4ABwESySCOSq9CsW7wff3Ehr5LeGA',
				//production: 'AaBHKJFEej4V6yaArjzSx9cuf-UYesQYKqynQVCdBlKuZKawDDzFyuQdidPOBSGEhWaNQnnvfzuFB9SM'
			},

			// Mostrar botao 'Pagar agora'
			commit: true, 
			style: {
				color: 'gold',
				size: 'small'
			},

			payment: function(data, actions) {
				return actions.payment.create({
					payment: {
						transactions: [
							{
								// Compra total
								amount: { 
									total: total, 
									currency: 'USD' 
								}
							}
						]
					}
				});
			},

			onAuthorize: function(data, actions) {
				return actions.payment.execute().then(function(payment) {
					window.location = 'sales.php?pay='+payment.id;
				});
			},

		}, '#paypal-button');
	</script>
</body>
</html>