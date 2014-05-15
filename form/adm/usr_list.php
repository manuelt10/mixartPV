<?php 
	$where = array(
		'id_company' => $usr->userdata->id_company,
		'visible' => 1
	);
	$records = $db->selectRecord('usr_user',NULL,$where,array('id_user' => 'desc'));
	#print_r($records);
?>
<a href="?form=23" class="btn btn-default">Crear Usuario</a>
<table class="table">
	<thead>
		<tr>
			<th>Id</th>
			<th>Nombre</th>
			<th>Usuario</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach($records->data as $u)
		{
			?>
			<tr>
				<td class="id_user"><?php echo $u->id_user ?></td>
				<td><?php echo $u->name ?></td>
				<td><?php echo $u->username ?></td>
				<td><button type="button" class="btn btn-default showLightbox" value="1">Reiniciar contraseña</button></td>
				<td><button type="button" class="btn btn-default showLightbox" value="2">Asignar Rol</button></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

<div class="lighBoxContainer">
	<div id="light" class="white_content">	
	</div>
	<div id="fade" class="black_overlay">
	</div>
</div>
<?php 
	$roles = $db->selectRecord('app_role', NULL, array('visible' => 1));
?>
<script>
$(function() {
	$('.showLightbox').click(function(){
		var html = '';
		var val = $(this).val();
		var id = $(this).parent().siblings('.id_user').html();
		if(val == 1)
		{
			html = html + "<div class='col-md-6'><form method='post' action='function/adm/change_pass.php'><input type='hidden' name='id_user' value='"+ id +"'>"
			+ "<legend>Cambiar contraseña</legend>"
			+ "<label class='black-label'>Nueva Contraseña</label>"
			+ "<input type='text' name='pass1' class='form-control' placeholder='******' required>"
			+ "<br><button type='submit' class='btn btn-default'>Enviar</button><button type='button' class=' btn btn-default closeLightbox'>Cerrar</button>"
			+ "</form><br></div>";
		}
		else if(val == 2)
		{
			html = html + "<div class='col-md-6'><form method='post' action='function/adm/change_role.php'><input type='hidden' name='id_user' value='"+ id +"'>"
			+ "<legend>Seleccionar Rol</legend>"
			+ "<select class='form-control' size='10' name='role' required>" 
			<?php 
			foreach($roles->data as $r)
			{
				?>
				+ "<option value='<?php echo $r->id_role ?>'><?php echo $r->role ?></option>"
				<?php
			}
			?>
			+ "</select><br><button type='submit' class='btn btn-default'>Enviar</button><button type='button' class=' btn btn-default closeLightbox'>Cerrar</button>"
			+ "</form><br></div>";
		}
		
		$('.white_content').html(html);
		$('#light').fadeIn('fast');
		$('#fade').fadeIn('fast');
	});
});
</script>
<script>
	$('.lighBoxContainer').on("click", '.closeLightbox', function(){
		var name = $(this).parent().siblings('.name').html();
		var id_client = $(this).parent().siblings('.id_client').html();
		$('.client_name').html(name);
		$('.id_client').val(id_client);
		$('#light').fadeOut('fast');
		$('#fade').fadeOut('fast');
	});
</script>