<div class="container" menu_link="servizi_list" >


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
				<table id="tab_servizi" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Nome</th>
							<th>Codice</th>
							<th>Categoria</th>
							<th>Fornitore</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($this->record_servizi as $record) {
							?>
							<tr id_servizio="<?=$record->id_servizio;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
								<td class="action_col" ><?=$record->nome;?></td>
								<td class="action_col" ><?=$record->codice;?></td>
								<td class="action_col" ><?=$record->categoria;?></td>
								<td class="action_col" ><?=$record->fornitore;?></td>
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
