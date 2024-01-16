<?php

require_once 'includes/session.php';
require_once 'includes/activate_view.php';
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
							<?= $output; ?>
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