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
		'id_company' => $_POST["id_company"]
	);
	$records = $db->selectRecord('cli_client', NULL, $where);
	
}
?>

<div>
	<legend>Listado de Clientes</legend>
	<table class="table">
		<thead>
			<tr>
				<th>Id</th>
				<th>Nombre</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		foreach ($records->data as $i) {
			?>
			<tr>
				<td class="id_client"><?php echo $i->id_client; ?></td>
				<td class="name"><?php echo $i->name; ?></td>
				<td><button class="btn btn-default addClient">Seleccionar Cliente</button></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	</table>
</div>

<br>
<button type="button" class=" btn btn-default closeLightbox">Close</button>