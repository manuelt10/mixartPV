<?php 
session_start();
$session = $_SESSION;
session_write_close();
require_once('loader.php');
//class creation
$db = new mysqlManager();
$sM = new stringManager();
//is user is logged
if(!empty($session["user"]))
{
	//form_name and archive are required
	if(!empty($_POST["form_name"]) and !empty($_POST["form_archive"]))
	{
		//Clean variables 
		$form_archive = trim($_POST["form_archive"]);
		$forma = $db->selectRecord('app_form',NULL,array('form' => $form_archive));
		//file can't exist
		if($forma->rowcount == 0)
		{
			$form_name = $sM->cleanVariable($_POST["form_name"]);
			$form_description = $sM->cleanVariable($_POST["form_description"]);
			$records = array(
				'form' => $_POST["form_archive"],
				'form_name' => $form_name,
				'description' => $form_description,
				'created_by' => $session["user"]
			);
			
			//insert
			$db->insertRecord('app_form', $records);
			header('Location: ../back.php?form=2');
		}
		else
		{
			session_start();
			$_SESSION["error"] = 'file exist';
			session_write_close();
			header('Location: '. $_SERVER["HTTP_REFERER"]);
		}
	}
	else {
		session_start();
		$_SESSION["error"] = '';
		session_write_close();
		header('Location: '. $_SERVER["HTTP_REFERER"]);
	}
}
?>