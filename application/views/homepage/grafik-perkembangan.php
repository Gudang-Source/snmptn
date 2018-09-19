<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--<link href="jumbotron.css" rel="stylesheet">-->
	
  </head>
<body>
	<?php $this->load->view('homepage/navbar'); ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
		<div class="container">
			<h2>PERKEMBANGAN KELULUSAN SISWA <br />PADA SELEKSI NASIONAL MASUK PERGURUAN TINGGI NEGERI<br />SMA NEGERI XYZ</h2>
		</div>
    </div>

    <div class="container">
		<!-- Example row of columns -->
		<?php if ($this->uri->segment(3)!="") {
		?>			
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title" id="judul">Grafik Perkembangan Kelulusan di <?php 
						echo ucwords(strtolower($nm_ptn)); 
						$thn = $this->uri->segment(4);
						if($thn!='') {
							echo ' Pada Tahun '.$this->uri->segment(4);
						}
					?></h3>
				</div>
				<div class="panel-body">
					<!--<form method="post">
					ID PTN <input id="idptn" type="text" name="id_ptn" />
					<input type="submit" id="tmpGrafik" value="Tampilkan"/>
					</form>
					-->
					<div class="row">
						<span id="id_ptn" style="display:none;"><?php echo $id_ptn; ?></span>
						<span id="thn_lulus" style="display:none;"><?php 
						$thn = $this->uri->segment(4);
						if($thn!='') {
							echo $this->uri->segment(4);
						}
						?></span>
						<div id="chartdiv" style="width: 100%; height: 750px;"></div>
					</div>
					<div class="row">
						<a href="<?php echo base_url().'homepage/perkembangan_kelulusan/'; if($this->uri->segment(4)!='') echo$this->uri->segment(3); ?>"><button style="margin-left:20px;" class="btn btn-primary btn-md">Kembali</button></a>
						<button id="simpan_grafik" class="btn btn-warning btn-md">Download Grafik</button>
					</div>
				</div>
			</div>
		<?php
		} else {
		?>
		<div class="row">
			<div class="col-md-12">
				<h3>Daftar Kelulusan Siswa Pada PTN</h3>
				<!--
				<div class="row">
					<div class="form-group">
						<label class="col-sm-2 control-label">Jumlah Tahun</label>
						<div class="col-sm-1">
						<select class="form-control">
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
						</select>
						</div>
					</div>
				</div>
				-->
				<div class="row" style="margin-top:10px">
					
					<table class="table table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Nama Perguruan Tinggi Negeri</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$no=1;
						
						foreach($lulus->result() as $l) {
						?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><a href="<?php echo base_url().'homepage/perkembangan_kelulusan/'.$l->id_ptn; ?>"><?php echo $l->nama_ptn; ?></a></td>
						</tr>
						<?php
						$no++;
						}
						
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php
		}
		?>
		<hr>

	<?php $this->load->view('homepage/footer');?>
		</div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url(); ?>asset/jquery-1.11.0.js"></script>
	<script src="<?php echo base_url(); ?>asset/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>asset/amcharts/amcharts.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>asset/amcharts/serial.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>asset/amcharts/exporting/amexport.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>asset/amcharts/exporting/rgbcolor.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>asset/amcharts/exporting/canvg.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>asset/amcharts/exporting/filesaver.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>asset/amcharts/exporting/jspdf.js" type="text/javascript"></script>
	<script> var base_url = '<?php echo base_url(); ?>'; </script>
	<script type="text/javascript">
		var chart;
		var id_ptn = $('#id_ptn').html();
		var thn_lulus = $('#thn_lulus').html();
		
		if (thn_lulus=='') {
			var title = 'tahun_pilih';
			var lrad = 0;
			$('#chartdiv').css('height',300);
		} else {
			var title = 'nama_jurusan_ptn';
			var lrad = 90;
		}
	
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
			// Load data
			var chartData = AmCharts.loadJSON(base_url+'homepage/grafik_kelulusan_per_ptn/'+id_ptn+'/'+thn_lulus);
			
			// this is a temporary line to verify if the data is loaded and parsed correctly
			// please note, that console.debug will work on Safari/Chrome only
			console.debug(chartData);
			
			// SERIAL CHART
			
			chart = new AmCharts.AmSerialChart();
			chart.dataProvider = chartData;
			chart.categoryField = title;
			chart.startDuration = 1;

			// AXES
			// category
			var categoryAxis = chart.categoryAxis;
			categoryAxis.labelRotation = lrad;
			categoryAxis.gridPosition = "start";

			// value
			// in case you don't want to change default settings of value axis,
			// you don't need to create it, as one value axis is created automatically.

			// GRAPH
			var graph = new AmCharts.AmGraph();
			graph.valueField = "jml_lulus";
			graph.balloonText = "[[category]]: <b>[[value]] Orang</b>";
			graph.type = "column";
			graph.lineAlpha = 0;
			graph.fillAlphas = 0.8;
			graph.urlField = "data_url";
			chart.addGraph(graph);

			// CURSOR
			var chartCursor = new AmCharts.ChartCursor();
			chartCursor.cursorAlpha = 0;
			chartCursor.zoomable = false;
			chartCursor.categoryBalloonEnabled = false;
			chart.addChartCursor(chartCursor);
			chart.addTitle($('#judul').html(),20);

			chart.creditsPosition = "top-right";

			chart.write("chartdiv");
		});
		
		$(document).ready(function() {
			// export
			$('#simpan_grafik').click(function() {
				var tmp = new AmCharts.AmExport(chart);
				tmp.init();
				tmp.output({
					fileName : $('#judul').html(),
					output: 'save',
					format: 'jpg'
				},function(blob) {
					var image = new Image();
					image.src = blob;
					
					document.body.appendChild(image);
				});
				
			});
		});
		
		
	</script>
</body>
</html>