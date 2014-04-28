<?php 
session_start();
$session = $_SESSION;
session_write_close();
require_once('loader.php');

//class creation
$db = new mysqlManager();
$sM = new stringManager();
$usr = new user($session["user"]);

if(!empty($session["user"]))
{
	if(!empty($_POST["rol"]))
	{
		$role = $sM->cleanVariable($_POST["rol"]);
		$description = $sM->cleanVariable($_POST["description"]);
		$records = array(
			'role' => $role,
			'description' => $description,
			'created_by' => $session["user"],
			"id_company" => $usr->userdata->id_company,
		);
		$insert = $db->insertRecord('app_role', $records);
		
		foreach($_POST["selected_values"] as $key => $sv){
			$records = array(
			'id_role' => $insert->lastid,
			'id_menu' => $sv,
			'created_by' => $session["user"]
			);
			$db->insertRecord('app_role_menu', $records);
		}
		
		header('Location: ../back.php?form=7');
	}
}
?>