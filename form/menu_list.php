<?php 
$menu_list = $db->selectRecord('app_menu', NULL, NULL, array('id_menu' => 'desc'));
?>
<legend>Listado de Men&uacute;s</legend>
<a class="btn btn-default" href="?form=4">Nuevo</a>
<table class="table">
	<thead>
		<tr>
			<th>Id</th>
			<th>Nombre Menu</th>
			<th>Fecha Creaci&oacute;n</th>
			<th>Acci&oacute;n</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach($menu_list->data as $m)
		{
			?>
			<tr>
				<td><?php echo $m->id_menu; ?></td>
				<td><?php echo $m->menu; ?></td>
				<td><?php echo $m->created_date ?></td>
				<td><a class="btn btn-default" href="?form=5&id=<?php echo $m->id_menu; ?>">Modificar</a></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
	