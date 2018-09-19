<!DOCTYPE html>
<html lang="en">
  <head>

    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="<?php echo base_url(); ?>asset/sb-admin/css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/sb-admin/font-awesome/css/font-awesome.min.css">
	<style>
	#progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
	#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
	#percent { position:absolute; display:inline-block; top:3px; left:48%; }
	</style>
  </head>

  <body>

    <div id="wrapper">

      <!-- Sidebar -->
      <?php $this->load->view('admin/navbar'); ?>

      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1><?php echo $title; ?></h1>
            <ol class="breadcrumb">
              <li><a href="index.html"><i class="icon-dashboard"></i> Dashboard</a></li>
              <li class="active"><i class="icon-file-alt"></i> Kelas</li>
            </ol>
          </div>
		  <div class="col-lg-5">
			<div class="panel panel-primary">
			  <div class="panel-heading"><strong>Import Nilai</strong></div>
			  <div class="panel-body">
				<form id="formImport" method="post" action="<?php echo base_url(); ?>guru/ac_upload" enctype="multipart/form-data">
					<div class="form-group">
						<label for="inputKelas">Kelas</label>
						<input type="text" class="form-control" id="ikelas" name="kelas" placeholder="Kelas" />
					</div>
					<div class="form-group">
						<label for="inputTahunAjaran">Tahun Ajaran</label>
						<input type="text" class="form-control" id="ithn_ajaran" name="tahun_ajaran" placeholder="Tahun Ajaran" />
					</div>
					<div class="form-group">
						<label for="exampleInputFile">File input</label>
						<input type="file" id="exampleInputFile" name="files" />
						<p class="help-block">Silahkan Pilih File Excel.</p>
					</div>
					
					<button id="btnSimpan" class="btn btn-primary"><i class="glyphicon glyphicon-import"></i>&nbsp;&nbsp;<span id="tulisan">Simpan</span></button>
					<a href="<?php echo base_url(); ?>admin/kelas"><button type="button" class="btn btn-warning btn-md"><i class="glyphicon glyphicon-remove-circle"></i>&nbsp;&nbsp;Batal</button></a>
					</form>
					<div id="progress" style="margin-top:10px; display:none;">Sedang Import Data Siswa...<img src="<?php echo base_url(); ?>asset/images/loading-icon.gif" style="width:20px; height:20px;" /></div>
				<?php 
					$status = $this->session->flashdata('status'); 
					
					if ($status!='') {
						echo '<div class="alert alert-danger">'.$this->session->flashdata('status').'</div>';
					}
				?>
			  </div>
			</div>
		  </div>
<!-- Guru Modal -->
<div class="modal fade" id="kelasModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>
<!-- end Guru Modal -->
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/jquery-1.11.0.js"></script>
	<script src="<?php echo base_url(); ?>asset/jquery.form.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/bootstrap.js"></script>
	<script>
		var base_url = '<?php echo base_url(); ?>';
	</script>
	<script src="<?php echo base_url(); ?>asset/jquery-validation/dist/jquery.validate.min.js"></script>
<script>

$('#formImport').validate({
	rules : {
		kelas : {
			required : true
		},
		tahun_ajaran : {
			required : true,
			number : true
		},
		files : {
			required : true
		}
	},
	messages : {
		kelas : {
			required : "Kolom Kelas Tidak Boleh Kosong"
		},
		tahun_ajaran : {
			required : "Kolom Tahun Ajaran Tidak Boleh Kosong",
			number : "Kolom Tahun Ajaran Harus Angka"
		},
		files : {
			required : "Kolom File Input Tidak Boleh Kosong",
		}
	},
	submitHandler: function(form) {
		
		$(form).ajaxSubmit({
			beforeSend: function()
			{
				$('#btnSimpan').attr('disabled','disabled');
				$('#progress').show();
			},
			success : function(msg) {
				$('#btnSimpan').removeAttr('disabled');
			},
			complete: function(response)
			{
				$('#progress').html('Import Data Siswa Selesai');
				alert('Import Data dan Nilai Siswa Telah Selesai');
			}
		});
	}
});

</script>
<script>
$(document).ready(function() {
});
</script>
  </body>
</html>