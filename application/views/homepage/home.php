<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--<link href="jumbotron.css" rel="stylesheet">-->
	
  </head>
<body>
	<?php $this->load->view('homepage/navbar'); ?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
		<div class="container">
			<h1>APLIKASI PREDIKSI<br /> KELULUSAN SNMPTN</h1>
			<p>Aplikasi ini digunakan oleh warga sekolah SMA Negeri XYZ untuk memprediksi kelulusan siswa yang mengikuti Seleksi Nasional Masuk Perguruan Tinggi Negeri(SNMPTN)</p>
		</div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
			<h2>Perkembangan Kelulusan Siswa</h2>
			<a href="<?php echo base_url(); ?>homepage/perkembangan_kelulusan"><img style="width:100%; height:220px; margin-bottom:10px;" src="<?php echo base_url();?>asset/images/grafik.jpg" alt="" class="img-rounded"></a>
        </div>
        <div class="col-md-4">
          <h2>Prediksi Kelulusan<br />&nbsp;</h2>
          <a href="<?php echo base_url(); ?>homepage/prediksi"><img style="width:100%; height:220px; margin-bottom:10px;" src="<?php echo base_url();?>asset/images/lulus.jpg" alt="" class="img-rounded"></a>
       </div>
        <div class="col-md-4">
          <h2>Daftar Peringkat<br />&nbsp;</h2>
          <a href="<?php echo base_url(); ?>homepage/peringkat"><img style="width:100%; height:220px; margin-bottom:10px;" src="<?php echo base_url();?>asset/images/peringkat.jpg" alt="" class="img-rounded"></a>
        </div>
      </div>

      <hr>

      <?php $this->load->view('homepage/footer'); ?>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url(); ?>asset/jquery-1.11.0.js"></script>
	<script src="<?php echo base_url(); ?>asset/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>