<?php 
session_start();
$session = $_SESSION;
session_write_close();
require_once('loader.php');
//class creation
$db = new mysqlManager();
$sM = new stringManager();
//is user is logged
if(!empty($session["user"]) and !empty($_POST["id_form"]))
{
	//form_name and archive are required
	if(!empty($_POST["form_name"]) and !empty($_POST["form_archive"]))
	{
		//Clean variables 
		$form_archive = trim($_POST["form_archive"]);
		//file can't exist
			$form_name = $sM->cleanVariable($_POST["form_name"]);
			$form_description = $sM->cleanVariable($_POST["form_description"]);
			$current_date = date('Y-m-d H:i:s');
			$records = array(
				'form' => $_POST["form_archive"],
				'form_name' => $form_name,
				'description' => $form_description,
				'updated_by' => $session["user"],
				'updated_date' => $current_date
			);
			
			//insert
			$db->updateRecord('app_form', $records,array('id_form' => $_POST["id_form"]));
			header('Location: ../back.php?form=2');
	}
	else {
		session_start();
		$_SESSION["error"] = '';
		session_write_close();
		header('Location: '. $_SERVER["HTTP_REFERER"]);
	}
}
else {
	header('Location: '. $_SERVER["HTTP_REFERER"]);
}
?>