<div class="container" menu_link="ddt_list" >

	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?php if($this->record->stato==0) {
					echo $this->btn_chiudi;
				} ?>
				<?=$this->btn_esporta;?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>


	<div class="hidden" id="record_categorie_tipologie" name="record_categorie_tipologie" ><?=$this->json_categorie_tipologie;?></div>
	<div class="hidden" id="record_oggetti" name="record_oggetti" ><?=$this->json_oggetti;?></div>
	<div class="hidden" id="record_iva" name="record_iva" ><?=$this->json_iva;?></div>
	<div class="hidden" id="record_fornitori_associati" name="record_fornitori_associati" ><?=$this->json_fornitori_associati;?></div>
	<a id='exportA' download class="hidden" ></a>

	<?=$this->form_start;?>


	<input type="hidden" id="id_ddt" name="id_ddt" value="" >
	<input type="hidden" id="type" name="type" value="" >


	<div class="row">
		<div class="col-lg-6">
			<div class="form-group hidden">
				<label class="col-md-10 control-label" for="id_fornitore" >Fornitore</label>
				<div class="col-md-10" >
					<select id="id_fornitore" name="id_fornitore" class="form-control like-text" >
						<option value="" ></option>
						<?php
						foreach ($this->record_fornitori as $fornitore) {
							?>
							<option value="<?=$fornitore->id_fornitore;?>" ><?=$fornitore->nome;?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>

			<div class="form-group hidden">
				<label class="col-md-10 control-label" for="id_cliente" >Cliente</label>
				<div class="col-md-10" >
					<select id="id_cliente" name="id_cliente" class="form-control like-text" >
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
			<div class="form-group">
				<label class="col-md-10 control-label" for="descrizione" >Note</label>
				<div class="col-md-10" >
					<textarea id="descrizione" name="descrizione" class="form-control like-text" ></textarea>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="data" >Data</label>
				<div class="col-md-10">
					<input type="text" id="data" name="data" placeholder="" data-mask="99/99/9999" class="form-control like-text date" value="" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="codice" >Numero</label>
				<div class="col-md-10" >
					<input type="text" id="codice" name="codice" class="form-control like-text" value="" >
				</div>
			</div>
		</div>
	</div>

	<?=$this->form_end;?>


	<div class="row">
		<div class="col-lg-12">
			<div class="card-box">
				<label class="col-md-10 control-label" for="tab_ddt_righe" >Righe DDT</label>
				<table id="tab_ddt_righe" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Descrizione</th>
							<th>Quantità</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>

</div>


<?php $includeJS = array('ddt_righe_div_limited'); ?>

