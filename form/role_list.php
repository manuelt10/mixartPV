<?php 
	$records = $db->selectRecord('app_role',NULL,NULL,array('id_role' => 'desc'));
?>
<legend>
	Listado de Roles
</legend>
<a href="?form=8" class="btn btn-default">Nueva Rol</a>
<table class="table">
	<thead>
		<tr>
			<th>Id</th>
			<th>Nombre</th>
			<th>Fecha Creaci&oacute;n</th>
			<th>Acci&oacute;n</th>
		</tr>
	</thead>
<tbody>
		<?php 
		foreach ($records->data as $r) {
			?>
			<tr>
				<td><?php echo $r->id_role; ?></td>
				<td><?php echo $r->role; ?></td>
				<td><?php echo $r->created_date ?></td>
				<td><a href="#" class="btn btn-default">Modificar</a></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>