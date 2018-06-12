<div class="container" menu_link="contatori_list_<?=$this->contatori_type;?>" >


	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="card-box">
				<table id="tab_contatori" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Azioni</th>
							<th>Descrizione</th>
							<th>Prossima numerazione</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($this->record_contatori as $record) {
							?>
							<tr id_contatore="<?=$record->id_contatore;?>" >
								<td class="action_col" >
									<i class="fa fa-plus-circle plusIcon" aria-hidden="true"></i>
									<i class="fa fa-minus-circle minusIcon" aria-hidden="true"></i>
								</td>
								<td><?=$record->descrizione;?></td>
								<td class="right-in" ><?=$record->valore;?></td>
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
