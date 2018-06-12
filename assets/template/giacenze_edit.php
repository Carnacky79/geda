<!--<div class="container" menu_link="prodotti_list" >-->
<div class="container" >

	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?=$this->btn_salva;?><?=$this->btn_elimina;?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>


	<div class="hidden" id="record_fornitori" name="record_fornitori" ><?=$this->json_fornitori;?></div>

	<?=$this->form_start;?>

	<input type="hidden" id="id_prodotto" name="id_prodotto" >


	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="nome" >Nome</label>
				<div class="col-md-10" required >
					<input type="text" id="nome" name="nome" class="form-control" data-parsley-required >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="codice" >Codice</label>
				<div class="col-md-10" required >
					<input type="text" id="codice" name="codice" class="form-control" data-parsley-required >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="barcode" >Barcode</label>
				<div class="col-md-10" >
					<input type="number" id="barcode" name="barcode" class="form-control"  >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="id_categoria" >Categoria</label>
				<div class="col-md-10" >
					<select id="id_categoria" name="id_categoria" class="form-control"  >
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
			<div class="form-group">
				<label class="col-md-10 control-label" for="c_u" >Prezzo u. di vendita</label>
				<div class="col-md-10" >
					<input type="number" id="c_u" name="c_u" class="form-control" step="0.001" >
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="id_iva" >IVA</label>
				<div class="col-md-10" >
					<select id="id_iva" name="id_iva" class="form-control"  >
						<option value="" ></option>
						<?php
						foreach ($this->record_iva as $iva) {
							?>
							<option value="<?=$iva->id_iva;?>" ><?=$iva->nome;?> %</option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="qta_residua" >Quantita residua</label>
				<div class="col-md-10" >
					<input type="number" id="qta_residua" name="qta_residua" class="form-control" step="1" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="qta_minima" >Giacenza minima</label>
				<div class="col-md-10" >
					<input type="number" id="qta_minima" name="qta_minima" class="form-control" step="1" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="descrizione" >Descrizione</label>
				<div class="col-md-10" >
					<textarea id="descrizione" name="descrizione" class="form-control" ></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="image" >Immagine</label>
				<div class="col-md-10 padding-left-0 padding-right-0" >
					<input type="file" name="image" id="image">
				</div>
			</div>
		</div>
	</div>

	<?=$this->form_end;?>

	<div class="row">
		<div class="col-lg-12">
			<div class="card-box max550">
				<label class="col-md-10 control-label" for="tab_fornitori_associati" >Fornitori associati</label>
				<button type="button" class="btn btn-info waves-effect waves-light add_new" aria-expanded="false"><span class="m-r-10"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>Aggiungi</button>
				<table id="tab_fornitori_associati" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Ragione sociale</th>
							<th>Costo di acquisto</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-sm-12">
			<div class="card-box">
				<label class="col-md-10 control-label" for="tab_location" >Disponibilità</label>
				<table id="tab_location" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Nome</th>
							<th>Quantità</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($this->record_location as $record) {

							$giacenza = $this->giacenze->getRecord($record->id_location,$this->id_record);

							if(!is_object($giacenza) || !$giacenza->quantita>0) {
								continue;
							}
							?>
							<tr id_location="<?=$record->id_location;?>" >
								<td><?=$record->nome;?></td>
								<td><?=$giacenza->quantita;?></td>
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
		<div class="col-lg-12">
			<div class="card-box">
				<label class="col-md-10 control-label" for="tab_fatture_ddt_fornitori" >Documenti in Entrata</label>
				<table id="tab_fatture_ddt_fornitori" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Codice</th>
							<th>Data</th>
							<th>Quantità</th>
							<th>Prezzo</th>
							<th>Fornitore</th>
							<th>Tipo</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($this->record_fatture->fornitore as $record) {
							if($record->type===1) {continue;}
							?>
							<tr id_fattura="<?=$record->id_fattura;?>" type="<?=$record->type;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
								<td><?=$record->codice;?></td>
								<td><?=utility::toUIDate($record->data);?></td>
								<td class="right-in" ><?=$record->quantita;?></td>
								<td class="right-in" ><?=$record->prezzo_unitario;?></td>
								<td><?=$record->fornitore;?></td>
								<td>Fattura</td>
							</tr>
							<?php
						}
						foreach ($this->record_ddt->fornitore as $record) {
							if($record->type===1) {continue;}
							?>
							<tr id_ddt="<?=$record->id_ddt;?>" type="<?=$record->type;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
								<td><?=$record->codice;?></td>
								<td><?=utility::toUIDate($record->data);?></td>
								<td class="right-in" ><?=$record->quantita;?></td>
								<td class="right-in" ><?=$record->prezzo_unitario;?></td>
								<td><?=$record->fornitore;?></td>
								<td>DDT</td>
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
		<div class="col-lg-12">
			<div class="card-box">
				<label class="col-md-10 control-label" for="tab_fatture_ddt_clienti" >Documenti in uscita</label>
				<table id="tab_fatture_ddt_clienti" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Codice</th>
							<th>Data</th>
							<th>Quantità</th>
							<th>Prezzo</th>
							<th>Cliente</th>
							<th>Tipo</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($this->record_fatture->cliente as $record) {
							if($record->type===0) {continue;}
							?>
							<tr id_fattura="<?=$record->id_fattura;?>" type="<?=$record->type;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
								<td><?=$record->codice;?></td>
								<td><?=utility::toUIDate($record->data);?></td>
								<td class="right-in" ><?=$record->quantita;?></td>
								<td class="right-in" ><?=$record->prezzo_unitario;?></td>
								<td><?=$record->cliente;?></td>
								<td>Fattura</td>
							</tr>
							<?php
						}
						foreach ($this->record_ddt->cliente as $record) {
							if($record->type===0) {continue;}
							?>
							<tr id_ddt="<?=$record->id_ddt;?>" type="<?=$record->type;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
								<td><?=$record->codice;?></td>
								<td><?=utility::toUIDate($record->data);?></td>
								<td class="right-in" ><?=$record->quantita;?></td>
								<td class="right-in" ><?=$record->prezzo_unitario;?></td>
								<td><?=$record->cliente;?></td>
								<td>DDT</td>
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


<?php $includeJS = array('prodotti_fornitori'); ?>

