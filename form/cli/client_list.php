<?php 
	$records = $db->selectRecord('cli_client',NULL,NULL,array('id_client' => 'desc'));
?>
<legend>
	Listado de Clientes
</legend>
<a href="?form=14" class="btn btn-default">Agregar nuevo Cliente</a>


<form class="form-inline">
	<br>
	<h4 class="black-label">Buscar</h4>
	<div class="form-group">
		<input type="text" name="Nombre" class="form-control">
	</div>
	<div class="form-group">
		<input type="text" name="Codigo" class="form-control">
	</div>
	<button class="form-control">Buscar</button>
</form> 
<table class="table">
	<thead>
		<tr>
			<th>Id</th>
			<th>Nombre</th>
			<th>Direccion Principal</th>
			<th>Telefono Principal</th>
			<th>rnc</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($records->data as $c) {
		?>
		<tr>
			<td><?php echo $c->id_client; ?></td>
			<td><?php echo $c->name; ?></td>
			<td><?php echo $c->address1; ?></td>
			<td><?php echo $c->phone1; ?></td>
			<td><?php echo $c->rnc; ?></td>
			<td><a href="?form=15&id=<?php echo $c->id_client ?>" class="btn btn-default">Modificar</a></td>
		</tr>
		<?php
	}
	?>
</tbody>
</table>