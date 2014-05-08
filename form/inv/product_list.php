<?php 
	$where = array(
	'id_company' => $usr->userdata->id_company
	);
	if(!empty($_GET["nombre"]))
	{
		$nombre = trim($_GET["nombre"]);
		$where[] = array('name' => '%' . $nombre . '%');
	}
	if(!empty($_GET["codigo"]))
	{
		$codigo = trim($_GET["codigo"]);
		$where[] = array('cod_product' => '%' . $codigo . '%');
	}
	
	
	
	
	
	
	$records = $db->selectRecord('inv_product',NULL,$where,array('id_product' => 'desc'));
?>
<legend>
	Listado de Productos
</legend>
<a href="?form=12" class="btn btn-default">Agregar nuevo producto</a>


<form class="form-inline">
	<br>
	<input type="hidden" name="form" value="<?php echo $_GET["form"] ?>">
	<h4 class="black-label">Buscar</h4><br>
	<div class="form-group">
		<input type="text" name="nombre" class="form-control" placeholder="Nombre">
	</div>
	<div class="form-group">
		<input type="text" name="codigo" class="form-control" placeholder="Codigo">
	</div>
	<button class="form-control">Buscar</button>
</form>
<table class="table">
	<thead>
		<tr>
			<th>Id</th>
			<th>Codigo</th>
			<th>Nombre</th>
			<th>Precio Unitario</th>
			<th>Precio de Costo</th>
			<th>Existencia</th>
			<th>Estado</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($records->data as $i) {
		?>
		<tr>
			<td><?php echo $i->id_product; ?></td>
			<td><?php echo $i->cod_product; ?></td>
			<td><?php echo $i->name; ?></td>
			<td><?php echo $i->unit_price; ?></td>
			<td><?php echo $i->unit_cost; ?></td>
			<td><?php echo $i->existence ?></td>
			<td><?php echo $i->active == 1 ? "Activo" : "Inactivo" ?></td>
			<td><a href="?form=11&id=<?php echo $i->id_product ?>" class="btn btn-default">Modificar</a></td>
			
		</tr>
		<?php
	}
	?>
</tbody>
</table>