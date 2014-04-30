<?php 
	$records = $db->selectRecord('app_form',NULL,NULL,array('id_form' => 'desc'));
?>
<legend>
	Listado de Formas
</legend>
<a href="?form=1" class="btn btn-default">Nueva Forma</a>
<table class="table">
	<thead>
		<tr>
			<th>Id</th>
			<th>Nombre</th>
			<th>Archivo</th>
			<th>Fecha Creaci&oacute;n</th>
			<th>Acci&oacute;n</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach ($records->data as $f) {
			?>
			<tr>
				<td><?php echo $f->id_form; ?></td>
				<td><?php echo $f->form_name; ?></td>
				<td><?php echo $f->form; ?></td>
				<td><?php echo $f->created_date ?></td>
				<td><a href="?form=11&id=<?php echo $f->id_form ?>" class="btn btn-default">Modificar</a></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>