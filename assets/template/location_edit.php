<div class="container" menu_link="location_list" >

	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?=$this->btn_salva;?><?=$this->btn_elimina;?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>

	<?=$this->form_start;?>

	<input type="hidden" id="id_location" name="id_location" >

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="nome" >Nome</label>
				<div class="col-md-10" required >
					<input type="text" id="nome" name="nome" class="form-control" data-parsley-required >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="id_cliente" >Cliente associato</label>
				<div class="col-md-10" >
					<select id="id_cliente" name="id_cliente" class="form-control" >
						<option value="" ></option>
						<?php
						foreach ($this->record_clienti as $cliente) {
							?>
							<option value="<?=$cliente->id_cliente;?>" ><?=$cliente->nome;?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="id_categoria" >Categoria</label>
				<div class="col-md-10" required >
					<select id="id_categoria" name="id_categoria" class="form-control" data-parsley-required >
						<option value="" ></option>
						<?php
						foreach ($this->record_categorie as $categoria) {
							?>
							<option value="<?=$categoria->id_categoria;?>" ><?=$categoria->nome;?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
	</div>

	<?=$this->form_end;?>


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


								if(isset($this->record_giacenze->{$record->id_prodotto})) {
									$record->qta_residua = $this->record_giacenze->{$record->id_prodotto}->quantita;
								} else {
									$record->qta_residua = 0;
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

</div>

