<?php 
session_start();
$session = $_SESSION;
session_write_close();
require_once('loader.php');
//class creation
$db = new mysqlManager();
if(!empty($session["user"]) and !empty($_POST["pass1"]))
{
	$db->updateRecord('usr_user', array('password' => md5($_POST["pass1"])),array('id_user' => $_POST["id_user"]));
	header('Location: ../../back.php?form=22');
}
?> 