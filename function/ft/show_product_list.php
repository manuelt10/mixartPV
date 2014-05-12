<?php 
session_start();
$session = $_SESSION;
session_write_close();
require_once('loader.php');
//class creation
$db = new mysqlManager();
if(!empty($session["user"]))
{
	$where = array(
		'id_company' => $_POST["id_company"],
		'active' => 1
	);
	$records = $db->selectRecord('inv_product', NULL, $where);
	
}
?>
<div>
	<legend>Listado de Productos</legend>
	<table class="table">
		<thead>
			<tr>
				<th>Id</th>
				<th>Codigo</th>
				<th>Nombre</th>
				<th>Precio</th>
				<th>Existencia</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach ($records->data as $i) {
			?>
			<tr>
				<td class="id_product"><?php echo $i->id_product; ?></td>
				<td class="cod_product"><?php echo $i->cod_product; ?></td>
				<td class="name"><?php echo $i->name; ?></td>
				<td class="unit_cost"><?php echo $i->unit_price; ?></td>
				<td class="existence"><?php echo $i->existence; ?></td>
				<td><button class="btn btn-default addProduct">Agregar Producto a Entrada</button></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	</table>
	
</div>

<br>
<button type="button" class=" btn btn-default closeLightbox">Close</button>