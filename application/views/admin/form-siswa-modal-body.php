<div class="modal-dialog">
    <div class="modal-content">
	<?php
	if (!isset($daftar_siswa)) {
	?>
	<!-- form tambah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Tambah Siswa</h4>
      </div>
      <div class="modal-body">
		<form id="formSiswa" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>guru/tambah_siswa">
		  <div class="form-group">
			<label class="col-sm-3 control-label">NIS</label>
			<div class="col-sm-8">
			  <input type="text" id="inis" class="form-control" name="nis" placeholder="Nomor Induk Siswa">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Nama</label>
			<div class="col-sm-8">
			  <input type="text" id="inama" class="form-control" name="nama" placeholder="Nama Siswa">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Tahun Masuk</label>
			<div class="col-sm-8">
			  <input type="text" id="ithn" class="form-control" name="tahun_masuk" placeholder="Tahun Masuk" value="<?php echo $tahun_ajaran-3; ?>">
			  <input type="hidden" id="ikls" class="form-control" name="id_kelas" value="<?php echo $kelas; ?>">
			</div>
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnSimpan" class="btn btn-primary">Save changes</button>
      </div>
    </div>
	<!-- end form tambah-->
	<?php
	} else {
	?>
	<!-- form ubah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Ubah Siswa</h4>
      </div>
      <div class="modal-body">
		<form id="formSiswa" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>guru/ubah_siswa">
			<?php foreach($daftar_siswa->result() as $s) { ?>
		  <div class="form-group">
			<label class="col-sm-3 control-label">NIS</label>
			<div class="col-sm-8">
			  <input type="text" id="inis" class="form-control" name="nis" placeholder="Nomor Induk Siswa" readonly value="<?php echo $s->nis; ?>">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Nama</label>
			<div class="col-sm-8">
			  <input type="text" id="inama" class="form-control" name="nama" placeholder="Nama Siswa" value="<?php echo $s->nama; ?>">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Tahun Masuk</label>
			<div class="col-sm-8">
			  <input type="text" id="ithn" class="form-control" name="tahun_masuk" placeholder="Tahun Masuk" value="<?php echo $s->tahun_masuk; ?>">
			  <input type="hidden" id="ikls" class="form-control" name="id_kelas" value="<?php echo $s->id_kelas; ?>">
			</div>
		  </div>
		  <?php } ?>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnSimpan" class="btn btn-primary">Save changes</button>
      </div>
    </div>
	<!-- end form ubah-->
	<?php 
	}
	?>
  </div>
<script src="<?php echo base_url(); ?>asset/jquery-validation/dist/jquery.validate.min.js"></script>
<script>

$('#formSiswa').validate({
	rules : {
		nis : {
			required : true,
			number : true
		},
		nama : {
			required : true
		},
		tahun_masuk : {
			required : true,
			number : true,
			min:2000,
			max:2013
		}
	},
	messages : {
		nis : {
			required : "Kolom NIS Tidak Boleh Kosong",
			number : "Kolom NIS Harus Angka"
		},
		nama : {
			required : "Kolom Nama Tidak Boleh Kosong"
		},
		tahun_masuk : {
			required : "Kolom Tahun Masuk Tidak Boleh Kosong",
			number : "Format Tahun Masuk Tidak Valid",
			min : "Tahun Harus Lebih Dari Tahun 2000",
			max : "Tahun Harus Kurang Dari Tahun 2013",
		}
	}
});

</script>
<script>
$(document).ready(function() {
	$('#btnSimpan').click(function() {
		$('#formSiswa').submit();
	});
});
</script>