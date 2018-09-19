<!DOCTYPE html>
<html>
<head>
	<!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="<?php echo base_url(); ?>asset/sb-admin/css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/sb-admin/font-awesome/css/font-awesome.min.css">
</head>
<body>
	<div class="panel panel-primary">
	  <div class="panel-heading"><strong>Import Nilai</strong></div>
	  <div class="panel-body">
		<form method="post" action="<?php echo base_url(); ?>test/ac_upload" enctype="multipart/form-data">
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
			
			<button type="submit" class="btn btn-default">Submit</button>
			</form>
		<?php 
			$status = $this->session->flashdata('status'); 
			
			if ($status!='') {
				echo '<div class="alert alert-danger">'.$this->session->flashdata('status').'</div>';
			}
		?>
	  </div>
	</div>
</form>
</body>
</html>