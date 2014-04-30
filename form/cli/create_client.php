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

<form class="form-group" method="post" action="" enctype="multipart/form-data">
	<input type="hidden" name="id_company" value="<?php echo $usr->userdata->id_company ?>">
	<fieldset class="col-md-6">
		<legend>Creación de Cliente</legend>
		<input type="text" name="name" placeholder="Nombre del Cliente" class="form-control" required><br>
		<textarea placeholder="Direccion Principal" class="form-control"></textarea><br>
		<textarea placeholder="Direccion Secundaria" class="form-control"></textarea><br>
		<input type="text" name="phone1" class="form-control" placeholder="Telefono Principal"><br>
		<input type="text" name="phone2" class="form-control" placeholder="Telefono Secundario"><br>
		<label><input type="checkbox" name="active" value="1" checked> Activo</label><br>
		<button type="submit" class="btn btn-default">Enviar</button><a href="back.php?form=10" class="btn btn-danger">Cancelar</a>
	</fieldset>
	<fieldset class="col-md-6">
		<legend>Imagen del Cliente</legend>
		<label>Tamaño de la imagen debe ser minimo 400x400, en caso de ser mayor se cortara.</label>
		<input type="file" name="image" class="imageUploader"><br>
		<div class="actualImage projImage">
			
		</div>
		<input type="hidden" class="coorX" name="x" value="0">
		<input type="hidden" class="coorY" name="y" value="0">
	</fieldset>
	
</form>

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