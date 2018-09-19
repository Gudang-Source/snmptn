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
		<div class="col-sm-5 col-sm-offset-2">
			<div class="panel panel-primary">
			  <div class="panel-heading"><strong>Login Guru</strong></div>
			  <div class="panel-body">
				<form class="form-horizontal" role="form" method="post" action="<?php echo base_url();?>login/do_login">
				  <div class="form-group">
					<label for="inputNip" class="col-sm-2 control-label">NIP</label>
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="inputNip" name="nip" placeholder="Nomer Induk Pegawai">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputPassword" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
					  <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" class="btn btn-default">Sign in</button>
					</div>
				  </div>
				</form>
				<?php 
					$status = $this->session->flashdata('status'); 
					
					if ($status!='') {
						echo '<div class="alert alert-danger">'.$this->session->flashdata('status').'</div>';
					}
				?>
			  </div>
			</div>
		</div>

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/jquery-1.11.0.js"></script>
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/bootstrap.js"></script>
	<script>
		var base_url = '<?php echo base_url(); ?>';
	</script>
  </body>
</html>