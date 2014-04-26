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
	if(!empty($_POST["menu"]) or !empty($_POST["id_menu"]))
	{
		$menu = $sM->cleanVariable($_POST["menu"]);
		$description = $sM->cleanVariable($_POST["menu_description"]);
		$current_date = date('Y-m-d H:i:s');
		$records = array(
		"id_company" => $usr->userdata->id_company,
		"menu" => $menu,
		"description" => $description,
		"updated_by" => $session["user"],
		"updated_date" => $current_date
		);
		
		$db->updateRecord('app_menu', $records, array('id_menu' => $_POST["id_menu"]));
		$db->deleteRecord('app_menu_form',array('id_menu' => $_POST["id_menu"]));
		foreach($_POST["menu_forms"] as $mf => $val)
		{
			$records = array(
				'id_menu' => $_POST["id_menu"],
				'id_form' => $val,
				'created_by' => $session["user"]
			);
			$db->insertRecord('app_menu_form', $records);
		}
		header('Location: ../back.php?form=6');
	}
}


?>