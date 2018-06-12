<div class="container" menu_link="prodotti_list" >


	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?php if($livello_utente===1) { ?>
					<button type="button" class="btn btn-info waves-effect waves-light add_new" aria-expanded="false"><span class="m-r-10"><i class="fa fa-plus"></i></span>Aggiungi</button>
				<?php } ?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="card-box">
				<label class="col-md-10 control-label" for="tab_prodotti_presenti" >Prodotti presenti</label>
				<table id="tab_prodotti_presenti" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Nome</th>
							<th>Codice</th>
							<th>Categoria</th>
							<th>Fornitore</th>
							<th>Qta</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($this->record_prodotti as $record) {

							if($livello_utente!==1) {
								if(isset($this->record_giacenze->{$record->id_prodotto})) {
									$record->qta_residua = $this->record_giacenze->{$record->id_prodotto}->quantita;
								} else {
									$record->qta_residua = 0;
								}
							}


							if($record->qta_residua>0) {
								$qta = $record->qta_residua;

							} else {

								continue;
							}



							$fornitori = $this->prodotti->getFornitoriAssociati($record->id_prodotto);

							if(count($fornitori)>1) {
								$col = count($fornitori).' fornitori';
							} else if(count($fornitori)==1) {
								$col = $fornitori[0]->nome;
							} else {
								$col = '-';
							}

							?>
							<tr id_prodotto="<?=$record->id_prodotto;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
								<td><?=$record->nome;?></td>
								<td><?=$record->codice;?></td>
								<td><?=$record->categoria;?></td>
								<td><?=$col;?></td>
								<td class="right-in" ><?=$qta;?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>





	<div class="row">
		<div class="col-sm-12">
			<div class="card-box">
				<label class="col-md-10 control-label" for="tab_prodotti_mancanti" >Prodotti mancanti</label>
				<table id="tab_prodotti_mancanti" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
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
						foreach ($this->record_prodotti as $record) {

							if($livello_utente!==1) {
								if(isset($this->record_giacenze->{$record->id_prodotto})) {
									$record->qta_residua = $this->record_giacenze->{$record->id_prodotto}->quantita;
								} else {
									$record->qta_residua = 0;
								}
							}


							if($record->qta_residua>0) {
								continue;
							}


							$fornitori = $this->prodotti->getFornitoriAssociati($record->id_prodotto);

							if(count($fornitori)>1) {
								$col = count($fornitori).' fornitori';
							} else if(count($fornitori)==1) {
								$col = $fornitori[0]->nome;
							} else {
								$col = '-';
							}

							?>
							<tr id_prodotto="<?=$record->id_prodotto;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
								<td><?=$record->nome;?></td>
								<td><?=$record->codice;?></td>
								<td><?=$record->categoria;?></td>
								<td><?=$col;?></td>
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
