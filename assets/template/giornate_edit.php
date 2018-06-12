<?php

$disabled_location = '';
if($livello_utente!==1) {
	$disabled_location = 'disabled ';
}

$disabled_giorno = '';
if(isset($this->record->stato) && $this->record->stato==0) {
	$disabled_giorno = 'disabled ';
}

?><div class="container" menu_link="giornate_list" >

	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?php
				if(isset($this->record->stato) && $this->record->stato==0) {
					if($livello_utente===1) {
						echo $this->btn_apri.$this->btn_elimina;
					}
					// echo $this->btn_esporta;
				} else {
					echo $this->btn_salva.$this->btn_chiudi;
					if($livello_utente===1) {
					echo $this->btn_elimina;
					}
					// echo $this->btn_esporta;
				}
				?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>


	<div class="hidden" id="record_prodotti" name="record_prodotti" ><?=$this->json_prodotti;?></div>
	<div class="hidden" id="record_metodi_pagamento" name="record_metodi_pagamento" ><?=$this->json_metodi_pagamento;?></div>
	<a id='exportA' download class="hidden" ></a>


	<?=$this->form_start;?>

	<input type="hidden" id="id_giornata" name="id_giornata" value="<?=$this->record->id_giornata;?>" >
	<input type="hidden" id="stato" name="stato" value="<?=$this->record->stato;?>" >

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="id_livello" >Location</label>
				<div class="col-md-10" required >
					<select id="id_location" name="id_location" class="form-control" data-parsley-required <?=$disabled_location;?> >
						<option value="" ></option>
						<?php
						foreach ($this->record_location as $location) {
							?>
							<option value="<?=$location->id_location;?>" ><?=$location->nome;?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="giorno" >Data</label>
				<div class="col-md-10" required>
					<input type="text" id="giorno" name="giorno" placeholder="" data-mask="99/99/9999" class="form-control date" value="" data-parsley-required <?=$disabled_giorno;?> >
				</div>
			</div>
		</div>
	</div>

	<?=$this->form_end;?>


	<div class="row">
		<div class="col-lg-12">
			<div class="card-box">
				<?php
				if(isset($this->record->stato) && $this->record->stato!=0) { ?>
					<button type="button" class="btn btn-info waves-effect waves-light add_new" aria-expanded="false"><span class="m-r-10"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>Aggiungi</button>
					<?php
				}
				?>
				<table id="tab_giornate_righe" class="table dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Prodotto</th>
							<th>Quantità</th>
							<th>Totale</th>
							<th>Pagamento</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>


				<table id="tab_giornate_tot_info" class="table dt-responsive nowrap" cellspacing="0" width="100%">
					<tbody class="hidden" >
						<tr>
							<td class="descr" >QUANTITÀ TOTALE</td>
							<td class="totale_qta right-in" ></td>
						</tr>
						<tr>
							<td class="descr" >INCASSO TOTALE</td>
							<td class="totale_incasso right-in" ></td>
						</tr>
					</tbody>
				</table>
				<div class="clear"></div>
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


<?php $includeJS = array('giornate_righe_div'); ?>

