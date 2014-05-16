<?php 
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
	$records = $db->selectRecord('cli_client',NULL,$where,array('id_client' => 'desc'));
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
	
	<h1>Reporte General de Cliente</h1>
	<h4>Generado el $date</h4>
	<table>
		<tr class='header'>
			<td width='50'><strong>ID</strong></td>
			<td width='200'><strong>Nombre</strong></td>
			<td width='100'><strong>Teléfono</strong></td>
			<td width='200'><strong>Dirección</strong></td>
		</tr>
	";
	$n = 0;
	foreach($records->data as $c)
	{
		$content = $content . "
		<tr class='body'>
			<td width='20'>$c->id_client</td>
			<td width='200'>$c->name</td>
			<td width='100'>$c->phone1</td>
			<td width='200'>$c->address1</td>
		</tr>
		";
		$n++;
	}
	
	$content = $content . "
	
	</table>
	
	<p>Cantidad de Clientes: <strong>$n</strong></p>
	  <page_footer>
	    [[page_cu]]/[[page_nb]]
	  </page_footer>
	";
	$html2pdf = new HTML2PDF('P', 'Letter', 'en');
	$html2pdf->pdf->SetAuthor('Manuel Rosario');
	$html2pdf->pdf->SetTitle('Reporte General de Clientes');
	$html2pdf->pdf->SetSubject('Clientes');
	$html2pdf->writeHTML($content);
	$html2pdf->Output(date('YmdHis') . '.' . 'pdf');

}
?>


	
