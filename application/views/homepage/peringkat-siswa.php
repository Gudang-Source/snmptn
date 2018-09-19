<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--<link href="jumbotron.css" rel="stylesheet">-->
	<link href="<?php echo base_url(); ?>asset/css/mycss.css" rel="stylesheet">>
	
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
			<div class="col-md-12">
				<h3>Daftar Peringkat Siswa</h3>
				<div class="row">
					<form id="form_peringkat" class="form-horizontal" method="post" action="<?php echo base_url(); ?>homepage/peringkat">
					<div class="form-group">
						<label class="col-sm-2 control-label">Nama PTN</label>
						<div class="col-sm-5">
						<input type="text" id="iptn" class="form-control" name="ptn" placeholder="Nama PTN" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Nama Jurusan/Prodi</label>
						<div class="col-sm-5">
						<input type="text" id="ijur" class="form-control" name="jurusan" placeholder="Nama Jurusan/Prodi">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Tampilkan Peringkat</button>
						</div>
					</div>
					</form>
				</div>
				<div class="row" style="margin-top:10px">
					<?php
					if(isset($status)) {
						if($status!='ada') {
							echo 'Maaf, Jurusan/Prodi yang dimasukkan belum terdaftar pada PTN ini';
						} else {
							if ($peringkat->num_rows()<1) {
								echo 'Maaf, belum ada siswa yang memilih PTN dan Jurusan yang dicari';
							} else {
					?>
					<table class="table table-striped">
						<thead>
						<tr>
							<th style="vertical-align:middle" rowspan="2">No</th>
							<th style="vertical-align:middle" rowspan="2">Nama Siswa</th>
							<th style="text-align:center">Jumlah Nilai Siswa Yang diterima</th>
							<th style="text-align:center; vertical-align:middle" rowspan="2">Peringkat Siswa</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$no=1;
						foreach($peringkat->result() as $p) {
						?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $p->nama; ?></td>
							<td style="text-align:center"><?php echo $p->jml_nilai_mp; ?></td>
							<td style="text-align:center"><?php echo $p->peringkat; ?></td>
						</tr>
						<?php 
						$no++;
						}
						?>
						</tbody>
					</table>
					<?php
							}
						}
					}
					?>
					</div>
				</div>
			</div>
			<hr>

	<?php $this->load->view('homepage/footer'); ?>
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
	$('#iptn').typeahead({
		name:'nama_ptn',
		remote: base_url+'ptn/cari_ptn/%QUERY',
		displayKey:'nama_ptn',
		limit:4
	});
	$('#ijur').typeahead({
		name:'nama_jur',
		remote: {
			url: base_url+'ptn/cari_jurusan?q=%QUERY',
			replace: function () {
				var q = base_url+'ptn/cari_jurusan?q='+$('#ijur').val();
				if ($('#iptn').val()) {
					q += "&ptn=" + encodeURIComponent($('#iptn').val());
				}
				return q;
			}
		},
		displayKey:'nama_jur',
		limit:4
	});
	$('.tt-query').css('background-color','#fff');
	</script>
	<script src="<?php echo base_url(); ?>asset/jquery-validation/dist/jquery.validate.min.js"></script>
	<script>
	$('#form_peringkat').validate({
		rules : {
			ptn : {
				required : true
			},
			jurusan : {
				required : true
			}
		},
		messages : {
			ptn : {
				required : "Kolom PTN Tidak Boleh Kosong",
			},
			jurusan : {
				required : "Kolom Jurusan Tidak Boleh Kosong"
			}
		}
	});
	</script>
</body>
</html>