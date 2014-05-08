<?php 
require_once('../html2pdf/html2pdf.class.php');
require_once('../classes/mysqlManager.php');

if(!empty($_GET["id"]))
{
	$db = new mysqlManager();
	$transaction = $db->selectRecord('v_transaction_header',NULL, array('id_transaction' => $_GET["id"]));
	$transaction = $transaction->data[0];
	$transaction_det = $db->selectRecord('ft_transaction_det',NULL, array('id_transaction' => $_GET["id"]));
	$content =  "
	<style>
		 td, td
		{
		padding: 5px;
		}
		.head td
		{
			border-bottom: 1px solid #888888;
		}
		.smallnote
		{
			font-size: 0.8em;
			color: #843534;
		}
	</style>
	<h2>$transaction->company_name</h2>
	<span>Telefono: $transaction->company_phone Dirección: $transaction->company_address </span>
	<table>
		<tr>
			<td><h3>Datos de la Factura</h3>
				<table>
					<tr>
						<td><strong>No. de Factura: </strong></td>
						<td>$transaction->id_transaction</td>
					</tr>
					<tr>
						<td><strong>Fecha: </strong></td>
						<td>$transaction->created_date</td>
					</tr>
					<tr>
						<td><strong>Cliente: </strong></td>
						<td>$transaction->id_client - $transaction->client_name</td>
					</tr>
					<tr>
						<td><strong>Teléfono cliente: </strong></td>
						<td>$transaction->client_phone</td>
					</tr>
					<tr>
						<td><strong>Dirección del cliente: </strong></td>
						<td>$transaction->client_address</td>
					</tr>
				</table>
			</td>
			<td>
				<table>
					<tr>
						<td><strong>Subtotal:  </strong></td>
						<td>$transaction->subtotal</td>
					</tr>
					<tr>
						<td><strong>Itbis: </strong></td>
						<td>$transaction->itbis</td>
					</tr>
					<tr>
						<td><strong>Total General: </strong></td>
						<td>$transaction->total</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
		
		
		
		<br><br><br>
		
		
		<table>
			<tr class='head'>
				<td>Id</td>
				<td>Codigo</td>
				<td>Nombre</td>
				<td>Precio</td>
				<td>Cantidad</td>
				<td>Subtotal</td>
				<td>Itbis</td>
				<td>Total</td>
			</tr>
		";
		
		foreach($transaction_det->data as $td)
		
		{
			$content = $content . 
			"
			<tr>
				<td>$td->id_product</td>
				<td>$td->cod_product</td>
				<td>$td->name</td>
				<td>$td->unit_price</td>
				<td>$td->quantity</td>
				<td>$td->subtotal</td>
				<td>$td->itbis</td>
				<td>$td->total</td>
			</tr>
			";
		}
		$content = $content . "
		</table>
		<p class='smallnote'>Esta factura fue creada por el usuario $transaction->created_by - $transaction->user_name </p>
		";
	$html2pdf = new HTML2PDF('P', 'Letter', 'en');
	$html2pdf->pdf->SetAuthor('Manuel Rosario');
	$html2pdf->pdf->SetTitle('Reporte de Factura');
	$html2pdf->pdf->SetSubject('Factura');
	$html2pdf->writeHTML($content);
	$html2pdf->Output(date('YmdHis') . '.' . 'pdf');
	#echo $content;
	
	?>
	


		
			
	
	
	
	<?php
}
?>
<script>
	window.location.href = "../back.php?form=20";
</script>

