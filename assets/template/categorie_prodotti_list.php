<div class="container">


	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<button type="button" class="btn btn-info waves-effect waves-light add_new" aria-expanded="false"><span class="m-r-10"><i class="fa fa-plus"></i></span>Aggiungi</button>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="card-box">
				<table id="tab_categorie_prodotti" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Nome</th>
							<th>Prodotti</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($this->record_categorie_prodotti as $record) {
							?>
							<tr id_categoria_prodotto="<?=$record->id_categoria_prodotto;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
								<td><?=$record->nome;?></td>
								<td><?=$record->cnt;?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>


</div>