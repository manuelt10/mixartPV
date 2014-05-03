
<div>
	<button type="button" class="btn btn-default showLightbox">Agregar Productos</button>
</div>


<div class="lighBoxContainer">
	<div id="light" class="white_content">	
	</div>
	<div id="fade" class="black_overlay">
	</div>
</div>

<form class="productEntry" method="post" action="function/inv/add_product_entry.php"><br>
	<input type="hidden" name="id_company" value="<?php echo $usr->userdata->id_company ?>">
	<legend>Listado de Productos</legend>
	<table class="table">
		<thead>
			<tr>
				<th>Id</th>
				<th>Codigo</th>
				<th>Nombre</th>
				<th>Precio de Costo</th>
				<th>Cantidad</th>
				<th>Total($)</th>
			</tr>
		</thead>
		<tbody class="productEntryList">
		</tbody>
	</table>
	<button class="btn btn-default">Enviar Productos</button>
</form>
<script>
$(function() {
	$('.showLightbox').click(function(){
		$.ajax({
			type : "POST",
			url : "function/inv/show_product_list.php",
			data : {id_company : <?php echo $usr->userdata->id_company ?>}
		}).done(function(html)
		{
			$('.white_content').html(html);
		});
		$('#light').fadeIn('fast');
		$('#fade').fadeIn('fast');
	});
});
</script>
<script>
$(function() {
	$('.lighBoxContainer').on("click", '.closeLightbox', function(){
		$('#light').fadeOut('fast');
		$('#fade').fadeOut('fast');
	})
});
</script>

<script>
	$('.lighBoxContainer').on("click", '.addProduct', function(){
		var idproduct = $(this).parent().siblings('.id_product').html();
		var cod_product = $(this).parent().siblings('.cod_product').html();
		var name = $(this).parent().siblings('.name').html();
		var unit_cost = $(this).parent().siblings('.unit_cost').html();
		var product_exist = false;
		$('.productIdEntry').each(function(){
			if(idproduct == $(this).val())
			{
				product_exist = true;
			}
		});
		if(product_exist == false)
		{
			$('.productEntryList').append( '' +
				'<tr>' + 
					'<td class="id_product">' + idproduct + '<input type="hidden" class="productIdEntry" name="id_product[]" value="' + idproduct + '"></td>' +
					'<td class="cod_product">' + cod_product + '</td>' +
					'<td class="name">' + name + '</td>' +
					'<td class="unit_cost">' + unit_cost + '</td>' +
					'<td class="quantity"><input type="number" name="quantity[]" class="form-control quantity" value="0"></td>' +
					'<td class="total"></td>' +
					'<td><button class="btn btn-danger removeProductEntry" type="button">X</button></td>' +
				'</tr>');
		}
	})
</script>
<script>
	$('.productEntry').on('click','.removeProductEntry',function(){
		$(this).parents('tr').remove();
	});
</script>
<script>
	$('.productEntry').on('change keyup', '.quantity', function(){
		var unit_price = $(this).parent().siblings('.unit_cost').html();
		$(this).parent().siblings('.total').html(unit_price * $(this).val());
	});
</script>
