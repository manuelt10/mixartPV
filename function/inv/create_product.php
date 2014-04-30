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
	if(!empty($_POST["name"]) or !empty($_POST["unit_price"]) or !empty($_POST["unit_cost"]))
	{
		if(is_numeric($_POST["unit_price"]) and is_numeric($_POST["unit_cost"]))
		{
			$name = $sM->cleanVariable($_POST["name"]);
			$description = $sM->cleanVariable($_POST["description"]);
			$cod_product = $sM->cleanVariable($_POST["cod_product"]);
			
			$imageName = $sM->generateFullRandomCode();
			$imagewh = 400;
			$path = '../../img/inv/';
			
			if($iM->cropImage($path, $_FILES["image"], $imageName, $_POST["x"], $_POST["y"], $imagewh, $imagewh))
			{
				$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
				$image = $imageName . '.' .$ext;
			}
			else
			{
				$image= NULL;
			}
			
			$records = array(
				'id_company' => $_POST["id_company"],
				'cod_product' => $cod_product,
				'name' => $name,
				'description' => $description,
				'image' => $image,
				'unit_price' => $_POST["unit_price"],
				'unit_cost' => $_POST["unit_cost"],
				'existence' => 0,
				'active' => $_POST["active"],
				'created_by' => $session["user"]
 			);
			$db->insertRecord('inv_product', $records);
			header('Location: ../../back.php?form=10');
		}
		else
		{
			session_start();
			$_SESSION["error"]["numericValue"] = "<label class='error-label'>Los precios deben ser numeros.</label><br>";
			session_write_close();
			#header('Location: ' . $_SERVER["HTTP_REFERER"]);
			echo "<script>window.history.go(-1)</script>";
		}
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