<form class="form-group" method="post" action="function/adm/create_user.php">
	<input type="hidden" name="id_company" value="<?php echo $usr->userdata->id_company ?>">
	<div class="col-md-6">
		<legend>Datos del Usuario</legend>
		<label class="black-label">Usuario</label>
		<input type="text" name="username" class="form-control" required>
		<label class="black-label">Nombre</label>
		<input type="text" name="name" class="form-control" required>
		<label class="black-label">Mail</label>
		<input type="text" name="mail" class="form-control">
		<?php echo  !empty($session["error"]["isNotEmail"]) ? $session["error"]["isNotEmail"] : ""; ?>
		<label class="black-label">Contraseña</label>
		<input type="password" name="pass1" class="form-control" required>
		<label class="black-label">Repetir Contraseña</label>
		<input type="password" name="pass2" class="form-control" required><br>
		<?php echo  !empty($session['error']['passNotEqual']) ? $session['error']['passNotEqual'] : ""; ?>
		<button type="submit" class="btn btn-default">Enviar</button> <a href="?form=22" class="btn btn-danger">Cancelar</a>
	</div>
	<div class="col-md-6">
		<legend>Seleccion del Rol</legend>
		<label class="black-label">Lista de Rol</label>
		<select class="form-control" required size='10' name="role">
			<?php 
			$roles = $db->selectRecord('app_role', NULL, array('visible' => 1));
			foreach($roles->data as $r)
			{
			?>
				<option value='<?php echo $r->id_role ?>'><?php echo $r->role ?></option>
			<?php 
			}
			?>
		</select>
	</div>
</form>