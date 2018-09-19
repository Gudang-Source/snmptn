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
              <li class="active"><i class="icon-file-alt"></i> Blank Page</li>
            </ol>
          </div>
		  <div class="col-lg-12">
			<div class="row">
				<div class="col-lg-6" style="margin-bottom:10px;">
					<button class="btn btn-primary" id="tambahGuru">Tambah Guru</button>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					
					<div id="daftarGuru" class="panel panel-primary">
						<div class="panel-heading">Daftar Guru</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped tablesorter">
									<thead>
										<tr>
											<th class="header">No</th>
											<th class="header">NIP Guru</th>
											<th class="header">Nama</th>
											<th class="header">Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$no = 1;
										foreach($daftar_guru->result() as $g) {?>
										<tr>
											<td id="no"><?php echo $no; ?></td>
											<td id="NIP"><?php echo $g->nip; ?></td>
											<td id="tahun_masuk"><?php echo $g->nama; ?></td>
											<td>
												<span style="cursor:pointer;" class="daftarKelas" alt="<?php echo $g->id; ?>"><i class="glyphicon glyphicon-th-list" title="Daftar Kelas"></i>&nbsp;</span>
												<span style="cursor:pointer;" class="ubahGuru" alt="<?php echo $g->id; ?>"><i class="glyphicon glyphicon-pencil" title="Ubah"></i>&nbsp;</span>
												<span style="cursor:pointer;" class="hapusGuru" alt="<?php echo $g->id; ?>"><i class="glyphicon glyphicon-remove" title="Hapus"></i>&nbsp;</span>
											</td>
										</tr>
										<?php $no++; } ?>
									</tbody>
								</table>
							</div>
							<div id="status"></div>
						</div>
					</div>
				</div>
			</div>
		  </div>
<!-- Guru Modal -->
<div class="modal fade" id="guruModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>
<!-- end Guru Modal -->
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
	$('#tambahGuru').click(function() {
		$('#guruModal').load(base_url+'admin/form_guru');
		$('#guruModal').modal('toggle');
	});
	
	$('.ubahGuru').click(function() {
		var id_guru = $(this).attr('alt');
		$('#guruModal').load(base_url+'admin/form_guru/'+id_guru);
		$('#guruModal').modal('toggle');
	});
	
	$('.hapusGuru').click(function() {
		var id_guru = $(this).attr('alt');
		var c = confirm("Apakah Anda Yakin Ingin Menghapus Data Ini?");
		if (c) {
		$.ajax({
			url:base_url+'guru/hapus_guru/'+id_guru,
			success:function(msg) {
				var status = '';
				if(msg.indexOf('Gagal')<0) {
					status = 'success';
				} else {
					status = 'danger';
				}
				
				$('#daftarGuru .panel-body #status').html('<div class="alert alert-'+status+'">'+msg+'</div>');
				$('#daftarGuru .panel-body #status').fadeOut(3000);
				setTimeout(function() {
					window.location.replace(base_url+'admin/guru');
				},4000);
			}
		});
		}
	});
	
	$('.daftarKelas').click(function() {
		var id_guru = $(this).attr('alt');
		$('#guruModal').load(base_url+'admin/daftar_kelas/'+id_guru);
		$('#guruModal').modal('toggle');
	});
});
</script>
  </body>
</html>