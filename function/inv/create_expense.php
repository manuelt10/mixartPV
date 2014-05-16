<?php 
session_start();
$session = $_SESSION;
session_write_close();
require_once('loader.php');
//class creation
$db = new mysqlManager();
$sM = new stringManager();
if(!empty($session["user"]))
{
	$concept = $sM->cleanVariable($_POST["concept"]);
	$records = array(
		'id_company' => $_POST["id_company"],
		'concept' => $concept,
		'total' => $_POST["total"],
		'created_by' => $session["user"]
	);
	$db->insertRecord('inv_expenses', $records);
	header("Location: ../../back.php?form=17");
}