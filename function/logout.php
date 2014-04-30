<?php 
session_start();
if(!empty($_SESSION["iduser"]))
	unset($_SESSION["iduser"]);
session_write_close();

header("Location: ../login.php");
?>