<?php 
session_start();
$session = $_SESSION;
session_write_close();
require_once('loader.php');

//class creation
$db = new mysqlManager();
$sM = new stringManager();
$usr = new user($session["user"]);

if(!empty($_POST["id_role"]))
{
	if(!empty($session["user"]))
	{
		if(!empty($_POST["rol"]))
		{
			$role = $sM->cleanVariable($_POST["rol"]);
			$description = $sM->cleanVariable($_POST["description"]);
			$current_date = date('Y-m-d H:i:s');
			$records = array(
				'role' => $role,
				'description' => $description,
				'updated_by' => $session["user"],
				"id_company" => $usr->userdata->id_company,
				"updated_date" => $current_date
			);
			$db->updateRecord('app_role', $records,array('id_role' => $_POST["id_role"]));
			
			$db->deleteRecord('app_role_menu', array('id_role' => $_POST["id_role"]));
			foreach($_POST["selected_values"] as $key => $sv){
				$records = array(
				'id_role' => $_POST["id_role"],
				'id_menu' => $sv,
				'created_by' => $session["user"]
				);
				$db->insertRecord('app_role_menu', $records);
			}
			
			header('Location: ../back.php?form=7');
		}
	}
}
#header('Location: '. $_SERVER["HTTP_REFERER"]);
?>