<div class="container" menu_link="categorie_new" >


	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?=$this->btn_salva;?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>

	<?=$this->form_start;?>

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

</div>