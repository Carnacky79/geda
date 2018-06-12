<div class="container" menu_link="utenti_list" >

	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?=$this->btn_salva;?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>

	<?=$this->form_start;?>

	<input type="hidden" id="id_utente" name="id_utente" value="<?=utility::dati_utente()->id_utente;?>" >

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="password" >Password</label>
				<div class="col-md-10" required >
					<input type="password" id="password" name="password" class="form-control" data-parsley-required >
				</div>
			</div>
		</div>
		<div class="col-lg-6">
		</div>
	</div>

	<?=$this->form_end;?>

</div>

