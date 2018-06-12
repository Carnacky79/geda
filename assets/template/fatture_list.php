<div class="container" menu_link="fatture_list" >

	<a id='exportA' download class="hidden" ></a>

	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?php if($livello_utente===1) { ?>
				<button type="button" class="btn btn-info waves-effect waves-light add_new entrata" aria-expanded="false"><span class="m-r-10"><i class="fa fa-plus"></i></span>In entrata</button>
				<button type="button" class="btn btn-info waves-effect waves-light add_new uscita" aria-expanded="false"><span class="m-r-10"><i class="fa fa-plus"></i></span>In uscita</button>
				<?php } ?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="card-box">
				<label class="col-md-10 control-label no-sides" for="tab_fatture_1" >In uscita</label>
				<table id="tab_fatture_1" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="action_col" >Azioni</th>
							<th>Codice</th>
							<th>Data</th>
							<th>Cliente</th>
							<th>Totale</th>
							<th>Pagata</th>
							<th>Approvata</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($this->record_fatture as $record) {

							if($livello_utente!==1 && utility::dati_utente()->id_location!=$record->id_location) { continue; }
							if($record->type=='0') { continue; }

							$html_down = " <i class=\"fa fa-download downIcon\" aria-hidden=\"true\"></i> ";

							?>
							<tr id_fattura="<?=$record->id_fattura;?>" type="<?=$record->type;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i><?=$html_down;?></td>
								<td class="right-in" ><?=$record->codice;?></td>
								<td><?=utility::toUIDate($record->data);?></td>
								<td><?=$record->cliente;?></td>
								<td class="right-in" ><?=$record->totale;?></td>
								<td><?=($record->pagata==1)?'Si':'No';?></td>
								<td><?=($record->stato==1)?'Si':'No';?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>



<?php if($livello_utente===1) { ?>
	<div class="row">
		<div class="col-sm-12">
			<div class="card-box">
				<label class="col-md-10 control-label no-sides" for="tab_fatture_0" >In entrata</label>
				<table id="tab_fatture_0" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th class="action_col" >Azioni</th>
							<th>Codice</th>
							<th>Data</th>
							<th>Fornitore</th>
							<th>Totale</th>
							<th>Pagata</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($this->record_fatture as $record) {

							if($record->type=='1') { continue; }

							?>
							<tr id_fattura="<?=$record->id_fattura;?>" type="<?=$record->type;?>" >
								<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
								<td class="right-in" ><?=$record->codice;?></td>
								<td><?=utility::toUIDate($record->data);?></td>
								<td><?=$record->fornitore;?></td>
								<td class="right-in" ><?=$record->totale;?></td>
								<td><?=($record->pagata==1)?'Si':'No';?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } ?>

</div>
