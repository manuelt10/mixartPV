<?php 
session_start();
$session = $_SESSION;
session_write_close();
require_once('loader.php');
//class creation
$db = new mysqlManager();
$sM = new stringManager();
if(!empty($session["user"]) and !empty($_POST["username"]) and !empty($_POST["name"]) and !empty($_POST["pass1"]) and !empty($_POST["pass2"]))
{
	if($_POST["pass1"] == $_POST["pass2"])
	{
		if(filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL) or empty($_POST["mail"]))
		{
			$username = $sM->cleanVariable($_POST["username"]);
			$name = $sM->cleanVariable($_POST["name"]);
			$pass = md5($_POST["pass1"]);
			$records = array(
				'id_company' => $_POST["id_company"],
				'username' => $username,
				'password' => $pass,
				'name' => $name,
				'created_by' => $session["user"]
			);
			$insert = $db->insertRecord('usr_user', $records);
			$records = array(
				'id_user' => $insert->lastid,
				'id_role' => $_POST["role"],
				'created_by' => $session["user"]
			);
			$db->insertRecord('usr_user_role', $records);
			header('Location: ../../back.php?form=22');
		}
		else
		{
			session_start();
			$_SESSION["error"]["isNotEmail"] = "<label class='error-label'>No es un correo valido</label><br>";
			echo "<script>window.history.go(-1);</script>";
			session_write_close();
		}
	}
	else
	{
		session_start();
		$_SESSION["error"]["passNotEqual"] = "<label class='error-label'>Las contraseñas no coinciden</label><br>";
		echo "<script>window.history.go(-1);</script>";
		session_write_close();
	}
}
?> 