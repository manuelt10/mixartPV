<?php 
if(!empty($_GET["id"]))
{
	$rol = $db->selectRecord('app_role', NULL, array('id_role' => $_GET["id"]));
	$rol = $rol->data[0];
?>
	<form method="post" action="function/update_rol.php">
		<input type="hidden" name="id_role" value="<?php echo $_GET["id"] ?>">
		<fieldset class="form-group">
			<legend>Creaci&oacute;n de Rol</legend>
			<input type="text" name="rol" class="form-control" placeholder="Nombre" maxlength="25" required value="<?php echo $rol->role ?>"><br>
			<textarea class="form-control" name="description" placeholder="Descripción"><?php echo $rol->description ?></textarea><br>
			<?php echo !empty($session["error"]) ? "<label class='error-label'>".$session["error"]."</label><br>" : ""; ?>
		</fieldset>
		<fieldset class="form-group">
			<label class="control-label">Seleccione los Menus</label><br>
			<?php 
			$menus = $db->queryRecord('Select * from app_menu where id_menu not in (select id_menu from v_role_menu where id_role = ' . $_GET["id"] . ')');
			//$menus = $db->selectRecord('app_menu');
			?>
			<select size="10" class="role_list select_menu" multiple>
				<?php 
				foreach($menus->data as $m)
				{
					?>
					<option value="<?php echo $m->id_menu ?>"><?php echo $m->menu ?></option>
					<?php
				}
				?>
			</select>
			<button type="button" class="btn btn-default add_right"><</button>
			<button type="button" class="btn btn-default add_left">></button>
			<select size="10" class="role_list select_menu_add" multiple>
				<?php 
				$role_menu = $db->selectRecord('v_role_menu',NULL,array('id_role' => $_GET["id"]));
				foreach($role_menu->data as $rm)
				{
					?>
					<option value="<?php echo $rm->id_menu ?>"><?php echo $rm->menu ?></option>
					<?php
				}
				?>
				</select>
			<br>
			<button type="submit" class="btn btn-default">Enviar</button><a href="back.php?form=7" class="btn btn-danger">Cancelar</a>
			<div class="selected_values">
				<?php 
				foreach($role_menu->data as $rm)
				{
					?>
					<input type="hidden" name="selected_values[]" value="<?php echo $rm->id_menu ?>" class="selected">
					<?php
				}
				?>
			</div>
		</fieldset>
	</form>
	<script type="text/javascript">
		$('.add_left').click(function(){
			$('.select_menu option:selected').each(function(key, val)
			{
				$('.select_menu_add').append(val);
				$('.selected_values').append('<input type="hidden" name="selected_values[]" value="'+ $(this).val() + '" class="selected">');
			});
		});
		$('.add_right').click(function(){
			$('.select_menu_add option:selected').each(function(key, val)
			{
				var value = $(this).val();
				$('.select_menu').append(val);
				$('.selected').each(function(key, val)
				{
					if(value === $(this).val())
					{
						$(this).remove();
					}
				})
			});
		});
	</script>
<?php
}
?>