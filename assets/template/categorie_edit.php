<div class="container" menu_link="categorie_list" >


	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?=$this->btn_salva;?><?=$this->btn_elimina;?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>

	<?=$this->form_start;?>

	<input type="hidden" id="id_categoria" name="id_categoria" value="" >

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" >Nome</label>
				<div class="col-md-10" required >
					<input type="text" id="nome" name="nome" class="form-control" value="" data-parsley-required >
				</div>
			</div>
		</div>

		<input type="hidden" id="id_categoria_tipologia" name="id_categoria_tipologia" value="1" >

		<?php
		/*
		<div class="col-lg-6">
		<div class="form-group">
		<label class="col-md-10 control-label" for="id_categoria_tipologia" >Tipologia</label>
		<div class="col-md-10" required >
		<select id="id_categoria_tipologia" name="id_categoria_tipologia" class="form-control" data-parsley-required >
		<option value="" ></option>
		<?php
		foreach ($this->record_categorie_tipologie as $categoria_tipologia) {
		?>
		<option value="<?=$categoria_tipologia->id_categoria_tipologia;?>" ><?=$categoria_tipologia->nome;?></option>
		<?php
	}
	?>
	</select>
	</div>
	</div>
	</div>
	*/
	?>

</div>

<?=$this->form_end;?>




<div class="row">
	<div class="col-lg-12">
		<div class="card-box">


			<div class="row form_header">
				<div class="col-sm-12 no-left">
					<div class="btn-group pull-left m-t-5 m-b-20">
						<label class="col-md-12 control-label" for="tab_ddt" >Lista prodotti associati</label>
					</div>
					<div class="btn-group pull-right m-t-10 m-b-20">
						<?=$this->btn_aggiungi;?>
					</div>
				</div>
			</div>




			<table id="tab_prodotti" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Azioni</th>
						<th>Nome</th>
						<th>Codice</th>
						<th>Fornitore</th>
						<th>Qta</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($this->record_prodotti as $record) {
						?>
						<tr id_prodotto="<?=$record->id_prodotto;?>" >
							<td class="action_col" ><i class="fa fa-pencil-square-o editIcon" aria-hidden="true"></i></td>
							<td><?=$record->nome;?></td>
							<td><?=$record->codice;?></td>
							<td><?=$record->fornitore;?></td>
							<td><?=$record->qta_residua;?></td>
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