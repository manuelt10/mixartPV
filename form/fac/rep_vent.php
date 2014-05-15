<?php 
$date = date('d-m-Y');
?>
<form method="get" action="report/sales_report.php" target="_blank">
	<div class="form-group">
		<label class="black-label">Fecha de Inicio</label>
		<input type="date" name="fecha_inicio" class="form-control" value="<?php echo $date ?>">
		<label class="black-label">Fecha de Final</label>
		<input type="date" name="fecha_final" class="form-control"  value="<?php echo $date ?>">
		<label class="black-label">Codigo de Cliente</label>
		<input type="text" name="cod_cliente" class="form-control client_list id_client" ><label>Al dar doble click puedes ver la lista de clientes</label><br>
		<textarea class="form-control client_name" readonly></textarea><br>
		<button type="submit" class="btn btn-default">Generar</button>
	</div>
</form>
<div class="lighBoxContainer">
	<div id="light" class="white_content">	
	</div>
	<div id="fade" class="black_overlay">
	</div>
</div>
<script>
	$('.lighBoxContainer').on("click", '.addClient', function(){
		var name = $(this).parent().siblings('.name').html();
		var id_client = $(this).parent().siblings('.id_client').html();
		$('.client_name').html(name);
		$('.id_client').val(id_client);
		$('#light').fadeOut('fast');
		$('#fade').fadeOut('fast');
	});
</script>

<script>
//Client lightbox
$(function() {
	$('.client_list').dblclick(function(){
		$.ajax({
			type : "POST",
			url : "function/ft/show_client_list.php",
			data : {id_company : <?php echo $usr->userdata->id_company ?>}
		}).done(function(html)
		{
			$('.white_content').html(html);
			$('#light').fadeIn('fast');
			$('#fade').fadeIn('fast');
		});
		
	});
});
</script>

<script>
$(function() {
	$('.lighBoxContainer').on("click", '.closeLightbox', function(){
		$('#light').fadeOut('fast');
		$('#fade').fadeOut('fast');
	});
});
</script>