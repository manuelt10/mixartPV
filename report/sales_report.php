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
	if(!empty($_GET["cod_cliente"]))
	{
		$where = array(
		'id_company' => $usr->userdata->id_company,
		'id_client' => $_GET["cod_cliente"]);
	}
	
	$records = $db->selectRecord('v_transaction_header',NULL,$where,array('id_transaction' => 'desc'));
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
	
	<h1>Reporte de Ventas</h1>
	<h4>Generado el $date</h4>
	<table>
		<tr class='header'>
			<td width='30'><strong>ID</strong></td>
			<td width='30'><strong>Cliente</strong></td>
			<td width='140'><strong>Nombre Cliente</strong></td>
			<td width='140'><strong>Fecha</strong></td>
			<td width='50'  align='right'><strong>Subtotal</strong></td>
			<td width='50' align='right'><strong>Itbis</strong></td>
			<td width='50' align='right'><strong>Total</strong></td>
		</tr>
	";
	$n = 0;
	$total = 0;
	$subtotal = 0;
	$itbis = 0;
	foreach($records->data as $c)
	{
		$newDate = date("Y-m-d", strtotime($c->created_date));
		if((($newDate >= $_GET["fecha_inicio"]) and ($newDate <= $_GET["fecha_final"])) or (empty($_GET["fecha_inicio"]) or empty($_GET["fecha_final"])))
		{
		$total = $total + $c->total;
		$subtotal = $subtotal + $c->subtotal;
		$itbis = $itbis +  $c->itbis;
		$content = $content . "
		<tr class='body'>
			<td width='30'>$c->id_transaction</td>
			<td width='30'>$c->id_client</td>
			<td width='140'>$c->client_name</td>
			<td width='140'>$c->created_date</td>
			<td width='50' align='right'>" . number_format($c->subtotal,2) . "</td>
			<td width='50' align='right'>" . number_format($c->itbis,2) . "</td>
			<td width='50' align='right'>" . number_format($c->total,2) . "</td>
		</tr>
		";
		$n++;
		}
	}
	
	$content = $content . "
		<tr class='body'>
			<td width='30'></td>
			<td width='30'></td>
			<td width='140'></td>
			<td width='140'></td>
			<td width='50' align='right'><strong>" . number_format($subtotal,2) . "</strong></td>
			<td width='50' align='right'><strong>" . number_format($itbis,2) . "</strong></td>
			<td width='50' align='right'><strong>" . number_format($total,2) . "</strong></td>
		</tr>
	
	</table>
	
	<p>Cantidad de Transacciones: <strong>$n</strong></p>
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