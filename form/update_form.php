<?php 
if(!empty($_GET["id"]))
{
	$form = $db->selectRecord('app_form', NULL, array('id_form' => $_GET["id"]));
	$form = $form->data[0];
	?>
	<form method="post" action="function/update_form.php">
		<input type="hidden" name="id_form" value="<?php echo $_GET["id"] ?>">
		<fieldset class="form-group">
			<legend>Actualización de Forma</legend>
			<input type="text" name="form_name" class="form-control" placeholder="Nombre" maxlength="25" required value="<?php echo $form->form_name ?>"><br>
			<input type="text" name="form_archive" class="form-control" placeholder="Forma" maxlength="25" required value="<?php echo $form->form ?>" readonly><br>
			<textarea class="form-control" name="form_description" placeholder="Descripción"><?php echo $form->description ?></textarea><br>
			<?php echo !empty($session["error"]) ? "<label class='error-label'>".$session["error"]."</label><br>" : ""; ?>
			<button type="submit" class="btn btn-default">Enviar</button><a href="back.php?form=2" class="btn btn-danger">Cancelar</a>
		</fieldset>
	</form>
	<?php
}
?>