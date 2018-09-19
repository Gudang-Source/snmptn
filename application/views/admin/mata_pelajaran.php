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
		#jurusan .active a{
			background:#F5F5F5;
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
              <li class="active"><i class="icon-file-alt"></i> Mata Pelajaran</li>
            </ol>
          </div>
		  <div class="col-lg-12">
			<div class="row">
				<div class="col-lg-8">
					<div class="bs-example">
						<ul id="jurusan" class="nav nav-tabs" style="margin-bottom: 15px;">
							<li <?php if (!isset($jur) || $jur==1) { echo 'class="active"'; } else { echo 'class=""'; } ?>>
								<a data-toggle="tab" alt="1" href="#umum">Umum</a>
							</li>
							<li <?php if (isset($jur) && $jur==2) { echo 'class="active"'; } else { echo 'class=""'; } ?>>
								<a data-toggle="tab" alt="2" href="#ipa">IPA</a>
							</li>
							<li <?php if (isset($jur) && $jur==3) { echo 'class="active"'; } else { echo 'class=""'; } ?>>
								<a data-toggle="tab" alt="3" href="#ips">IPS</a>
							</li>
						</ul>
						<div id="myTabContent" class="tab-content">
							<div class="row">
								<div class="col-lg-6" style="margin-bottom:10px;">
									<button class="btn btn-primary" id="tambahMp"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Tambah Mata Pelajaran</button>
								</div>
							</div>
							<div class="row">
								<div id="dft_mp" class="tab-pane fade active in">
									<!--
									untuk daftar mp
									-->
								</div>
							</div>
							<?php echo $this->session->flashdata('status'); ?>
						</div>

					</div>
				</div>
			</div>
		  </div>
<!-- Mata Pelajaran Modal -->
<div class="modal fade" id="mpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>
<!-- end Mata Pelajaran Modal -->
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/jquery-1.11.0.js"></script>
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/bootstrap.js"></script>
	<script>
		var base_url = '<?php echo base_url(); ?>';
	</script>
<script>
$(document).ready(function() {
	var jur = $('#jurusan .active a').attr('alt');
	$('#dft_mp').load(base_url+'admin/daftar_mp/'+jur);
	//alert(jur);
	$('#tambahMp').click(function() {
		jur = $('#jurusan .active a').attr('alt');
		//alert(jur);
		$('#mpModal').load(base_url+'admin/form_mp/'+jur);
		$('#mpModal').modal('toggle');
	});
	
	$('#jurusan li a').click(function() {
		var jur = $(this).attr('alt');
		$('#dft_mp').load(base_url+'admin/daftar_mp/'+jur);
	});
	
	$('.modal').click(function() {
		jur = $('#jurusan .active a').attr('alt');
		$('#dft_mp').load(base_url+'admin/daftar_mp/'+jur);
	});
});

$('.alert').fadeIn(2000);
	setTimeout(function(){$('.alert').fadeOut(2000);}, 3000);
</script>
  </body>
</html>