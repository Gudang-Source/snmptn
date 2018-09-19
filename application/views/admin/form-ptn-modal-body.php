<div class="modal-dialog">
    <div class="modal-content">
	<?php
	if (!isset($ptn)) {
	?>
	<!-- form tambah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Tambah PTN</h4>
      </div>
      <div class="modal-body">
		<form id="formPtn" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>ptn/tambah_ptn">
		  <div class="form-group">
			<label class="col-sm-3 control-label">Nama PTN</label>
			<div class="col-sm-8">
			  <input type="text" id="iNamaPtn" class="form-control" name="nama_ptn" placeholder="Nama PTN" autocomplete="off">
			</div>
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="simpanPtn" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
	<!-- end form tambah-->
	<?php
	} else {
	?>
	<!-- form ubah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Ubah PTN</h4>
      </div>
      <div class="modal-body">
		<form id="formPtn" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>ptn/ubah_ptn">
		<?php
		foreach ($ptn->result() as $p) {
		?>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Nama PTN</label>
			<div class="col-sm-8">
			  <input type="hidden" class="form-control" name="id_ptn" value="<?php echo $p->id_ptn; ?>">
			  <input type="text" id="iNamaPtn" class="form-control" name="nama_ptn" value="<?php echo $p->nama_ptn; ?>">
			</div>
		  </div>
		<?php
		}
		?>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="simpanPtn" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
	<!-- end form ubah-->
	<?php
	}
	?>
  </div>

<script>
	$('#iNamaPtn').typeahead({
		name:'nama_ptn',
		remote: base_url+'ptn/cari_ptn/%QUERY',
		displayKey:'nama_ptn',
		limit:4
	});
	$('.tt-query').css('background-color','#fff');
	
	$(document).ready(function() {
		$('#simpanPtn').click(function() {
			$('#formPtn').submit();
		});
		
	});
</script>
<script src="<?php echo base_url(); ?>asset/jquery-validation/dist/jquery.validate.min.js"></script>
	<script>
	$('#formPtn').validate({
		rules : {
			nama_ptn : {
				required : true
			}
		},
		messages : {
			nama_ptn : {
				required : "Kolom Nama PTN Tidak Boleh Kosong"
			}
		}
	});
	</script>