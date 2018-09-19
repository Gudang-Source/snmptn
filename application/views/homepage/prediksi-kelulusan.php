<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--<link href="jumbotron.css" rel="stylesheet">-->
	<link href="<?php echo base_url(); ?>asset/css/mycss.css" rel="stylesheet">
	
	<link href="<?php echo base_url(); ?>asset/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
	<style>
	.twitter-typeahead{
width:100%;
}

.twitter-typeahead .tt-query,
.twitter-typeahead .tt-hint {
  margin-bottom: 0;
}
.tt-dropdown-menu {
  min-width: 160px;
  margin-top: 2px;
  padding: 5px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0,0,0,.2);
  *border-right-width: 2px;
  *border-bottom-width: 2px;
  -webkit-border-radius: 6px;
     -moz-border-radius: 6px;
          border-radius: 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
  -webkit-background-clip: padding-box;
     -moz-background-clip: padding;
          background-clip: padding-box;
  width:100%;        
}

.tt-suggestion {
  display: block;
  padding: 3px 20px;
}

.tt-suggestion.tt-is-under-cursor {
  color: #fff;
  background-color: #0081c2;
  background-image: -moz-linear-gradient(top, #0088cc, #0077b3);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0077b3));
  background-image: -webkit-linear-gradient(top, #0088cc, #0077b3);
  background-image: -o-linear-gradient(top, #0088cc, #0077b3);
  background-image: linear-gradient(to bottom, #0088cc, #0077b3);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc', endColorstr='#ff0077b3', GradientType=0)
}

.tt-suggestion.tt-is-under-cursor a {
  color: #fff;
}

.tt-suggestion p {
  margin: 0;
}
	</style>
  </head>
<body>
	<?php $this->load->view('homepage/navbar'); ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
		<div class="container">
			<h2>PREDIKSI KELULUSAN SISWA <br />PADA SELEKSI NASIONAL MASUK PERGURUAN TINGGI NEGERI<br />SMA NEGERI XYZ</h2>
		</div>
    </div>

    <div class="container">
		<!-- Example row of columns -->
		<div class="row">
			<div class="col-md-12" id="hasil_prediksi">
				<h3>Prediksi Kelulusan Siswa</h3>
				<div class="row">
					<form id="form_prediksi" class="form-horizontal" method="post" action="<?php echo base_url(); ?>homepage/prediksi">
					<div class="form-group">
						<label class="col-sm-2 control-label">Prediksi Berdasarkan</label>
						<div class="col-sm-5">
						<select class="form-control" name="acuan">
							<option value="semua" <?php if($acuan=='semua') echo 'selected="selected"'; ?>>Semua Nilai Rapot</option>
							<option value="un" <?php if($acuan=='un') echo 'selected="selected"'; ?>>Hanya Nilai Mata Pelajaran UN</option>
						</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Jumlah Nilai</label>
						<div class="col-sm-5">
						<input type="number" id="inilai" class="form-control" name="jml_nilai" placeholder="Jumlah Nilai" value="<?php if (isset($jml_nilai)) echo $jml_nilai; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">PTN</label>
						<div class="col-sm-5">
						<input type="text" id="iptn" class="form-control" name="ptn" placeholder="PTN" value="<?php if (isset($ptn)) echo $ptn; ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Jurusan</label>
						<div class="col-sm-5">
						<input type="text" id="ijur" class="form-control" name="jurusan" placeholder="Jurusan" value="<?php if (isset($jurusan)) echo $jurusan; ?>">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default" onclick="return cek_pilihan()">Tampilkan Prediksi</button>
						</div>
					</div>
					</form>
				</div>
				<div class="row" style="margin-top:10px">
					<?php
					if ($prediksi->num_rows()<1) {
						if(!isset($pencarian) || $pencarian=='nilai' || $pencarian=='nilai jurusan') {
							echo '<span style="color:red">Maaf, tidak ada PTN yang sesuai dengan jumlah nilai atau jurusan yang dicari</span>';
						} else if ($pencarian=='nilai ptn') {
							echo '<span style="color:red">Maaf, tidak ada Jurusan yang sesuai dengan jumlah nilai atau PTN yang dicari</span>';
						} else if ($pencarian=='nilai ptn jurusan') {
							echo '<span style="color:red">Maaf, Jumlah nilai anda di bawah nilai minimum untuk PTN dan Jurusan yang anda cari</span>';
						}
						
					} else {
					?>
					<table id="tabel_prediksi" class="table table-striped">
						<thead>
						<tr>
							<th style="vertical-align:middle" rowspan="2">No</th>
							<th style="vertical-align:middle" rowspan="2">
							<?php
							if(!isset($pencarian) || $pencarian=='nilai' || $pencarian=='nilai jurusan') {
								echo 'Nama Perguruan Tinggi Negeri';
							} else if ($pencarian=='nilai ptn' || $pencarian=='nilai ptn jurusan') {
								echo 'Nama Jurusan';
							}
							?>
							</th>
							<th style="text-align:center" colspan="2">Jumlah Nilai Siswa Yang diterima</th>
							<th style="text-align:center; vertical-align:middle" rowspan="2">Jumlah Siswa Yang Diterima</th>
						</tr>
						<tr>
							<th style="text-align:center">Nilai Minimal</th>
							<th style="text-align:center">Nilai Maksimal</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$no=1;
						$jml_total = 0;
						foreach($prediksi->result() as $p) {
						?>
						<tr>
							<td><?php echo $no; ?></td>
							<td>
							<?php 
							
							if (isset($pencarian) && $pencarian=='nilai') {
								echo '<a href="'.base_url().'homepage/prediksi/'.$p->id_ptn.'/'.$jml_nilai.'/'.$acuan.'">'.$p->nama_ptn.'</a>';
							} else if (isset($pencarian) && ($pencarian=='nilai ptn' || $pencarian=='nilai ptn jurusan')) {
								echo $p->nama_jurusan_ptn;
							} else {
								echo $p->nama_ptn;
							} 
							?>
							</td>
							<td style="text-align:center"><?php echo $p->minim; ?></td>
							<td style="text-align:center"><?php echo $p->maxim; ?></td>
							<td style="text-align:center"><?php echo $p->jml_terima; $jml_total += $p->jml_terima; ?> orang</td>
						</tr>
						<?php
						$no++;
						}
						?>
						<tr>
							<td colspan="4" style="text-align:center"><strong>Jumlah Total</strong></td>
							<td style="text-align:center"><?php echo $jml_total; ?> Orang</td>
						</tr>
						</tbody>
					</table>
					<?php
					}
					//echo $this->db->last_query();
					?>
					</div>
				</div>
				<button id="simpan_gambar" class="btn btn-primary" style="margin-top:20px;" onclick="simpan_prediksi();">Simpan Prediksi Sebagai Gambar</button>
				<div id="imagerender" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				  <div class="modal-dialog modal-lg">
					<div class="modal-content" id="gambar">
					</div>
				  </div>
				</div>
			</div>
			<hr>

	<?php $this->load->view('homepage/footer'); //echo $acuan; //echo $this->db->last_query(); ?>
		</div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url(); ?>asset/jquery-1.11.0.js"></script>
	<script src="<?php echo base_url(); ?>asset/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>asset/typeahead.js"></script>
	<script src="<?php echo base_url(); ?>asset/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
	<script>
		var base_url = '<?php echo base_url(); ?>';
	</script>
	<script>
	$('#ijur').typeahead({
		name:'nama_jurusan_ptn',
		remote: base_url+'ptn/cari_jurusan?q=%QUERY',
		displayKey:'nama_jurusan_ptn',
		limit:6
	});
	$('#iptn').typeahead({
		name:'nama_ptn',
		remote: base_url+'ptn/cari_ptn/%QUERY',
		displayKey:'nama_ptn',
		limit:6
	});
	$('.tt-query').css('background-color','#fff');
	/*
	function cek_pilihan() {
		var jur = $('#ijur').val();
		var ptn = $('#iptn').val();
		
		if (jur!='' && ptn!='') {
			alert('Silahkan Masukkan Salah Satu Saja, Antara Jurusan Atau PTN');
			return false;
		} else {
			return true;
		}
	}
	*/
	</script>
	<script src="<?php echo base_url(); ?>asset/jquery-validation/dist/jquery.validate.min.js"></script>
	<script>
	$('#form_prediksi').validate({
		rules : {
			jml_nilai : {
				required : true,
				number : true
			}
		},
		messages : {
			jml_nilai : {
				required : "Kolom Jumlah Nilai Tidak Boleh Kosong",
				number : "Kolom Jumlah Nilai Hanya Boleh Di isi Angka"
			}
		}
	});
	</script>
	<!-- Save Table As Images -->
	<script src="<?php echo base_url(); ?>asset/html2canvas/build/html2canvas.min.js"></script>
	<script src="<?php echo base_url(); ?>asset/canvas2image/canvas2image.js"></script>
	<script src="<?php echo base_url(); ?>asset/canvas2image/base64.js"></script>
	<script>
		function simpan_prediksi() {
			html2canvas(document.getElementById('tabel_prediksi'), {
				onrendered: function(canvas) {
					//$('#gambar').html(canvas);
					//$('#imagerender').modal('toggle');
					
					//var dataURL = canvas.toDataURL('image/png');
					//document.getElementById('simpan_gambar').href=dataURL;
					
					dataURL = canvas.toDataURL('image/png');
					window.open(dataURL);
				}
			});
		}
	</script>
</body>
</html>