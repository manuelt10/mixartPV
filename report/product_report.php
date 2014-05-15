<?php 
session_start();
$session = $_SESSION;
session_write_close();
if(!empty($session["user"]))
{
	require_once('../html2pdf/html2pdf.class.php');
	require_once('loader.php');
	$usr = new user($session["user"]);
	$db = new mysqlManager();
	$date = date('d-m-Y');
	
	$id_user = $usr->userdata->id_user;
	$name_user = $usr->userdata->name;
	$where = array(
		'id_company' => $usr->userdata->id_company
	);
	$records = $db->selectRecord('inv_product',NULL,$where,array('id_product' => 'desc'));
	$content = "
	<style>
		h1, h2
		{
			margin: 0px;
			padding: 0px;
		}
		.header td
		{
			font-size: 14px;
			font-weight: normal;
			border-bottom: 2px solid #000000;
			padding: 10px 8px;
		}
		.body td
		{
			padding: 10px 8px;
			/*border-bottom: 1px solid #000000;*/
		}
	</style>
	<page_header>
	<p style='text-align: right'>Reporte generado por $id_user - $name_user</p>
	</page_header>
	
	<h1>Reporte General de Productos</h1>
	<h4>Generado el $date</h4>
	<table>
		<tr class='header'>
			<td width='50'><strong>ID</strong></td>
			<td width='200'><strong>Nombre</strong></td>
			<td width='50'  align='right'><strong>Precio Unitario</strong></td>
			<td width='50'  align='right'><strong>Precio Costo</strong></td>
			<td width='50' align='right'><strong>Existencia</strong></td>
		</tr>
	";
	$n = 0;
	foreach($records->data as $c)
	{
		$content = $content . "
		<tr class='body'>
			<td width='50'>$c->id_product</td>
			<td width='200'>$c->name</td>
			<td width='50'  align='right'>$c->unit_price</td>
			<td width='50'  align='right'>$c->unit_cost</td>
			<td width='50'  align='right'>$c->existence</td>
		</tr>
		";
		$n++;
	}
	
	$content = $content . "
	
	</table>
	
	<p>Cantidad de Productos: <strong>$n</strong></p>
	  <page_footer>
	    [[page_cu]]/[[page_nb]]
	  </page_footer>
	";
	$html2pdf = new HTML2PDF('P', 'Letter', 'en');
	$html2pdf->pdf->SetAuthor('Manuel Rosario');
	$html2pdf->pdf->SetTitle('Reporte General de Productos');
	$html2pdf->pdf->SetSubject('Productos');
	$html2pdf->writeHTML($content);
	$html2pdf->Output(date('YmdHis') . '.' . 'pdf');

}
?>
