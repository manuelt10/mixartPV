<?php 
$producto_entrada_det = $db->selectRecord('inv_product_entry_det',NULL,array('id_product_entry' => $_GET["id"]));
$producto_entrada = $db->selectRecord('v_product_entry_hd',NULL,array('id_product_entry' => $_GET["id"]));
$producto_entrada = $producto_entrada->data[0];
?>

<div class="productEntry"><br>
	
	<h4 class="black-label">Usuario: <?php echo $producto_entrada->name ?></h4>
	<h4 class="black-label">Fecha: <?php echo $producto_entrada->created_date ?></h4>
	
	<br>
	<legend>Listado de Productos de la Entrada</legend>
	<table class="table">
		<thead>
			<tr>
				<th>Id</th>
				<th>Codigo</th>
				<th>Nombre</th>
				<th>Precio de Costo</th>
				<th>Cantidad</th>
				<th>Total($)</th>
			</tr>
		</thead>
		<tbody class="productEntryList">
			<?php 
			foreach($producto_entrada_det->data as $ped)
			{
				?>
				<tr>
					<td class="id_product"><?php echo $ped->id_product ?></td>
					<td class="cod_product"><?php echo $ped->cod_product ?></td>
					<td class="name"><?php echo $ped->name ?></td>
					<td class="unit_cost"><?php echo $ped->unit_cost ?></td>
					<td class="quantity"><?php echo $ped->quantity ?></td>
					<td class="total"><?php echo $ped->total_cost ?></td>
				</tr>
				<?php
			}
			?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>TOTAL: </td>
					<td><?php echo $producto_entrada->total ?></td>
				</tr>
		</tbody>
	</table>
	<a href="?form=17" class="btn btn-danger">< Volver al Listado</a>
</div>