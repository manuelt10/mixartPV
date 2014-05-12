<form class="form-group" method="post" action="function/ft/create_fact.php">
	<input type="hidden" name="id_company" value="<?php echo $usr->userdata->id_company ?>">
	<fieldset>
		<legend>Datos del Cliente</legend>
		<label class="black-label">Codigo de Cliente</label><input type="text" name="cod_cliente" required class="form-control client_list id_client" ><label>Al dar doble click puedes ver la lista de clientes</label><br>
		<textarea class="form-control client_name" readonly></textarea>
	</fieldset>
	<fieldset>
		<div>
			<button type="button" class="btn btn-default showLightbox">Agregar Productos</button>
			<button type="submit" class="btn btn-success">Finalizar</button>
		</div>
		<legend>Listado de Productos</legend>
		<table class="table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Codigo</th>
					<th>Nombre</th>
					<th>Precio</th>
					<th>Cantidad</th>
					<th>Total($)</th>
				</tr>
			</thead>
			<tbody class="productEntryList">
			</tbody>
		</table>
	</fieldset>
	<hr>
	<fieldset class="form-inline">
		<table>
			<tbody>
				<tr>
					<td>Sub-total($): </td>
					<td><input type="text" class="form-control subtotal" readonly value="0" name="subtotal"></td>
				</tr>
				<tr>
					<td>Itbis($): </td>
					<td><input type="text" class="form-control itbis" readonly value="0" name="itbis"></td>
				</tr>
				<tr>
					<td>Total($): </td>
					<td><input type="text" class="form-control totalgeneral" readonly value="0" name="total"></td>
				</tr>
			</tbody>	
		</table>
	</fieldset>
</form>

<div class="lighBoxContainer">
	<div id="light" class="white_content">	
	</div>
	<div id="fade" class="black_overlay">
	</div>
</div>
<script>

//Product Lightbox
$(function() {
	$('.showLightbox').click(function(){
		$.ajax({
			type : "POST",
			url : "function/ft/show_product_list.php",
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
	$('.lighBoxContainer').on("click", '.addProduct', function(){
		var idproduct = $(this).parent().siblings('.id_product').html();
		var cod_product = $(this).parent().siblings('.cod_product').html();
		var name = $(this).parent().siblings('.name').html();
		var unit_cost = $(this).parent().siblings('.unit_cost').html();
		var existence = $(this).parent().siblings('.existence').html();
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
					'<td class="quantity"><input type="number" name="quantity[]" min="0" max="' + existence + '" class="form-control quantity" value="0"></td>' +
					'<td class="total">0</td>' +
					'<td><button class="btn btn-danger removeProductEntry" type="button">X</button></td>' +
				'</tr>');
		}
	})
</script>
<script>
	$('.form-group').on('click','.removeProductEntry',function(){
		$(this).parents('tr').remove();
	});
</script>
<script>
	$('.form-group').on('change keyup', '.quantity', function(){
		var total_general = 0;
		var itbis = 0;
		var subtotal = 0;
		var unit_price = $(this).parent().siblings('.unit_cost').html();
		$(this).parent().siblings('.total').html(unit_price * $(this).val());
		$('.total').each(function(k, v)
		{
			subtotal = subtotal + parseFloat($(this).html());
			
		});
		itbis = (parseFloat(subtotal) * 0.18).toFixed(2);
		total_general = parseFloat(subtotal) + parseFloat(itbis);
		$('.subtotal').val(subtotal);
		$('.itbis').val(itbis);
		$('.totalgeneral').val(total_general);
	});
</script>


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