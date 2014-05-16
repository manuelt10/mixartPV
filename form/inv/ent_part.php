<form class="form-group" style="width: 400px" method="post" action="function/inv/create_expense.php">
	<legend>Registro de Gasto</legend>
	<input type="hidden" name="id_company" value="<?php echo $usr->userdata->id_company ?>">
	<label class="black-label">Concepto</label>
	<input type="text" class="form-control" name="concept" placeholder="Concepto del Gasto" required>
	<label class="black-label">Gasto</label>
	<input type="text" name="total" class="onlyNumber form-control" placeholder="0.00" required><br>
	<button type="submit" class="btn btn-default">Enviar</button>
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