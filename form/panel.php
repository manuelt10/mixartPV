
<script src="flot/jquery.flot.js"></script>
<legend>
	Grafica de Ingresos
</legend>
<div class="row">
	<div class=".col-md-6">
		<div id="graph-wrapper">
		    <div class="graph-info">
		        <!--<a href="javascript:void(0)" class="2013">2013</a>
		        <a href="javascript:void(0)" class="2014">2014</a>-->
		 
		        <a href="#" id="bars"><span></span></a>
		        <a href="#" id="lines" class="active"><span></span></a>
		    </div>
		 
		    <div class="graph-container">
		        <div id="graph-lines"></div>
		        <div id="graph-bars"></div>
		    </div>
		</div>
	</div>
	<div class=".col-md-6">
		<legend>Productos Mas vendidos</legend>
		<legend>Productos Casi agotados</legend>
	</div>
</div>

<?php 
$records = array(
'id_company' => $usr->userdata->id_company
);
$order = array(
'month' => 'desc'
);
$limit = array(0,10);
$graph_data = $db->selectRecord('v_monthly_sell',NULL,$records,$order,$limit);
?>
<script>
$(document).ready(function () {
	var graphData = [{
				        // Visits
				        data: [ 
				        <?php 
				        
				        $content = '';
				        foreach($graph_data->data as $gd)
						{
							$content = $content . "[$gd->month, $gd->total],";
						}
						echo substr($content,0,-1);
				        ?>
				        ],
				        color: '#71c73e'
				    }/*, {
				        // Returning Visits
				        data: [ [6, 500], [7, 600], [8, 550], [9, 600], [10, 800], [11, 900], [12, 800], [13, 850], [14, 830], [15, 1000] ],
				        color: '#77b7c5',
				        points: { radius: 4, fillColor: '#77b7c5' }
				    }*/
				];
				
	$.plot($('#graph-lines'), graphData, {
	    series: {
	        points: {
	            show: true,
	            radius: 5
	        },
	        lines: {
	            show: true
	        },
	        shadowSize: 0
	    },
	    grid: {
	        color: '#646464',
	        borderColor: 'transparent',
	        borderWidth: 20,
	        hoverable: true
	    },
	    xaxis: {
	        tickColor: 'transparent',
	        tickDecimals: 0
	    },
	    yaxis: {
	        tickSize: 1000
	    }
	});
	 
	// Bars
	$.plot($('#graph-bars'), graphData, {
	    series: {
	        bars: {
	            show: true,
	            barWidth: .9,
	            align: 'center'
	        },
	        shadowSize: 0
	    },
	    grid: {
	        color: '#646464',
	        borderColor: 'transparent',
	        borderWidth: 20,
	        hoverable: true
	    },
	    xaxis: {
	        tickColor: 'transparent',
	        tickDecimals: 0
	    },
	    yaxis: {
	        tickSize: 1000
	    }
	});
	
	
});
</script>
<script>
	function showTooltip(x, y, contents) {
	    $('<div id="tooltip">' + contents + '</div>').css({
	        top: y - 16,
	        left: x + 20
	    }).appendTo('body').fadeIn();
	}
	 
	var previousPoint = null;
	 
	$('#graph-lines, #graph-bars').bind('plothover', function (event, pos, item) {
	    if (item) {
	        if (previousPoint != item.dataIndex) {
	            previousPoint = item.dataIndex;
	            $('#tooltip').remove();
	            var x = item.datapoint[0],
	                y = item.datapoint[1];
	                showTooltip(item.pageX, item.pageY, ' Ventas: ' + y + ' Mes: ' + x );
	        }
	    } else {
	        $('#tooltip').remove();
	        previousPoint = null;
	    }
	});
</script>
<script>
	$('#graph-bars').hide();
 
	$('#lines').on('click', function (e) {
	    $('#bars').removeClass('active');
	    $('#graph-bars').fadeOut();
	    $(this).addClass('active');
	    $('#graph-lines').fadeIn();
	    e.preventDefault();
	});
	 
	$('#bars').on('click', function (e) {
	    $('#lines').removeClass('active');
	    $('#graph-lines').fadeOut();
	    $(this).addClass('active');
	    $('#graph-bars').fadeIn().removeClass('hidden');
	    e.preventDefault();
	});
</script>