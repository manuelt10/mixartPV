<?php 
function autoLoader($class)
{
    $path = "../classes/$class.php";
    include $path;
}
spl_autoload_register('autoLoader');
?>