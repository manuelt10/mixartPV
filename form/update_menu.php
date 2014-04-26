<?php 
if(!empty($_GET["id"]))
{
	$menu = $db->selectRecord('app_menu', NULL, array('id_menu' => $_GET["id"]));
	$menu = $menu->data[0];
?>

	<form method="post" action="function/update_menu.php">
		<input type="hidden" name="id_menu" value="<?php echo $_GET["id"] ?>">
		<fieldset class="form-group">
			<legend>Actualizaci&oacute;n de Men&uacute;s</legend>
			<input type="text" name="menu" class="form-control" placeholder="nombre" maxlength="25" required value="<?php echo $menu->menu ?>"><br>
			<textarea class="form-control" name="menu_description"><?php echo $menu->description ?></textarea><br>
		</fieldset>
		<fieldset class="form-group">
			<?php 
			$formas = $db->selectRecord('app_form',NULL, NULL, array('form_name' => 'asc'));
			?>
			<legend>Seleccionar Formas</legend>
			<select size="10" multiple class="form-control" name="menu_forms[]">
				<?php 
				$menu_forms = $db->selectRecord('app_menu_form',array('id_form'), array('id_menu' => $_GET["id"]));
				foreach($formas->data as $f)
				{
					
					?>
					<option value="<?php echo $f->id_form ?>"
						<?php 
						foreach($menu_forms->data as $mf)
						{
							if($f->id_form == $mf->id_form)
							{
								echo "selected";
							}	
						}
						
						?>
						><?php echo $f->form_name ?></option>
					<?php
				}
				?>
			</select>
		</fieldset>
		<button type="submit" class="btn btn-default">Enviar</button><a href="back.php?form=6" class="btn btn-danger">Cancelar</a>	
	</form>
<?php
}
?>