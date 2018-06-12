<div class="container" menu_link="servizi_new" >

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
				<label class="col-md-10 control-label" for="nome" >Nome</label>
				<div class="col-md-10" required >
					<input type="text" id="nome" name="nome" class="form-control" value="" data-parsley-required >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="codice" >Codice</label>
				<div class="col-md-10" >
					<input type="text" id="codice" name="codice" class="form-control" value=""  >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="id_categoria" >Categoria</label>
				<div class="col-md-10" >
					<select id="id_categoria" name="id_categoria" class="form-control"  >
						<option value="" ></option>
						<?php
						foreach ($this->record_categorie as $categoria) {
							?>
							<option value="<?=$categoria->id_categoria;?>" ><?=$categoria->nome;?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="id_fornitore" required >Fornitore</label>
				<div class="col-md-10" >
					<select id="id_fornitore" name="id_fornitore" class="form-control" data-parsley-required >
						<option value="" ></option>
						<?php
						foreach ($this->record_fornitori as $fornitore) {
							?>
							<option value="<?=$fornitore->id_fornitore;?>" ><?=$fornitore->nome;?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="c_u" >Costo Orario</label>
				<div class="col-md-10" >
					<input type="number" id="c_u" name="c_u" class="form-control" value="" step="0.001" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-10 control-label" for="descrizione" >Descrizione</label>
				<div class="col-md-10" >
					<textarea id="descrizione" name="descrizione" class="form-control" ></textarea>
				</div>
			</div>
		</div>
	</div>

	<?=$this->form_end;?>

</div>

