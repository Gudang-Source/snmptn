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

        <div class="row">
          <div class="col-lg-12">
            <h1><?php echo $title; ?></h1>
            <ol class="breadcrumb">
              <li><a href="index.html"><i class="icon-dashboard"></i> Dashboard</a></li>
              <li class="active"><i class="icon-file-alt"></i> Profil</li>
            </ol>
          </div>
		  <div class="col-lg-12">
			<div id="profilGuru" class="panel panel-primary">
				<div class="panel-heading">Profil Guru</div>
				<div class="panel-body">
					<form id="formGuru" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>guru/ubah_guru">
						<div class="form-group">
						<label class="col-sm-3 control-label">NIP</label>
						<div class="col-sm-8">
						  <input type="hidden" class="form-control" name="id" value="<?php echo $this->session->userdata('id'); ?>">
						  <input type="text" class="form-control" name="nip" value="<?php echo $this->session->userdata('nip'); ?>" placeholder="Nomor Induk Pegawai">
						</div>
						</div>
						<div class="form-group">
						<label class="col-sm-3 control-label">Nama Guru</label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" name="nama_guru" value="<?php echo $profil->row()->nama; ?>" placeholder="Nama Guru">
						</div>
						</div>
						<div class="form-group">
						<label class="col-sm-3 control-label">Password</label>
						<div class="col-sm-8">
						  <input type="password" class="form-control" name="password" placeholder="Password Baru">
						</div>
						</div>
						<div class="form-group">
						<label class="col-sm-3 control-label"></label>
						<div class="col-sm-8">
						  <input type="submit" class="btn btn-primary" value="Submit">
						</div>
						</div>
						</form>
						<?php echo $this->session->flashdata('status');?>
				</div>
			</div>
		  </div>
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/jquery-1.11.0.js"></script>
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/bootstrap.js"></script>
	<script>
		var base_url = '<?php echo base_url(); ?>';
	</script>
	<script src="<?php echo base_url(); ?>asset/jquery-validation/dist/jquery.validate.min.js"></script>
	<script>
	$('#formGuru').validate({
		rules : {
			nip : {
				required : true
			},
			nama_guru : {
				required : true
			}
		},
		messages : {
			nip : {
				required : "Kolom NIP Tidak Boleh Kosong"
			},
			nama_guru : {
				required : "Kolom Nama Guru Tidak Boleh Kosong"
			}
		}
	});
	</script>
  </body>
</html>