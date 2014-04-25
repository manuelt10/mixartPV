<?php 
require_once('template/hea.php');
?>
		<div class="formWrapper">
			<?php 
			if(!empty($_GET["form"]))
			{
				$current_form = $db->selectRecord('app_form',NULL,array('id_form' => $_GET["form"]));
				$current_form = $current_form->data[0];
				if(file_exists('form/'.$current_form->form))
				{
					require_once('form/'.$current_form->form);
				}
				else
				{
					?>
					<span class="error-label">no existe</span>
					<?php	
				}
			}
			?>
		</div>
<?php 
require_once('template/foo.php');
?>