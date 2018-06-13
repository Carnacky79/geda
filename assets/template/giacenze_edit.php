<!--<div class="container" menu_link="prodotti_list" >-->
<div class="container" >

	<div class="row form_header">
		<div class="col-sm-12">
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
				<label class="col-md-10 control-label" for="quantita" >Quantita residua</label>
				<div class="col-md-10" >
					<input type="number" id="quantita" name="quantita" class="form-control" step="1" >
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
		</div>
	</div>

	<?=$this->form_end;?>


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
</div>

