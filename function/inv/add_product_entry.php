<?php 
session_start();
$session = $_SESSION;
session_write_close();
require_once('loader.php');
//class creation

if(!empty($_POST["id_product"]) or !empty($_POST["quantity"]))
{
	$db = new mysqlManager();
	$records = array(
		'id_company' => $_POST["id_company"],
		'created_by' => $session["user"],
		'total' => 0
	);
	$insert = $db->insertRecord('inv_product_entry', $records);
	$lastid = $insert->lastid;
	$total = 0;
	foreach($_POST["id_product"] as $k => $v)
	{
		
		$where = array(
			'id_product' => $v
		);
		$product = $db->selectRecord('inv_product', NULL, $where);
		$product = $product->data[0];
		$total_cost = $product->unit_cost * $_POST["quantity"][$k];
		$total = $total + $total_cost;
		$records = array(
			'id_product_entry' => $lastid,
			'id_product' => $v,
			'cod_product' => $product->cod_product,
			'name' => $product->name,
			'quantity' => $_POST["quantity"][$k],
			'unit_cost' => $product->unit_cost,
			'total_cost' => $total_cost
		);
		$db->insertRecord('inv_product_entry_det', $records);
	}
	$db->updateRecord('inv_product_entry', array('total' => $total),array('id_product_entry' => $lastid));
	header("Location: ../../back.php?form=17");
	
}
else
{
	header('Location: ' . $_SERVER["HTTP_REFERER"]);
}

?>