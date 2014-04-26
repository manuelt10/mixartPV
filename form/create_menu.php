<form method="post" action="function/create_menu.php">
	<fieldset class="form-group">
		<legend>Creaci&oacute;n de Men&uacute;s</legend>
		<input type="text" name="menu" class="form-control" placeholder="nombre" maxlength="25" required><br>
		<textarea class="form-control" name="menu_description"></textarea><br>
	</fieldset>
	<fieldset class="form-group">
		<?php 
		$formas = $db->selectRecord('app_form',NULL, NULL, array('form_name' => 'asc'));
		?>
		<legend>Seleccionar Formas</legend>
		<select size="10" multiple class="form-control" name="menu_forms[]">
			<?php 
			foreach($formas->data as $f)
			{
				?>
				<option value="<?php echo $f->id_form ?>"><?php echo $f->form_name ?></option>
				<?php
			}
			?>
		</select>
		
	</fieldset>
	<button type="submit" class="btn btn-default">Enviar</button><a href="back.php?form=6" class="btn btn-danger">Cancelar</a>	
</form>