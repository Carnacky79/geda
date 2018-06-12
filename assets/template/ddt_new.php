<div class="container" menu_link="ddt_new_<?=$this->ddt_type;?>" >

	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?=$this->btn_salva;?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>


	<div class="hidden" id="record_categorie_tipologie" name="record_categorie_tipologie" ><?=$this->json_categorie_tipologie;?></div>
	<div class="hidden" id="record_oggetti" name="record_oggetti" ><?=$this->json_oggetti;?></div>
	<div class="hidden" id="record_iva" name="record_iva" ><?=$this->json_iva;?></div>
	<div class="hidden" id="record_fornitori_associati" name="record_fornitori_associati" ><?=$this->json_fornitori_associati;?></div>


	<?=$this->form_start;?>

	<input type="hidden" id="type" name="type" value="" >
	<input type="hidden" id="stato" name="stato" value="1" >

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group hidden">
				<label class="col-md-10 control-label" for="id_fornitore" >Fornitore</label>
				<div class="col-md-10" required >
					<select id="id_fornitore" name="id_fornitore" class="form-control" >
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
				<div class="col-md-10" required >
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
			<div class="form-group">
				<label class="col-md-10 control-label" for="descrizione" >Note</label>
				<div class="col-md-10" >
					<textarea id="descrizione" name="descrizione" class="form-control" ></textarea>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="data" >Data</label>
				<div class="col-md-10" required>
					<input type="text" id="data" name="data" placeholder="" data-mask="99/99/9999" class="form-control date" value="<?=($this->ddt_type==1)?date('d/m/Y'):'';?>" data-parsley-required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="codice" >Numero</label>
				<div class="col-md-10" required>
					<input type="text" id="codice" name="codice" class="form-control" value="" data-parsley-required >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="spese_acc" >Spese accessorie</label>
				<div class="col-md-10" >
					<input type="number" id="spese_acc" name="spese_acc" class="form-control" step="0.01" value="" >
				</div>
			</div>
		</div>
	</div>

	<?=$this->form_end;?>


	<div class="row">
		<div class="col-lg-12">
			<div class="card-box">
				<label class="col-md-10 control-label" for="tab_ddt_righe" >Righe DDT</label>
				<button type="button" class="btn btn-info waves-effect waves-light add_new hidden" aria-expanded="false"><span class="m-r-10"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>Aggiungi</button>
				<table id="tab_ddt_righe" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Descrizione</th>
							<th>Quantità</th>
							<th>Costo unitario</th>
							<th>Sconto</th>
							<th>Sub totale</th>
							<th>IVA</th>
							<th>Totale</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>

				<table id="tab_ddt_info" class="table dt-responsive nowrap" cellspacing="0" width="100%">
					<tbody class="hidden" >
						<tr>
							<td rowspan="5" class="info_ddt" ></td>
							<td class="descr" >IMPONIBILE</td>
							<td class="totale_imponibile" ></td>
						</tr>
						<tr>
							<td class="descr" >IVA</td>
							<td class="totale_iva" ></td>
						</tr>
						<tr>
							<td class="descr" >ESENTE</td>
							<td class="totale_esente" ></td>
						</tr>
						<tr>
							<td class="descr" >SPESE ACCESSORIE</td>
							<td class="totale_accessorie" ></td>
						</tr>
						<tr>
							<td class="descr" >TOTALE</td>
							<td class="totale_totale" ></td>
						</tr>
					</tbody>
				</table>

			</div>
		</div>
	</div>

	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?=$this->btn_salva;?>
			</div>
		</div>
	</div>

</div>


<?php $includeJS = array('ddt_righe_div'); ?>

