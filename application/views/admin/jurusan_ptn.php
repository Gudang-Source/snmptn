<!DOCTYPE html>
<html lang="en">
  <head>

    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="<?php echo base_url(); ?>asset/sb-admin/css/sb-admin.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/sb-admin/font-awesome/css/font-awesome.min.css">
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

    <div id="wrapper">

      <!-- Sidebar -->
      <?php $this->load->view('admin/navbar'); ?>

      <div id="page-wrapper">

        <div class="row">
          <div class="col-lg-12">
            <h1><?php echo $title; ?></h1>
            <ol class="breadcrumb">
              <li><a href="index.html"><i class="icon-dashboard"></i> Dashboard</a></li>
              <li class="active"><i class="icon-file-alt"></i>Jurusan PTN</li>
            </ol>
          </div>
		  <div class="col-lg-12">
			<div class="row">
				<div class="col-lg-6" style="margin-bottom:10px;">
					<button id="tambahJur" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Tambah Jurusan</button>
				</div>
			</div>
			<div class="row">
				<div id="daftarJur" class="col-lg-10">
					<!--
					untuk daftar jurusan
					-->
				</div>
			</div>
		  </div>
<!-- Jurusan PTN Modal -->
<div class="modal fade" id="jurModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>
<!-- end Jurusan PTN Modal -->
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/jquery-1.11.0.js"></script>
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/bootstrap.js"></script>
	<script src="<?php echo base_url(); ?>asset/typeahead.js"></script>
	<script src="<?php echo base_url(); ?>asset/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
	<script>
		var base_url = '<?php echo base_url(); ?>';
	</script>
<script>
$(document).ready(function() {
	$('#daftarJur').load(base_url+'admin/daftar_jurusan_ptn');
	
	$('#tambahJur').click(function() {
		$('#jurModal').load(base_url+'admin/form_jur_ptn');
		$('#jurModal').modal('toggle');
	});
});
</script>
  </body>
</html>