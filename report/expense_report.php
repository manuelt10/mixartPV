<?php 
#
date_default_timezone_set ('America/La_Paz');
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
	
	$producto_entrada = $db->selectRecord('v_product_entry_hd',NULL,$where);
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
	
	<h1>Reporte de Gastos</h1>
	<h4>Generado el $date</h4><br>
	<h3>Gastos en Productos</h3>
	<table>
		<tr class='header'>
			<td width='50'><strong>ID</strong></td>
			<td width='200'><strong>Nombre</strong></td>
			<td width='140'><strong>Fecha Creacion</strong></td>
			<td width='50' align='right'><strong>Total</strong></td>
		</tr>
	";
	$total1 = 0;
	$n = 0;
	foreach($producto_entrada->data as $c)
	{
		$total1 = $total1 + $c->total;
		$content = $content . "
		<tr class='body'>
			<td width='50'>$c->id_product_entry</td>
			<td width='200'>$c->name</td>
			<td width='140'  align='right'>$c->created_date</td>
			<td width='50'  align='right'>" . number_format($c->total,2) . "</td>
		</tr>
		";
		$n++;
	}
	$content = $content . "
		<tr class='body'>
			<td width='50'></td>
			<td width='200'></td>
			<td width='140'  align='right'></td>
			<td width='50'  align='right'><strong>" . number_format($total1,2) . "</strong></td>
		</tr>
		</table>
		";
	#Gastos Particulares
	$records = $db->selectRecord('inv_expenses',NULL,$where,array('id_expenses' => 'desc'));
	$content = $content . "
	<h3>Gastos Particulares</h3>
	<table>
		<tr class='header'>
			<td width='50'><strong>ID</strong></td>
			<td width='200'><strong>Concepto</strong></td>
			<td width='140'><strong>Fecha Creacion</strong></td>
			<td width='50' align='right'><strong>Total</strong></td>
		</tr>
	";
	$n = 0;
	$total2 = 0;
	foreach($records->data as $c)
	{
		$total2 = $total2 + $c->total;
		$content = $content . "
		<tr class='body'>
			<td width='50'>$c->id_expenses</td>
			<td width='200'>$c->concept</td>
			<td width='140'  align='right'>$c->created_date</td>
			<td width='50'  align='right'>" . number_format($c->total,2) . "</td>
		</tr>
		";
		$n++;
	}
	$content = $content . "
		<tr class='body'>
			<td width='50'></td>
			<td width='200'></td>
			<td width='140'  align='right'></td>
			<td width='50'  align='right'><strong>" . number_format($total2,2) . "</strong></td>
		</tr>
		</table>
		";
	$content = $content . "
		
	<p>Cantidad de Gastos: <strong>$n</strong></p>
	<p>Total de Gastos: <strong>" . number_format($total1 + $total2,2) . "</strong></p>
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
	#$producto_entrada_det = $db->selectRecord('inv_product_entry_det',NULL,array('id_product_entry' => $_GET["id"]));
	#$producto_entrada = $producto_entrada->data[0];
}
?>