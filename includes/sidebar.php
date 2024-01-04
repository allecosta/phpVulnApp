<div class="row">
	<div class="box box-solid">
	  	<div class="box-header with-border">
	    	<h3 class="box-title"><strong>Mais Visto hoje</strong></h3>
	  	</div>
	  	<div class="box-body">
	  		<ul id="trending">
				<?php

				$now = date('Y-m-d');

				$conn = $pdo->open();

				$sql = "SELECT * FROM products WHERE date_view = :now ORDER BY counter DESC LIMIT 10";
				$stmt = $conn->prepare($sql);
				$stmt->execute(['now' => $now]);

				foreach($stmt as $row) {
					echo "<li><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></li>";
				}

				$pdo->close();
				
				?>
	    	<ul>
	  	</div>
	</div>
</div>
<div class="row">
	<div class="box box-solid">
	  	<div class="box-header with-border">
	    	<h3 class="box-title"><strong>Torne-se um Assinante</strong></h3>
	  	</div>
	  	<div class="box-body">
	    	<p>Receba atualizações gratuitas sobre os produtos e descontos mais recentes diretamente na sua caixa de email.</p>
	    	<form method="POST" action="">
		    	<div class="input-group">
	                <input type="text" class="form-control">
	                <span class="input-group-btn">
	                    <button type="button" class="btn btn-info btn-flat"><i class="fa fa-envelope"></i> </button>
	                </span>
	            </div>
		    </form>
	  	</div>
	</div>
</div>
<div class="row">
	<div class='box box-solid'>
	  	<div class='box-header with-border'>
	    	<h3 class='box-title'><strong>Siga-nos nas redes sociais</strong></h3>
	  	</div>
	  	<div class='box-body'>
	    	<a class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
	    	<a class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
	    	<a class="btn btn-social-icon btn-instagram"><i class="fa fa-instagram"></i></a>
	    	<a class="btn btn-social-icon btn-linkedin"><i class="fa fa-linkedin"></i></a>
	  	</div>
	</div>
</div>
