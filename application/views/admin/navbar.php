<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url(); ?>" target="_blank">Aplikasi Prediksi Kelulusan SNMPTN</a>
        </div>
		<div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
			<li><a href="<?php echo base_url(); ?>" target="_blank"><i class="fa fa-home"></i> Homepage</a></li>
            <li <?php if ($this->uri->segment(2)=='') echo 'class="active"'; ?>><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li <?php if ($this->uri->segment(2)=='kelas' || $this->uri->segment(2)=='siswa') echo 'class="active"'; ?>><a href="<?php echo base_url(); ?>admin/kelas"><i class="fa fa-user"></i> Kelas</a></li>
			<!--<li <?php if ($this->uri->segment(2)=='guru') echo 'class="active"'; ?>><a href="<?php echo base_url(); ?>admin/guru"><i class="fa fa-file"></i> Kelola Guru</a></li>-->
			<li <?php if ($this->uri->segment(2)=='mata_pelajaran') echo 'class="active"'; ?>><a href="<?php echo base_url(); ?>admin/mata_pelajaran"><i class="fa fa-tasks"></i> Kelola Mata Pelajaran</a></li>
			<li><a href="#" id="perbarui"><i class="glyphicon glyphicon-stats"></i> Pembaharuan Peringkat</a></li>
			
            <li class="dropdown <?php if ($this->uri->segment(2)=='ptn' || $this->uri->segment(2)=='jurusan_ptn') echo 'active'; ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-square-o-down"></i> PTN dan Jurusan<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo base_url(); ?>admin/ptn"><i class="fa fa-file"></i> Kelola PTN</a></li>
                <li><a href="<?php echo base_url(); ?>admin/jurusan_ptn"><i class="fa fa-file"></i> Kelola Jurusan</a></li>
              </ul>
            </li>
			
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->userdata('nama'); ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo base_url(); ?>admin/profil_guru"><i class="fa fa-user"></i> Profile</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url(); ?>login/do_logout"><i class="fa fa-power-off"></i> Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div>

	</nav>
	<div id="modalPeringkat" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div style="background:white; width:350px; height:350px; margin-top:35%;padding:10px;">
			<img style="width:100%; height:100%" src="<?php echo base_url(); ?>asset/images/loading-icon.gif" />
			</div>
			<div style="background:white; width:350px; padding:5px;">
				<h4><span class="label label-info">Harap Tunggu, Sedang Pembaharuan Peringkat</span></h4>
			</div>
		</div>
	</div>
	<script src="<?php echo base_url(); ?>asset/jquery-1.11.0.js"></script>
	<script>
		$(document).ready(function() {
			$('#perbarui').click(function() {
				$('#modalPeringkat').modal('toggle');
				$.ajax({
					url:'<?php echo base_url(); ?>guru/beri_peringkat_minat',
					type:'GET',
					success:function(msg) {
						$('#modalPeringkat').modal('toggle');
						alert('Proses Pembaharuan Peringkat Selesai');
					}
				});
			});
		});
	</script>