<?php 
if(!empty($_GET["id"]))
{
	$record = $db->selectRecord('inv_product', NULL, array('id_product' => $_GET["id"], 'id_company' => $usr->userdata->id_company));
	if($record->rowcount == 1)
	{
		$record = $record->data[0];
		?>
<style>
	.actualImage{
			width: 400px;
			height: 400px;
			position: relative;
			overflow: hidden;
			border: dashed 1px #AAA;
			border-radius: 4px;
		}
		
		.actualImage img{
			position: relative;
		}
</style>

<form class="form-group" method="post" action="function/inv/update_product.php" enctype="multipart/form-data">
	<input type="hidden" name="id_company" value="<?php echo $usr->userdata->id_company ?>">
	<input type="hidden" name="id_product" value="<?php echo $_GET["id"] ?>">
	<fieldset class="col-md-6">
		<legend>Creación de Producto</legend>
		<label class="black-label">Código: </label><input type="text" value="<?php echo $record->cod_product; ?>" name="cod_product" placeholder="Código Producto" class="form-control" maxlength="25"><br>
		<label class="black-label">Nombre del Producto: </label><input type="text" value="<?php echo $record->name; ?>" name="name" placeholder="Nombre del Producto" class="form-control" maxlength="50" required><br>
		<label class="black-label">Descripcion del Producto: </label><textarea placeholder="Descripción" name="description" class="form-control"><?php echo $record->description;?></textarea><br>
		<label class="black-label">Precio Unitario: </label><input type="text" value="<?php echo $record->unit_price; ?>" name="unit_price" class="form-control onlyNumber" placeholder="Precio Unitario" required><br>
		<label class="black-label">Precio de Costo: </label><input type="text" name="unit_cost" value="<?php echo $record->unit_cost; ?>" class="form-control onlyNumber" placeholder="Precio de Costo" required><br>
		<?php echo empty($session["error"]["numericValue"]) ? "" : $session["error"]["numericValue"]; ?>
		<label class="black-label"><input type="checkbox" name="active" value="1" <?php echo $record->active == 1 ? "checked" : "" ?>> Activo</label><br>
		<button type="submit" class="btn btn-default">Enviar</button><a href="back.php?form=10" class="btn btn-danger">Cancelar</a>
	</fieldset>
	<fieldset class="col-md-6">
		<legend>Imagen del Producto</legend>
		<label>Tamaño de la imagen debe ser minimo 400x400, en caso de ser mayor se cortara.</label>
		<input type="file" name="image" class="imageUploader" accept="image/*"><br>
		<div class="actualImage projImage">
			<?php 
			if(!empty($record->image))
			{
				?>
				<img src="img/cli/<?php echo $record->image ?>">
				<?php
			}
			?>
		</div>
		<input type="hidden" class="coorX" name="x" value="0">
		<input type="hidden" class="coorY" name="y" value="0">
	</fieldset>
	
</form>

<script type="text/javascript">
$(document).ready(function() {
    $('.onlyNumber').keydown(function(event) {
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9  || event.keyCode == 110
            || event.keyCode == 27 || event.keyCode == 13 
            || (event.keyCode == 65 && event.ctrlKey === true) 
            || (event.keyCode >= 35 && event.keyCode <= 39)){
                return;
        }else {
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
    
});
</script>

<script type="text/javascript">
	//Function to create image preview
	function readURL(input) {

	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
			
	        reader.onload = function (e) {
	        	var image = new Image();
				image.src = e.target.result;
				
				image.onload = function(){
					if((this.width >= 400) && (this.height >= 400))
		        	{
			            $('.projImage').html('<img src="' + e.target.result + '">');
			        }
			        else
			        {
			        	alert('The image dimension need to be 565x465.');
			        	var imageUploader = $('.imageUploader');
			        	imageUploader.replaceWith( imageUploader = imageUploader.clone( true ) );
			        	$('.projImage').empty();
			        	$('.coorX').val(0);
			        	$('.coorY').val(0);
			        }
				}
	        	
	        }
	
	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$(".imageUploader").change(function(){
	    readURL(this);
	});
</script>
<script type="text/javascript"> //draggable image repositionator (pending trademark)
	var draggy  = $('.projImage img'),
		clickCoordX,
		clickCoordY,
		lastImgPosX,
		lastImgPosY,
		newImgPosX,
		newImgPosY,
		imgWidthDiff,
		imgHeightDiff;

	$('.actualImage').on('mousedown', 'img', function(event){
		draggy = $(this);
		draggy.addClass('draggable');
		imgWidthDiff 	= (draggy.parent().width() - draggy.width());
		imgHeightDiff 	= (draggy.parent().height() - draggy.height());
		lastImgPosX 	= draggy.offset().left - draggy.parent().offset().left;
		lastImgPosY 	= draggy.offset().top - draggy.parent().offset().top;
		clickCoordX 	= event.pageX;
		clickCoordY 	= event.pageY;
		
	})
	
	$('.actualImage').on('dragstart', draggy, function(event){
		event.preventDefault();
	})
	
	$('html').mouseup(function(){ 
		if(draggy.hasClass('draggable')){
			
			draggy.parent().siblings('.coorX').val((-1)*draggy.position().left);
			draggy.parent().siblings('.coorY').val((-1)*draggy.position().top);
			
		}
		
		draggy.removeClass('draggable');
		
	
	})	
	
	$('html').mousemove(function(event){
		
		if(draggy.hasClass('draggable')){
			
			newImgPosX = (lastImgPosX + (event.pageX - clickCoordX));
			newImgPosY = (lastImgPosY + (event.pageY - clickCoordY));

			if(newImgPosX > 0 && newImgPosY > 0){
				$('.draggable').css({
					left: 0,
					top: 0
				});
				
			}
			
			else if(newImgPosX < imgWidthDiff && newImgPosY > 0){
				$('.draggable').css({
					left: imgWidthDiff,
					top: 0
				});
				
			}
			
			else if(newImgPosX > 0 && newImgPosY < imgHeightDiff){
				$('.draggable').css({
					left: 0,
					top: imgHeightDiff
				});
				
			}
			
			else if(newImgPosX < imgWidthDiff && newImgPosY < imgHeightDiff){
				$('.draggable').css({
					left: imgWidthDiff,
					top: imgHeightDiff
				});
				
			}
			
			else if(newImgPosX > 0){
				$('.draggable').css({
					left: 0,
					top: newImgPosY
				});
				
			}
			
			else if(newImgPosX < imgWidthDiff){
				$('.draggable').css({
					left: imgWidthDiff,
					top: newImgPosY
				});
				
			}
			
			else if(newImgPosY > 0){
				$('.draggable').css({
					left: newImgPosX,
					top: 0
				});
				
			}
			
			else if(newImgPosY < imgHeightDiff){
				$('.draggable').css({
					left: newImgPosX,
					top: imgHeightDiff
				});
				
			}			
			
			else{
				$('.draggable').css({
					left: newImgPosX,
					top: newImgPosY
				});
			}		
		
		}
		
	});
	
</script>

		<?php
	}
}
?>
