<div class="modal-dialog">
    <div class="modal-content">
	<?php
	if (!isset($jur)) {
	?>
	<!-- form tambah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Tambah Jurusan</h4>
      </div>
      <div class="modal-body">
		<form id="formJur" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>ptn/tambah_jur_ptn">
		  <div class="form-group">
			<label class="col-sm-3 control-label">Nama Jurusan</label>
			<div class="col-sm-8">
			  <input type="text" id="iNamaJur" class="form-control" name="nama_jur" placeholder="Nama Jurusan" autocomplete="off">
			</div>
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="simpanJur" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
	<!-- end form tambah-->
	<?php
	} else {
	?>
	<!-- form ubah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Ubah Jurusan</h4>
      </div>
      <div class="modal-body">
		<form id="formJur" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>ptn/ubah_jur_ptn">
		<?php
		foreach ($jur->result() as $j) {
		?>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Nama Jurusan</label>
			<div class="col-sm-8">
			  <input type="hidden" class="form-control" name="id_jur_ptn" value="<?php echo $j->id_jurusan_ptn; ?>">
			  <input type="text" id="iNamaJur" class="form-control" name="nama_jur_ptn" value="<?php echo $j->nama_jurusan_ptn; ?>">
			</div>
		  </div>
		<?php
		}
		?>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="simpanJur" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
	<!-- end form ubah-->
	<?php
	}
	?>
  </div>

<script>
	$('#iNamaJur').typeahead({
		name:'nama_jurusan_ptn',
		remote: base_url+'ptn/cari_jurusan?q=%QUERY',
		displayKey:'nama_jurusan_ptn',
		limit:4
	});
	$('.tt-query').css('background-color','#fff');
	
	$(document).ready(function() {
		$('#simpanJur').click(function() {
			$('#formJur').submit();
		});
		
	});
</script>
<script src="<?php echo base_url(); ?>asset/jquery-validation/dist/jquery.validate.min.js"></script>
	<script>
	$('#formJur').validate({
		rules : {
			nama_ptn : {
				required : true
			}
		},
		messages : {
			nama_jur : {
				required : "Kolom Nama Jurusan Tidak Boleh Kosong"
			}
		}
	});
	</script>