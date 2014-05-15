<?php 
session_start();
$session = $_SESSION;
session_write_close();
require_once('loader.php');
//class creation
$db = new mysqlManager();
if(!empty($session["user"]) and !empty($_POST["role"]))
{
	$db->deleteRecord('usr_user_role',array('id_user' => $_POST["id_user"]));
	$records = array(
		'id_user' => $_POST["id_user"],
		'id_role' => $_POST["role"],
		'created_by' => $session["user"]
	);
	$db->insertRecord('usr_user_role', $records);
}
?> 