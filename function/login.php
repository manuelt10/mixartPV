<?php 
require_once('loader.php');

if(empty($_POST["username"]) or empty($_POST["password"]))
{
	header('Location: ' . $_SERVER["HTTP_REFERER"]);
}
else
{
	$username = $_POST["username"];
	$password = $_POST["password"];
	$db = new mysqlManager();
	$where = Array('username' => $username);
	$query = $db->selectRecord('usr_user', NULL, $where);
	if(!empty($query->data))
	{
		if(md5($password) == $query->data[0]->password)
		{
			session_start();
			$_SESSION["user"] = $query->data[0]->id_user;
			session_write_close();
			header('Location: ../back.php');
		}
		else
		{
			header('Location: ' . $_SERVER["HTTP_REFERER"]);
		}
	}
	else
	{
		header('Location: ' . $_SERVER["HTTP_REFERER"]);
	}
}
?>