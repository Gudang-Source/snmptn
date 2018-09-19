<!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">SMA NEGERI XYZ</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li <?php if($this->uri->segment(2)=="") echo 'class="active"'; ?>><a href="<?php echo base_url().'homepage'?>"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Halaman Utama
</a></li>
					<li <?php if($this->uri->segment(2)=="perkembangan_kelulusan") echo 'class="active"'; ?>><a href="<?php echo base_url().'homepage/perkembangan_kelulusan'?>"><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;Perkembangan Kelulusan</a></li>
					<li <?php if($this->uri->segment(2)=="prediksi") echo 'class="active"'; ?>><a href="<?php echo base_url().'homepage/prediksi'?>"><span class="glyphicon glyphicon-transfer"></span>&nbsp;&nbsp;Prediksi Kelulusan</a></li>
					<li <?php if($this->uri->segment(2)=="peringkat") echo 'class="active"'; ?>><a href="<?php echo base_url().'homepage/peringkat'?>"><span class="glyphicon glyphicon-sort-by-order"></span>&nbsp;&nbsp;Daftar Peringkat</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
    </div>