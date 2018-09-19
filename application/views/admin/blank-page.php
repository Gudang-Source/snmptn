<!DOCTYPE html>
<html lang="en">
  <head>

    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>asset/sb-admin/css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="<?php echo base_url(); ?>asset/sb-admin/css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/sb-admin/font-awesome/css/font-awesome.min.css">
  </head>

  <body>

    <div id="wrapper">

      <!-- Sidebar -->
      <?php $this->load->view('admin/navbar'); ?>

      <div id="page-wrapper">
		<?php 
		if (isset($ptn)) {
			$nm_ptn = $ptn->row()->nama_ptn;
			$id_ptn = $ptn->row()->id_ptn;
		}
		?>
        <div class="row">
          <div class="col-lg-12">
            <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin"><i class="icon-dashboard"></i> Dashboard</a></li>
              <?php if (isset($nm_ptn)) echo '<li class="active"><i class="icon-file-alt"></i>'.$nm_ptn.'</li>'; ?>
            </ol>
          </div>
		  <div class="row">
				<div class="col-lg-12">
					
					<div class="panel panel-primary">
						<div class="panel-heading">
							<strong>Grafik Kelulusan SNMPTN 
							<span id="id_ptn" style="display:none"><?php if (isset($id_ptn)) echo $id_ptn; ?></span>
							<span id="jml_jur" style="display:none"><?php if (isset($jml_jur)) echo $jml_jur; ?></span>
							<?php if (isset($nm_ptn)) echo ' di '.$nm_ptn; ?>
							</strong>
						</div>
						<div class="panel-body">
							<!--<div id="chartdiv1" style="width: 100%; height: 700px;"></div>-->
							<div id="chartdiv2" style="width: 100%; height: 700px;"></div>
						</div>
						
					</div>
				</div>
			</div>
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/bootstrap.js"></script>
	<script src="<?php echo base_url(); ?>asset/amcharts/amcharts.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>asset/amcharts/pie.js" type="text/javascript"></script>
	<script> var base_url = '<?php echo base_url(); ?>'; </script>
	<script type="text/javascript">
		var id_ptn = $('#id_ptn').html();
		var jml_jur = $('#jml_jur').html();
		
		if (id_ptn=='') {
			var title = 'nama_ptn';
		} else {
			var title = 'nama_jurusan_ptn';
		}
		
		if (jml_jur=='') {
			var lrad = 30;
			var label = "[[title]] : [[value]] Orang";
		} else {
			var lrad = -30;
			var label = "[[value]] Orang";
		}

		var chart;
		var legend;
		
		AmCharts.loadJSON = function(url) {
			// create the request
			if (window.XMLHttpRequest) {
				// IE7+, Firefox, Chrome, Opera, Safari
				var request = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				var request = new ActiveXObject('Microsoft.XMLHTTP');
			}

			// load it
			// the last "false" parameter ensures that our code will wait before the
			// data is loaded
			request.open('GET', url, false);
			request.send();

			// parse adn return the output
			return eval(request.responseText);
		};
		AmCharts.ready(function () {
			// load the data
			var chartData = AmCharts.loadJSON(base_url+'admin/data_grafik_kelulusan/'+id_ptn);

			// this is a temporary line to verify if the data is loaded and parsed correctly
			// please note, that console.debug will work on Safari/Chrome only
			console.debug(chartData);
			
			// PIE CHART
			chart1 = new AmCharts.AmPieChart();
			chart1.dataProvider = chartData;
			chart1.titleField = title;
			chart1.valueField = "jumlah_lulus";
			chart1.urlField = "data_url";
			chart1.outlineColor = "#FFFFFF";
			chart1.outlineAlpha = 0.8;
			chart1.outlineThickness = 2;
			
			
			chart1.labelRadius = lrad;
            chart1.labelText = label;
			
			// LEGEND
			legend = new AmCharts.AmLegend();
			legend.align = "center";
			legend.markerType = "circle";
			chart1.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]] Orang</b> ([[percents]]%)</span>";
			chart1.addLegend(legend);
			
			//chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
			// this makes the chart 3D
			//chart.depth3D = 15;
			//chart.angle = 30;

			// WRITE
			chart1.write("chartdiv1");
			
			chart2 = new AmCharts.AmSerialChart();
			chart2.dataProvider = chartData;
			chart2.categoryField = title;
			chart2.startDuration = 1;

			// AXES
			// category
			var categoryAxis = chart.categoryAxis;
			categoryAxis.labelRotation = 90;
			categoryAxis.gridPosition = "start";

			// value
			// in case you don't want to change default settings of value axis,
			// you don't need to create it, as one value axis is created automatically.

			// GRAPH
			var graph = new AmCharts.AmGraph();
			graph.valueField = "jumlah_lulus";
			graph.balloonText = "[[category]]: <b>[[value]]</b>";
			graph.type = "column";
			graph.lineAlpha = 0;
			graph.fillAlphas = 0.8;
			chart.addGraph(graph);

			// CURSOR
			var chartCursor = new AmCharts.ChartCursor();
			chartCursor.cursorAlpha = 0;
			chartCursor.zoomable = false;
			chartCursor.categoryBalloonEnabled = false;
			chart.addChartCursor(chartCursor);

			chart2.write("chartdiv2");
		});
	</script>
  </body>
</html>