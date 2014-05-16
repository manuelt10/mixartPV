<form method="get" action="report/expense_report.php" target="_blank">
	<legend>Reporte de Gastos</legend>
	<div class="form-group">
		<label class="black-label">Fecha de Inicio</label>
		<input type="date" name="fecha_inicio" class="form-control" value="<?php echo $date ?>">
		<label class="black-label">Fecha de Final</label>
		<input type="date" name="fecha_final" class="form-control"  value="<?php echo $date ?>"><br>
		<button type="submit" class="btn btn-default">Generar</button>
	</div>
</form>