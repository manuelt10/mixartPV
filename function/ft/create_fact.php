<?php 
session_start();
$session = $_SESSION;
session_write_close();
require_once('loader.php');
//class creation
$db = new mysqlManager();
if(!empty($session["user"]))
{
	if(!empty($_POST["cod_cliente"]) and !empty($_POST["total"]))
	{
		$records = array(
			'id_company' => $_POST["id_company"],
			'document' => 'FT',
			'id_client' => $_POST["cod_cliente"],
			'ncf' => '',
			'created_by' => $session["user"],
			'subtotal' => $_POST["subtotal"],
			'itbis' => $_POST["itbis"],
			'total' => $_POST["total"]
		);
		$insert = $db->insertRecord('ft_transaction', $records);
		foreach($_POST["id_product"] as $k => $v)
		{
			if($_POST["quantity"][$k] > 0)
			{
				$product = $db->selectRecord('inv_product',NULL,array('id_product' => $v));
				$itbis = $product->data[0]->unit_price * $_POST["quantity"][$k] * 0.18;
				$subtotal = $product->data[0]->unit_price * $_POST["quantity"][$k];
				$records = array(
					'id_transaction' => $insert->lastid,
					'id_product' => $v,
					'cod_product' => $product->data[0]->cod_product,
					'name' => $product->data[0]->name,
					'unit_price' => $product->data[0]->unit_price,
					'quantity' => $_POST["quantity"][$k],
					'subtotal' => $subtotal,
					'itbis' => number_format($itbis, 2),
					'total' => $subtotal + $itbis
				);
				$db->insertRecord('ft_transaction_det', $records);
				$db->updateRecord('', $records);
			}
		}
		header('Location: ../../report/facturation.php?id=' . $insert->lastid);
	}
	else {
		header('Location: ' . $_SERVER["HTTP_REFERER"]);
	}
}
?>