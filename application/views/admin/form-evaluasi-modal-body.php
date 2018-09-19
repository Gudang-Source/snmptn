<div class="modal-dialog">
    <div class="modal-content">
	<?php
	if (!isset($evaluasi)) {
	?>
	<!-- form tambah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Tambah Catatan Evaluasi</h4>
      </div>
      <div class="modal-body">
		<form id="formEvaluasi" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>guru/tambah_catatan">
		  <div class="form-group">
			<label class="col-sm-3 control-label">Tahun</label>
			<div class="col-sm-8">
			  <input type="text" id="thn" class="form-control" name="thn" placeholder="Tahun Kelulusan" />
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Keterangan</label>
			<div class="col-sm-8">
			  <textarea id="ket" class="form-control" name="ket" placeholder="Catatan Evaluasi" rows="8" style="resize:none;"></textarea>
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
        <h4 class="modal-title" id="myModalLabel">Form Ubah Catatan Evaluasi</h4>
      </div>
      <div class="modal-body">
		<form id="formEvaluasi" class="form-horizontal" role="form" method="post" action="<?php echo base_url().'guru/ubah_catatan/'.$this->uri->segment(3); ?>">
		  <div class="form-group">
			<label class="col-sm-3 control-label">Tahun</label>
			<div class="col-sm-8">
			  <input type="text" id="thn" class="form-control" name="thn" placeholder="Tahun Kelulusan" value="<?php echo $evaluasi->row()->tahun; ?>" />
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Keterangan</label>
			<div class="col-sm-8">
			  <textarea id="ket" class="form-control" name="ket" placeholder="Catatan Evaluasi" rows="8" style="resize:none;"><?php echo $evaluasi->row()->hasil_evaluasi; ?></textarea>
			</div>
		  </div>
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

$('#formEvaluasi').validate({
	rules : {
		thn : {
			required : true,
			number : true
		},
		ket : {
			required : true
		}
	},
	messages : {
		thn : {
			required : "Kolom Tahun Tidak Boleh Kosong",
			number : "Kolom Tahun Harus Angka"
		},
		ket : {
			required : "Kolom Keterangan Tidak Boleh Kosong"
		}
	}
});

</script>
<script>
$(document).ready(function() {
	$('#btnSimpan').click(function() {
		$('#formEvaluasi').submit();
	});
});
</script>