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
              <li class="active"><i class="icon-file-alt"></i> Kelas</li>
            </ol>
          </div>
		  <div class="col-lg-12">
			<div class="row">
				<div class="col-lg-6" style="margin-bottom:10px;">
					<button id="tambahKelas" class="btn btn-primary" style="margin-right:20px;"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Tambah Kelas</button>
					<a href="<?php echo base_url(); ?>guru/form_upload"><button id="importData" class="btn btn-success"><i class="glyphicon glyphicon-import"></i>&nbsp;&nbsp;Import Data Siswa</button></a>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8">
					
					<div class="panel panel-primary">
						<div class="panel-heading"><strong>Daftar Kelas</strong></div>
						<div class="panel-body">
							<?php echo $this->session->flashdata('status'); ?>
							<div class="table-responsive">
								<?php
									$k = $daftar_kelas->result_array();
									$daftar_thn_ajaran = array();
									foreach($k as $t) {
										array_push($daftar_thn_ajaran, $t['tahun_ajaran']);
									}
									$thn = array_unique($daftar_thn_ajaran);
									//print_r($thn);
									
									echo '<table class="table table-bordered table-hover table-striped tablesorter"><thead>
										<tr>
											<th class="header">Nama Kelas</th>
											<th class="header">Jumlah Siswa</th>
											<th class="header">Aksi</th>
										</tr>
									</thead><tbody>';
									$thn_ajaran = '';
									//print_r($k);
									for($n=0; $n<count($k); $n++) {
										if(array_key_exists($n, $thn)) {
											echo '<tr><td colspan="3" style="background:#C2C2A3">TA '.$thn[$n].'</td></tr>';
											$thn_ajaran = $thn[$n];
										}
										if ($k[$n]['tahun_ajaran']==$thn_ajaran) {
											echo '<tr>
												<td><a href="'.base_url(),'admin/siswa/'.$k[$n]['id_kelas'].'">'.$k[$n]['nama_kelas'].'</a></td>
												<td>'.$k[$n]['jml_siswa'].'</td>
												<td>
													<span style="cursor:pointer;" class="ubahKelas" alt="'.$k[$n]['id_kelas'].'"><i class="glyphicon glyphicon-pencil" title="Ubah"></i>&nbsp;</span>
													<span style="cursor:pointer;" class="hapusKelas" alt="'.$k[$n]['id_kelas'].'"><i class="glyphicon glyphicon-remove" title="Hapus"></i></span>
												</td>
											</tr>';
										}
									}
									echo '</tbody></table>';
								?>
								<!--
								<table class="table table-bordered table-hover table-striped tablesorter">
									<thead>
										<tr>
											<th class="header">Nama Kelas</th>
											<th class="header">Jumlah Siswa</th>
											<th class="header">Tahun Ajaran</th>
											<th class="header">Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach($daftar_kelas->result() as $k) {
										?>
										<tr>
											<td><a href="<?php echo base_url(); ?>admin/siswa/<?php echo $k->id_kelas; ?>"><?php echo $k->nama_kelas; ?></a></td>
											<td><?php echo $k->jml_siswa; ?></td>
											<td><?php echo $k->tahun_ajaran; ?></td>
											<td>
												<span style="cursor:pointer;" class="ubahKelas" alt="<?php echo $k->id_kelas; ?>"><i class="glyphicon glyphicon-pencil" title="Ubah"></i>&nbsp;</span>
												<span style="cursor:pointer;" class="hapusKelas" alt="<?php echo $k->id_kelas; ?>"><i class="glyphicon glyphicon-remove" title="Hapus"></i></span>
											</td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								-->
							</div>
						</div>
					</div>
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
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/bootstrap.js"></script>
	<script>
		var base_url = '<?php echo base_url(); ?>';
	</script>
<script>
$(document).ready(function() {
	$('#tambahKelas').click(function() {
		$('#kelasModal').load(base_url+'admin/form_kelas');
		$('#kelasModal').modal('toggle');
	});
	
	$('.ubahKelas').click(function() {
		var kelas = $(this).attr('alt')
		$('#kelasModal').load(base_url+'admin/form_kelas/'+kelas);
		$('#kelasModal').modal('toggle');
	});
	
	$('.hapusKelas').click(function() {
		var id_kelas = $(this).attr('alt');
		var c = confirm("Apakah Anda Yakin Ingin Menghapus Data Ini?");
		if (c) {
		$.ajax({
			url:base_url+'guru/hapus_kelas/'+id_kelas,
			success:function(msg) {
				var status = '';
				//alert(msg);
				setTimeout(function() {
					window.location.replace(base_url+'admin/kelas');
				},3000);
			}
		});
		}
	});
	
	$('.alert').fadeIn(2000);
	setTimeout(function(){$('.alert').fadeOut(2000);}, 3000);
});
</script>
  </body>
</html>