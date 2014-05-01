<?php 
session_start();
$session = $_SESSION;
session_write_close();
require_once('loader.php');
//class creation
$db = new mysqlManager();
$sM = new stringManager();
$iM = new imageManager();

if(!empty($session["user"]))
{
	if(!empty($_POST["name"]) or !empty($_POST["address1"]) or !empty($_POST["phone1"]) or !empty($_POST["id_client"]))
	{
		$client = $db->selectRecord('cli_client', NULL, array('id_client' => $_POST["id_client"]));
		$name = $sM->cleanVariable($_POST["name"]);
		$address1 = $sM->cleanVariable($_POST["address1"]);
		$address2 = $sM->cleanVariable($_POST["address2"]);
		$phone1 = $sM->cleanVariable($_POST["phone1"]);
		$phone2 = $sM->cleanVariable($_POST["phone2"]);
		$rnc = $sM->cleanVariable($_POST["rnc"]);	
		
		$imageName = $sM->generateFullRandomCode();
		$imagewh = 400;
		$path = '../../img/cli/';
		
		if($iM->cropImage($path, $_FILES["image"], $imageName, $_POST["x"], $_POST["y"], $imagewh, $imagewh))
		{
			
			$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			$image = $imageName . '.' .$ext;
			unlink($path.$client->image);
		}
		else
		{
			$image= NULL;
		}
		
		$records = array(
			'id_company' => $_POST["id_company"],
			'name' => $name,
			'address1' => $address1,
			'address2' => $address2,
			'phone1' => $phone1,
			'phone2' => $phone2,
			'active' => $_POST["active"],
			'rnc' => $rnc,
			'image' => $image,
			'updated_by' => $session["user"],
			'updated_date' => date('Y-m-d H:i:s')
		);
		$db->updateRecord('cli_client', $records, array('id_client' => $_POST["id_client"]));
		header('Location: ../../back.php?form=13');
	}
	else
	{
		session_start();
		$_SESSION["error"]["emptyData"] = "<label class='error-label'>Campos requeridos vacios.</label><br>";
		session_write_close();
		echo "<script>window.history.go(-1)</script>";
		#header('Location: ' . $_SERVER["HTTP_REFERER"]);
	}
}
?>