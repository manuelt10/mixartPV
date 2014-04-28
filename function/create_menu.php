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
	if(!empty($_POST["menu"]))
	{
		$menu = $sM->cleanVariable($_POST["menu"]);
		$description = $sM->cleanVariable($_POST["menu_description"]);
		$records = array(
		"id_company" => $usr->userdata->id_company,
		"menu" => $menu,
		"description" => $description,
		"created_by" => $session["user"]
		);
		
		$insert = $db->insertRecord('app_menu', $records);
		
		foreach($_POST["menu_forms"] as $mf => $val)
		{
			$records = array(
				'id_menu' => $insert->lastid,
				'id_form' => $val,
				'created_by' => $session["user"]
			);
			$db->insertRecord('app_menu_form', $records);
		}
		
		header('Location: ../back.php?form=6');
	}
}


?>