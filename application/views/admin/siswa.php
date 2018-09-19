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
              <li><a href="<?php echo base_url(); ?>admin/kelas"><i class="icon-file-alt"></i> Kelas</a></li>
			  <li class="active"><i class="icon-file-alt"></i> Siswa</li>
            </ol>
          </div>
		  <div class="col-lg-12">
			<div class="row">
				<div class="col-lg-6" style="margin-bottom:10px;">
					<button class="btn btn-primary" id="tambahSiswa" alt="<?php echo $this->uri->segment(3); ?>"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Tambah Siswa</button>
					<a href="<?php echo base_url().'test/manual_excel_exp/'.$this->uri->segment(3); ?>"><button class="btn btn-success" id="exportnilai" alt="<?php echo $this->uri->segment(3); ?>"><i class="glyphicon glyphicon-export"></i>&nbsp;&nbsp;Export Nilai Siswa</button></a>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-10">
					
					<div class="panel panel-primary" id="pDaftarSiswa" alt="<?php echo $this->uri->segment(3); ?>">
						<div class="panel-heading">Daftar Siswa Kelas <?php echo $kelas; ?></div>
						<div class="panel-body">
							<?php echo $this->session->flashdata('status'); ?>
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped tablesorter">
									<thead>
										<tr>
											<th class="header">NIS</th>
											<th class="header">Nama Siswa</th>
											<th class="header">Tahun Masuk</th>
											<th class="header">Minat Siswa</th>
											<th class="header">Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach($daftar_siswa->result() as $s) {
										?>
										<tr>
											<td id="nis"><?php echo $s->nis; ?></td>
											<td id="nama"><?php echo $s->nama; ?></td>
											<td id="tahun_masuk"><?php echo $s->tahun_masuk; ?></td>
											<td><a class="minatSiswa" alt="<?php echo $s->nis; ?>" href="#">Lihat Minat Siswa</a></td>
											<td>
												<span style="cursor:pointer;" class="daftar_nilai" alt="<?php echo $s->nis; ?>"><i class="glyphicon glyphicon-th-list" title="Daftar Nilai"></i>&nbsp;</span>
												<span style="cursor:pointer;" class="ubahSiswa" alt="<?php echo $s->nis; ?>"><i class="glyphicon glyphicon-pencil" title="Ubah"></i>&nbsp;</span>
												<span style="cursor:pointer;" class="hapusSiswa" alt="<?php echo $s->nis; ?>"><i class="glyphicon glyphicon-remove" title="Hapus"></i>&nbsp;</span>
											</td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>

							</div>
							
						</div>
					</div>
				</div>
			</div>
		  </div>
<!-- Nilai Modal -->
<div class="modal fade" id="nilaiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>
<!-- end nilaiModal -->
<!-- Minat Modal -->
<div class="modal fade" id="minatModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>
<!-- end minatModal -->
<!-- Form Tambah dan Ubah Siswa Modal -->
<div class="modal fade" id="formSiswaModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>
<!-- end Form Tambah dan Ubah Siswa -->
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/jquery-1.11.0.js"></script>
    <script src="<?php echo base_url(); ?>asset/sb-admin/js/bootstrap.js"></script>
	<script src="<?php echo base_url(); ?>asset/typeahead.js"></script>
	<script>
		var base_url = '<?php echo base_url(); ?>';
	</script>
<script>
$(document).ready(function() {
	$('.daftar_nilai').click(function() {
		var nis = $(this).attr('alt');
		$('#nilaiModal').load(base_url+'admin/daftar_nilai/'+nis);
		$('#nilaiModal').modal('toggle');
	});
	
	$('.minatSiswa').click(function() {
		var nis = $(this).attr('alt');
		$('#minatModal').load(base_url+'admin/daftar_minat/'+nis);
		$('#minatModal').modal('toggle');
		$('#nis').html(nis);
	});
	
	$('#tambahSiswa').click(function() {
		$('#formSiswaModal').load(base_url+'admin/form_siswa/'+$(this).attr('alt'));
		$('#formSiswaModal').modal('toggle');
	});
	
	$('.ubahSiswa').click(function() {
		var kelas = $('#tambahSiswa').attr('alt');
		var nis = $(this).attr('alt');
		$('#formSiswaModal').load(base_url+'admin/form_siswa/'+kelas+'/'+nis);
		$('#formSiswaModal').modal('toggle');
		$('#nis').html(nis);
	});
	
	$('.hapusSiswa').click(function() {
		var nis = $(this).attr('alt');
		
		var c = confirm("Apakah Anda Yakin Ingin Menghapus Data Ini?");
		if (c) {
		$.ajax({
			url:base_url+'guru/hapus_siswa/'+nis,
			success:function(msg) {
				var status = '';
				setTimeout(function() {
					var kelas = $('#tambahSiswa').attr('alt');
					//document.write(msg);
					window.location.replace(base_url+'admin/siswa/'+kelas);
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