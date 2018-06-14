<?php

$qta_propria = '';
if($livello_utente!==1) {
	if(is_object($this->record_giacenze) && isset($this->record_giacenze->quantita)) {
		$qta_propria = $this->record_giacenze->quantita;
	} else {
		$qta_propria = 0;
	}
}

?><div class="container" menu_link="prodotti_list" >

	<div class="row form_header">
		<div class="col-sm-12">
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>


	<div class="hidden" id="record_fornitori" name="record_fornitori" ><?=$this->json_fornitori;?></div>

	<?=$this->form_start;?>

	<input type="hidden" id="id_prodotto" name="id_prodotto" >
	<input type="hidden" id="qta_propria" name="qta_propria" value="<?=$qta_propria;?>" >


	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="nome" >Nome</label>
				<div class="col-md-10" >
					<input type="text" id="nome" name="nome" class="form-control like-text">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="codice" >Codice</label>
				<div class="col-md-10" >
					<input type="text" id="codice" name="codice" class="form-control like-text" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="barcode" >Barcode</label>
				<div class="col-md-10" >
					<input type="number" id="barcode" name="barcode" class="form-control like-text"  >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="id_categoria" >Categoria</label>
				<div class="col-md-10" >
					<select id="id_categoria" name="id_categoria" class="form-control like-text"  >
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
					<input type="number" id="c_u" name="c_u" class="form-control like-text" step="0.001" >
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="quantita" >Quantita residua</label>
				<div class="col-md-10" >
					<input type="number" id="quantita" name="quantita" class="form-control" step="1" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="qta_minima" >Giacenza minima</label>
				<div class="col-md-10" >
					<input type="number" id="qta_minima" name="qta_minima" class="form-control like-text" step="1" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="descrizione" >Descrizione</label>
				<div class="col-md-10" >
					<textarea id="descrizione" name="descrizione" class="form-control like-text" ></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="image" >Immagine</label>
				<div class="col-md-10 padding-left-0 padding-right-0" >
					<input type="file" name="image" id="image" class="hidden" >
				</div>
			</div>
		</div>
	</div>

	<?=$this->form_end;?>

	<div class="row">
		<div class="col-lg-12">
			<div class="card-box">
				<label class="col-md-10 control-label" for="tab_fatture_ddt_clienti" >In uscita</label>
				<table id="tab_fatture_ddt_clienti" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Codice</th>
							<th>Data</th>
							<th>Quantità</th>
							<th>Prezzo</th>
							<th>Tipo</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($this->record_fatture->cliente as $record) {
							if($livello_utente!==1 && utility::dati_utente()->id_location!=$record->id_location) { continue; }
							if($record->type===0) {continue;}
							?>
							<tr id_fattura="<?=$record->id_fattura;?>" type="<?=$record->type;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
								<td><?=$record->codice;?></td>
								<td><?=utility::toUIDate($record->data);?></td>
								<td class="right-in" ><?=$record->quantita;?></td>
								<td class="right-in" ><?=$record->prezzo_unitario;?></td>
								<td>Fattura</td>
							</tr>
							<?php
						}
						foreach ($this->record_ddt->cliente as $record) {
							if($livello_utente!==1 && utility::dati_utente()->id_location!=$record->id_location) { continue; }
							if($record->type===0) {continue;}
							?>
							<tr id_ddt="<?=$record->id_ddt;?>" type="<?=$record->type;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
								<td><?=$record->codice;?></td>
								<td><?=utility::toUIDate($record->data);?></td>
								<td class="right-in" ><?=$record->quantita;?></td>
								<td class="right-in" ><?=$record->prezzo_unitario;?></td>
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

