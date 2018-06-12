<div class="container" menu_link="giornate_list" >


	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?php if($livello_utente===1) { ?>
				<button type="button" class="btn btn-info waves-effect waves-light add_new" aria-expanded="false"><span class="m-r-10"><i class="fa fa-plus"></i></span>Inizia nuova giornata</button>
				<?php } ?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="card-box">
				<table id="tab_giornate" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Data</th>
							<th>Location</th>
							<th>Numero transazioni</th>
							<th>Totale quantità</th>
							<th>Totale incassi</th>
							<th>Stato</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($this->record_giornate as $record) {

							if($livello_utente!==1 && utility::dati_utente()->id_location!=$record->id_location) { continue; }


							switch ($record->stato) {
								case 0:
									$stato = 'Conclusa';
									$sblocco = '<i class="fa fa-oepn openIcon" aria-hidden="true"></i>';
									break;
								case 1:
									$stato = 'Aperta';
									$sblocco = '';
									break;
							}
							?>
							<tr id_giornata="<?=$record->id_giornata;?>" giorno="<?=$record->giorno;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i><?=$sblocco;?></td>
								<td><?=utility::toUIDate($record->giorno);?></td>
								<td><?=$record->location;?></td>
								<td class="right-in" ><?=$record->numero;?></td>
								<td class="right-in" ><?=$record->quantita;?></td>
								<td class="right-in" ><?=$record->incassi;?></td>
								<td><?=$stato;?></td>
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
