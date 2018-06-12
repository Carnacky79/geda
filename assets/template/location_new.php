<div class="container" menu_link="location_new" >

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
				<label class="col-md-10 control-label" for="id_cliente" >Cliente associato</label>
				<div class="col-md-10" >
					<select id="id_cliente" name="id_cliente" class="form-control" >
						<option value="" ></option>
						<?php
						foreach ($this->record_clienti as $cliente) {
							?>
							<option value="<?=$cliente->id_cliente;?>" ><?=$cliente->nome;?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label class="col-md-10 control-label" for="id_categoria" >Categoria</label>
				<div class="col-md-10" required >
					<select id="id_categoria" name="id_categoria" class="form-control" data-parsley-required  >
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
		</div>
	</div>

	<?=$this->form_end;?>

</div>

