<?php 
date_default_timezone_set ('America/La_Paz');
function autoLoader($class)
{
    $path = "../../classes/$class.php";
    include $path;
}
spl_autoload_register('autoLoader');
?>