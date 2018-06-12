<div class="container" menu_link="fornitori_new" >

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
				<label class="col-md-10 control-label" for="nome" >Ragione sociale</label>
				<div class="col-md-10" required >
					<input type="text" id="nome" name="nome" class="form-control" value="" data-parsley-required >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="p_iva" >P. IVA</label>
				<div class="col-md-10" >
					<input type="number" id="p_iva" name="p_iva" class="form-control" value="" data-parsley-maxlength="11" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="telefono" >Telefono</label>
				<div class="col-md-10" >
					<input type="text" id="telefono" name="telefono" class="form-control" value="" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="email" >Email</label>
				<div class="col-md-10" >
					<input type="email" id="email" name="email" class="form-control" value="" >
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="referente" >Referente</label>
				<div class="col-md-10" >
					<input type="text" id="referente" name="referente" class="form-control" value="" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="comune" >Comune</label>
				<div class="col-md-10" >
					<input type="text" id="comune" name="comune" class="form-control" value="" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="cap" >Cap</label>
				<div class="col-md-10" >
					<input type="number" id="cap" name="cap" class="form-control" value="" data-parsley-maxlength="5"  >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="indirizzo" >Indirizzo</label>
				<div class="col-md-10" >
					<input type="text" id="indirizzo" name="indirizzo" class="form-control" value="" >
				</div>
			</div>
		</div>
	</div>

	<?=$this->form_end;?>

</div>

