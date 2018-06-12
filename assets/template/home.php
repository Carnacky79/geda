
<!-- Start content -->
<div class="content">
	<div class="container">

		<!-- Page-Title -->
		<div class="row">
			<?php if($livello_utente===1) { ?>
				<div class="col-lg-4 col-md-6">
					<a href="?pagina=prodotti_list" >
						<div class="card-box widget-user bg-info border-info">
							<i class="zmdi zmdi-coffee"></i>
							<div class="text-right">
								<h2><span>Prodotti</span></h2>
								<h5><?=$this->prodotti->count_records()->cnt;?></h5>
							</div>
						</div>
					</a>
				</div>
				<div class="col-lg-4 col-md-6">
					<a href="?pagina=categorie_list" >
						<div class="card-box widget-user bg-danger border-info">
							<i class="zmdi zmdi-device-hub"></i>
							<div class="text-right">
								<h2>Categorie</h2>
								<h5><?=$this->categorie->count_records()->cnt;?></h5>
							</div>
						</div>
					</a>
				</div>

				<div class="col-lg-4 col-md-6">
					<a href="?pagina=fornitori_list" >
						<div class="card-box widget-user bg-purple border-info">
							<i class="zmdi zmdi-accounts-alt"></i>
							<div class="text-right">
								<h2>Fornitori</h2>
								<h5><?=$this->fornitori->count_records()->cnt;?></h5>
							</div>
						</div>
					</a>
				</div>

				<div class="col-lg-4 col-md-6">
					<a href="?pagina=clienti_list" >
						<div class="card-box widget-user bg-purple border-info">
							<i class="zmdi zmdi-accounts-alt"></i>
							<div class="text-right">
								<h2>Clienti</h2>
								<h5><?=$this->clienti->count_records()->cnt;?></h5>
							</div>
						</div>
					</a>
				</div>


				<div class="col-lg-4 col-md-6">
					<a href="?pagina=fatture_list" >
						<div class="card-box widget-user bg-custom border-info">
							<i class="zmdi zmdi-file-tet"></i>
							<div class="text-right">
								<h2>Fatture</h2>
								<h5><?=$this->fatture->count_records()->cnt;?></h5>
							</div>
						</div>
					</a>
				</div>

				<div class="col-lg-4 col-md-6">
					<a href="?pagina=ddt_list" >
						<div class="card-box widget-user bg-custom border-info">
							<i class="zmdi zmdi-file-tet"></i>
							<div class="text-right">
								<h2>DDT</h2>
								<h5><?=$this->ddt->count_records()->cnt;?></h5>
							</div>
						</div>
					</a>
				</div>
			<?php } else if($livello_utente===2) { ?>
				<div class="col-lg-4 col-md-6">
					<a href="?pagina=giornate_today" >
						<div class="card-box widget-user bg-info border-info">
							<i class="zmdi zmdi-time"></i>
							<div class="text-right">
								<h2><span>Giornata odierna</span></h2>
							</div>
						</div>
					</a>
				</div>
			<?php } ?>
		</div>
		<!-- end row -->



	</div> <!-- container -->

</div> <!-- content -->



