<div class="container" menu_link="utenti_new" >

	<div class="row form_header">
		<div class="col-sm-12">
			<div class="btn-group pull-right m-t-5 m-b-20">
				<?=$this->btn_salva;?><?=$this->btn_elimina;?>
			</div>
			<h4 class="page-title"><?=$titolo;?></h4>
		</div>
	</div>

	<?=$this->form_start;?>

	<input type="hidden" id="id_utente" name="id_utente" >

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="nome" >Nome</label>
				<div class="col-md-10" required >
					<input type="text" id="nome" name="nome" class="form-control" value="" data-parsley-required >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="email" >Email</label>
				<div class="col-md-10" required >
					<input type="email" id="email" name="email" class="form-control" value="" data-parsley-required >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="id_livello" >Livello</label>
				<div class="col-md-10" required >
					<select id="id_livello" name="id_livello" class="form-control" data-parsley-required >
						<option value="" ></option>
						<?php
						foreach ($this->record_livelli as $livello) {
							?>
							<option value="<?=$livello->id_livello;?>" ><?=$livello->nome;?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="cognome" >Cognome</label>
				<div class="col-md-10" required >
					<input type="text" id="cognome" name="cognome" class="form-control" value="" data-parsley-required >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="password" >Password</label>
				<div class="col-md-10" required >
					<input type="password" id="password" name="password" class="form-control" value="" data-parsley-required >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="id_livello" >Location</label>
				<div class="col-md-10" required >
					<select id="id_location" name="id_location" class="form-control" data-parsley-required >
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
	</div>

	<?=$this->form_end;?>

</div>

