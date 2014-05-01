<?php 
	$nombre = '';
	$direccion = '';
	$telefono = '';
	$rnc = '';
	
	if(!empty($_GET["name"]))
	{
		$nombre = trim($_GET["name"]);
	}
	if(!empty($_GET["address"]))
	{
		$direccion = trim($_GET["address"]);
	}
	if(!empty($_GET["phone"]))
	{
		$telefono = trim($_GET["telefono"]);
	}
	if(!empty($_GET["rnc"]))
	{
		$rnc = trim($_GET["rnc"]);
	}
	$where = array(
		'id_company' => $usr->userdata->id_company,
		'name' => '%' . $nombre . '%',
		'address1' => '%' . $direccion . '%', 
		'phone1' => '%' . $telefono . '%', 
		'rnc' => '%' . $rnc . '%'
	);
	$records = $db->selectRecord('cli_client',NULL,$where,array('id_client' => 'desc'));
?>
<legend>
	Listado de Clientes
</legend>
<a href="?form=14" class="btn btn-default">Agregar nuevo Cliente</a>


<form class="form-inline">
	<input type="hidden" name="form" value="<?php echo $_GET["form"] ?>">
	<br>
	<h4 class="black-label">Buscar</h4>
	<div class="form-group">
		<input type="text" name="name" value="<?php echo $nombre ?>" class="form-control" placeholder="Nombre">
	</div>
	<div class="form-group">
		<input type="text" name="address" value="<?php echo $direccion ?>" class="form-control" placeholder="Direccion">
	</div>
	<div class="form-group">
		<input type="text" name="phone"  value="<?php echo $telefono ?>" class="form-control" placeholder="Telefono">
	</div>
	<div class="form-group">
		<input type="text" name="rnc"  value="<?php echo $rnc ?>" class="form-control" placeholder="RNC">
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