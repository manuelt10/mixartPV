<?php 
$where = array(
		'id_company' => $usr->userdata->id_company
	);
$records = $db->selectRecord('v_transaction_header',NULL,$where,array('id_transaction' => 'desc'));
?>
<legend>Listado de Transacciones</legend>
<table class="table">
	<thead>
		<tr>
			<th>Id</th>
			<th>Nombre del Cliente</th>
			<th>Fecha</th>
			<th>Subtotal</th>
			<th>Itbis</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($records->data as $t) {
		?>
		<tr>
			<td><?php echo $t->id_transaction; ?></td>
			<td><?php echo $t->client_name; ?></td>
			<td><?php echo $t->created_date; ?></td>
			<td><?php echo $t->subtotal; ?></td>
			<td><?php echo $t->itbis; ?></td>
			<td><?php echo $t->total; ?></td>
			<td><a target="_blank" href="report/facturation.php?id=<?php echo $t->id_transaction ?>" class="btn btn-default">Reimprimir</a></td>
		</tr>
		<?php
	}
	?>
</tbody>
</table>