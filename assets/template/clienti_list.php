<div class="container" menu_link="clienti_list" >


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
				<table id="tab_clienti" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Ragione sociale</th>
							<th>Comune</th>
							<th>Referente</th>
							<th>Telefono</th>
							<th>Email</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($this->record_clienti as $record) {
							?>
							<tr id_cliente="<?=$record->id_cliente;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
								<td><?=$record->nome;?></td>
								<td><?=$record->comune;?></td>
								<td><?=$record->referente;?></td>
								<td><?=$record->telefono;?></td>
								<td><?=$record->email;?></td>
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
