<!DOCTYPE html>
<html lang="en">
  <head>

    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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
			<div class="row">
			  <div class="col-lg-12">
				<ol class="breadcrumb">
				  <li><a href="<?php echo base_url(); ?>admin"><i class="icon-dashboard"></i> Dashboard</a></li>
				  <?php if (isset($nm_ptn)) echo '<li class="active"><i class="icon-file-alt"></i>'.$nm_ptn.'</li>'; ?>
				</ol>
			  </div>
			</div>
			<div class="row">
				
				<div class="col-lg-12">
					<ul class="nav nav-tabs" id="myTab">
						<li class="active"><a href="#grafik" data-toggle="tab">Grafik Kelulusan</a></li>
						<li><a href="#catatan" data-toggle="tab">Catatan Kelulusan</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active" id="grafik">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<strong>Grafik Kelulusan SNMPTN 
									<span id="id_ptn" style="display:none"><?php if (isset($id_ptn)) echo $id_ptn; ?></span>
									<span id="jml_jur" style="display:none"><?php if (isset($jml_jur)) echo $jml_jur; ?></span>
									<?php if (isset($nm_ptn)) echo ' di '.$nm_ptn; ?>
									</strong>
								</div>
								<div class="panel-body">
									<form method="GET" action="<?php echo base_url();?>admin" style="display:inline;">
									Dari : <select id="thn_dari" name="thn_dari">
										<?php
											for($thn=$tahun_min; $thn<=$tahun_max; $thn++) {
												if (isset($_GET['thn_dari'])) {
													if ($_GET['thn_dari']==$thn) {
														$selected = 'selected="selected"';
													} else {
														$selected = '';
													}
													echo '<option value="'.$thn.'" '.$selected.'>'.$thn.'</option>';
												} else {
													echo '<option value="'.$thn.'">'.$thn.'</option>';
												}
											}
										?>
									</select>
									Sampai : <select id="thn_sampai" name="thn_sampai">
										<?php
											for($thn=$tahun_min; $thn<=$tahun_max; $thn++) {
												if (isset($_GET['thn_sampai'])) {
													if ($_GET['thn_sampai']==$thn) {
														$selected = 'selected="selected"';
													} else {
														$selected = '';
													}
													echo '<option value="'.$thn.'" '.$selected.'>'.$thn.'</option>';
												} else {
													echo '<option value="'.$thn.'">'.$thn.'</option>';
												}
											}
										?>
									</select>
									<input type="submit" class="btn btn-success btn-xs" value="Tampilkan Data" />
									</form>
									&nbsp;&nbsp;<button id="exp_excel" class="btn btn-primary btn-xs">Simpan Excel</button>
									<div id="chartdiv" style="width: 100%; height: 700px;"></div>
									<!--<div id="chartdiv2" style="width: 100%; height: 700px;"></div>-->
								</div>
							</div>
						</div>
						<div class="tab-pane" id="catatan">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<strong>Catatan Kelulusan Per Tahun
									<span id="id_ptn" style="display:none"><?php if (isset($id_ptn)) echo $id_ptn; ?></span>
									<span id="jml_jur" style="display:none"><?php if (isset($jml_jur)) echo $jml_jur; ?></span>
									<?php if (isset($nm_ptn)) echo ' di '.$nm_ptn; ?>
									</strong>
								</div>
								<div class="panel-body">
									<button id="tambahCatatan" class="btn btn-success" style="display:block;">Tambah Catatan</button>
									
									<?php
									echo $this->session->flashdata('status');
									if (count($evaluasi->result_array())<1) {
										echo '<span style="margin-top:15px;">Belum Ada Catatan Evaluasi</span>';
									} else {
									?>
									<table class="table table-striped" style="margin-top:15px;">
										<thead>
											<tr>
												<th>Tahun SNMPTN</th>
												<th>Catatan / Keterangan</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($evaluasi->result() as $ev) {
											?>
											<tr>
												<td><?php echo $ev->tahun; ?></td>
												<td><?php echo $ev->hasil_evaluasi; ?></td>
												<td>
													<span style="cursor:pointer;" class="ubahCatatan" alt="<?php echo $ev->id_evaluasi; ?>"><i class="glyphicon glyphicon-pencil" title="Ubah"></i>&nbsp;</span>
													<span style="cursor:pointer;" class="hapusCatatan" alt="<?php echo $ev->id_evaluasi; ?>"><i class="glyphicon glyphicon-remove" title="Hapus"></i></span>
												</td>
											</tr>
											<?php
											}
											?>
										</tbody>
									</table>
									<?php
									}
									?>
								</div>
							</div>
							<div class="modal fade" id="evaluasiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							  
							</div>
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
	<script src="<?php echo base_url(); ?>asset/amcharts/serial.js" type="text/javascript"></script>
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
			var chartData = AmCharts.loadJSON(base_url+'admin/data_grafik_kelulusan/'+id_ptn+'<?php if (isset($_GET['thn_dari']) && isset($_GET['thn_sampai'])) { echo '?thn_dari='.$_GET['thn_dari'].'&thn_sampai='.$_GET['thn_sampai'];} ?>');

			// this is a temporary line to verify if the data is loaded and parsed correctly
			// please note, that console.debug will work on Safari/Chrome only
			console.debug(chartData);
			
			// PIE CHART
			chart = new AmCharts.AmPieChart();
			chart.dataProvider = chartData;
			chart.titleField = title;
			chart.valueField = "jumlah_lulus";
			chart.urlField = "data_url";
			chart.outlineColor = "#FFFFFF";
			chart.outlineAlpha = 0.8;
			chart.outlineThickness = 2;
			
			
			chart.labelRadius = lrad;
            chart.labelText = label;
			
			// LEGEND
			legend = new AmCharts.AmLegend();
			legend.align = "center";
			legend.markerType = "circle";
			chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]] Orang</b> ([[percents]]%)</span>";
			chart.addLegend(legend);
			
			//chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
			// this makes the chart 3D
			//chart.depth3D = 15;
			//chart.angle = 30;

			// WRITE
			chart.write("chartdiv");
			
			// SERIAL CHART
			chart2 = new AmCharts.AmSerialChart();
			chart2.dataProvider = chartData;
			chart2.categoryField = title;
			chart2.startDuration = 1;

			// AXES
			// category
			var categoryAxis = chart2.categoryAxis;
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
			graph.urlField = "data_url";
			chart2.addGraph(graph);

			// CURSOR
			var chartCursor = new AmCharts.ChartCursor();
			chartCursor.cursorAlpha = 0;
			chartCursor.zoomable = false;
			chartCursor.categoryBalloonEnabled = false;
			chart2.addChartCursor(chartCursor);

			chart2.write("chartdiv2");
		});
	</script>
	<script>
	$(document).ready(function() {
		$('#exp_excel').click(function() {
			window.open(base_url+'test/manual_excel_exp2/'+$('#thn_dari').val()+'/'+$('#thn_sampai').val());
		});
		
		$('#tambahCatatan').click(function() {
			//alert('button clicked');
			$('#evaluasiModal').load(base_url+'admin/form_evaluasi');
			$('#evaluasiModal').modal('toggle');
		});
		
		$('.ubahCatatan').click(function() {
			var id = $(this).attr('alt');
			$('#evaluasiModal').load(base_url+'admin/form_evaluasi/'+id);
			$('#evaluasiModal').modal('toggle');
		});
		
		$('.hapusCatatan').click(function() {
		var id = $(this).attr('alt');
		var c = confirm("Apakah Anda Yakin Ingin Menghapus Data Ini?");
		if (c) {
		$.ajax({
			url:base_url+'guru/hapus_catatan/'+id,
			success:function(msg) {
				var status = '';
				//alert(msg);
				setTimeout(function() {
					window.location.replace(base_url+'admin');
				},3000);
			}
		});
		}
	});
	});
	</script>
  </body>
</html>