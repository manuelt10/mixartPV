<?php 
session_start();
$session = $_SESSION;
unset ($_SESSION["error"]);
session_write_close();
if(empty($session["user"]))
{
	header('Location: login.php');
}

function autoLoader($class)
{
    $path = "classes/$class.php";
    include $path;
}
spl_autoload_register('autoLoader');

$db = new mysqlManager();
$usr = new user($session["user"]);
$usr_menus = $usr->get_user_menus();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>MixArt - PV</title>
		<meta name="description" content="">
		<meta name="author" content="MixArt">
		
		<script src="js/jquery.js" type="text/javascript"></script>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="shortcut icon" href="favicon.png">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/st.css" rel="stylesheet">
		<?php 
		if(empty($_GET["form"]))
		{
			?>
			<link href="css/graph-style.css" rel="stylesheet">
			<?php
		}
		?>
	</head>

	<body>
		<div class="topMenu navbar navbar-inverse navbar-fixed-top">
			<div class="collapse navbar-collapse">
				<a href="#"><img class="icon" src="img/mixart-logo-small.png" width="50"></a>
				
				<ul class=" nav navbar-nav navbar-right">
				 	<li>
				 		<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $usr->userdata->name; ?>  <i class="fa fa-sort-asc"></i> </a>
				 		<ul class="dropdown-menu">
			                <li><a href="#">Panel de Control</a></li>
			                <li class="divider"></li>
			                <li><a href="function/logout.php">Salir</a></li>
		                </ul>
				 	</li>
				 	
				</ul>
			
			</div>
			
		</div>
		<div class="leftMenu">
			<nav>
				<?php 
				?>
				<ul>
					<?php 
					foreach($usr_menus as $um)
					{
						?>
						<li>
							<a href="#" class="menuHeader"><?php echo $um->menu; ?></a>
							<?php 
							$form_query = $db->selectRecord('v_menu_form', array('id_form' ,'form', 'form_name'), array('id_menu' => $um->id_menu));
							if($form_query->rowcount > 0)
							{
								?>
								<ul style="display: none" class="subMenu">
									<?php 
									foreach($form_query->data as $fq)
									{
										?>
										<li><a href="?form=<?php echo $fq->id_form ?>"><?php echo $fq->form_name; ?></a></li>
										<?php
									}
									?>
								</ul>
								<?php
							}
							?>
							</li>
						<?php 
					}
					?>
				</ul>
			</nav>
		</div>
		<script>
			$(function()
			{
				$('.menuHeader').click(function(){
					$(this).siblings('.subMenu').toggle('fast');
				});
			});
		</script>