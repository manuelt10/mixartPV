<div class="div_float">
	<div>
		<div>
		<a href="?form=16" class="btn btn-default">Realizar Entrada</a>
	</div><br>
	<?php 
	$records = $db->selectRecord('v_product_entry_hd', NULL, array('id_company' => $usr->userdata->id_company), array('id_product_entry' => 'desc'));
	?>
	<legend>Listado de Entradas</legend>
	<table class="table">
		<thead>
			<tr>
				<th>Id</th>
				<th>Usuario</th>
				<th width="100">Fecha</th>
				<th>Total($)</th>
			</tr>
		</thead>
		<tbody class="productEntryList">
			<?php 
			foreach($records->data as $c)
			{
				?>
				<tr>
					<td><?php echo $c->id_product_entry; ?></td>
					<td><?php echo $c->name ?></td>
					<td width="100"><?php echo $c->created_date ?></td>
					<td><?php echo $c->total; ?></td>
					<td><a href="?form=18&id=<?php echo $c->id_product_entry; ?>" class="btn btn-default">Ver Entrada</a></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	</div>
	<div>
		<div>
		<a href="?form=26" class="btn btn-default">Registrar Gasto</a>
	</div><br>
	<?php 
	$records = $db->selectRecord('inv_expenses', NULL, array('id_company' => $usr->userdata->id_company), array('id_expenses' => 'desc'));
	?>
	<legend>Listado de Gastos Particulares</legend>
	<table class="table">
		<thead>
			<tr>
				<th>Id</th>
				<th>Concepto</th>
				<th>Fecha</th>
				<th>Gasto($)</th>
			</tr>
		</thead>
		<tbody class="productEntryList">
			<?php 
			foreach($records->data as $c)
			{
				?>
				<tr>
					<td><?php echo $c->id_expenses; ?></td>
					<td><?php echo $c->concept ?></td>
					<td><?php echo $c->created_date ?></td>
					<td><?php echo $c->total; ?></td>
					<td><a href="?form=18&id=<?php echo $c->id_product_entry; ?>" class="btn btn-default">Ver Entrada</a></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	</div>
</div>