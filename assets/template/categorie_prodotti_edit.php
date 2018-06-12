<div class="container">


	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?=$this->btn_salva;?><?=$this->btn_elimina;?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>

	<?=$this->form_start;?>

	<input type="hidden" id="id_categoria_prodotto" name="id_categoria_prodotto" value="" >

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-2 control-label" >Nome</label>
				<div class="col-md-10" required >
					<input type="text" id="nome" name="nome" class="form-control" value="" data-parsley-required >
				</div>
			</div>
		</div>
	</div>

	<?=$this->form_end;?>

</div>