<form method="post" action="function/create_form.php">
	<fieldset class="form-group">
		<legend>Creaci&oacute;n de Forma</legend>
		<input type="text" name="form_name" class="form-control" placeholder="Nombre" maxlength="25" required><br>
		<input type="text" name="form_archive" class="form-control" placeholder="Forma" maxlength="25" required><br>
		<textarea class="form-control" name="form_description" placeholder="Descripción"></textarea><br>
		<?php echo !empty($session["error"]) ? "<label class='error-label'>".$session["error"]."</label><br>" : ""; ?>
		<button type="submit" class="btn btn-default">Enviar</button><a href="back.php?form=2" class="btn btn-danger">Cancelar</a>
	</fieldset>
</form>