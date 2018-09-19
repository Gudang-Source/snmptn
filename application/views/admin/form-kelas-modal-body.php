<div class="modal-dialog">
    <div class="modal-content">
	<?php
	if (!isset($kelas)) {
	?>
	<!-- form tambah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Tambah Kelas</h4>
      </div>
      <div class="modal-body">
		<form id="formKelas" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>guru/tambah_kelas">
		  <div class="form-group">
			<label class="col-sm-3 control-label">Jurusan</label>
			<div class="col-sm-8">
			  <select class="form-control" name="jurusan">
				<option value="2">IPA</option>
				<option value="3">IPS</option>
			  </select>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Nama Kelas</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="nama_kelas" placeholder="Nama Kelas">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Tahun Ajaran</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="tahun_ajaran" placeholder="Tahun Ajaran">
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
        <h4 class="modal-title" id="myModalLabel">Form Ubah Kelas</h4>
      </div>
      <div class="modal-body">
		<form id="formKelas" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>guru/ubah_kelas">
		<?php 
		foreach($kelas->result() as $k) {
		?>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Jurusan</label>
			<div class="col-sm-8">
			  <select class="form-control" name="jurusan">
				<option <?php if ($k->id_jurusan==2) echo 'selected'; ?> value="2">IPA</option>
				<option <?php if ($k->id_jurusan==3) echo 'selected'; ?>value="3">IPS</option>
			  </select>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Nama Kelas</label>
			<div class="col-sm-8">
			  <input type="hidden" class="form-control" name="id_kelas" placeholder="Nama Kelas" value="<?php echo $k->id_kelas; ?>">
			  <input type="text" class="form-control" name="nama_kelas" placeholder="Nama Kelas" value="<?php echo $k->nama_kelas; ?>">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Tahun Ajaran</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="tahun_ajaran" placeholder="Tahun Ajaran" value="<?php echo $k->tahun_ajaran; ?>">
			</div>
		  </div>
		<?php
		}
		?>
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
	<script>
	$(document).ready(function() {
		$('#btnSimpan').click(function() {
			$('#formKelas').submit();
		});
	});
	</script>
	<script src="<?php echo base_url(); ?>asset/jquery-validation/dist/jquery.validate.min.js"></script>
	<script>
	$('#formKelas').validate({
		rules : {
			jurusan : {
				required : true
			},
			nama_kelas : {
				required : true
			},
			tahun_ajaran : {
				required : true
			}
		},
		messages : {
			jurusan : {
				required : "Kolom Jurusan Harus Dipilih"
			},
			nama_kelas : {
				required : "Kolom Nama Kelas Tidak Boleh Kosong"
			},
			tahun_ajaran : {
				required : "Kolom Tahun Ajaran Tidak Boleh Kosong"
			}
		}
	});
	</script>