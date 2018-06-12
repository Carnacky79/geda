<div class="container" menu_link="iva_list" >

	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?=$this->btn_salva;?><?=$this->btn_elimina;?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>

	<?=$this->form_start;?>

	<input type="hidden" id="id_iva" name="id_iva" >

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="nome" >Nome</label>
				<div class="col-md-10" required >
					<input type="text" id="nome" name="nome" class="form-control" value="" data-parsley-required >
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-10 control-label" for="valore" >Valore %</label>
				<div class="col-md-10" required >
					<input type="number" id="valore" name="valore" class="form-control" value="" step="0.1" max="30" data-parsley-required >
				</div>
			</div>
		</div>
		<div class="col-lg-6">

			<div class="form-group">
				<label class="col-md-10 control-label" for="articolo" >Articolo</label>
				<div class="col-md-10" >
					<textarea id="articolo" name="articolo" class="form-control" ></textarea>
				</div>
			</div>
		</div>
	</div>

	<?=$this->form_end;?>

</div>

