<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Minat Siswa</h4>
      </div>
      <div class="modal-body">
		<form id="form_minat" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>guru/tambah_minat">
		  <div class="form-group">
			<label class="col-sm-3 control-label">PTN</label>
			<div class="col-sm-8">
			  <input type="hidden" class="form-control" name="nis" value="<?php echo $nis; ?>">
			  <input id="iptn" type="text" class="form-control" name="nm_ptn" placeholder="Perguruan Tinggi Negeri">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Jurusan/Fakultas</label>
			<div class="col-sm-8">
			  <input id="ijur" type="text" disabled class="form-control" name="nm_jur" placeholder="Jurusan/Fakultas">
			</div>
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnSimpanMinat" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
<script>
	$('#iptn').typeahead({
		name:'nama_ptn',
		remote: base_url+'ptn/cari_ptn/%QUERY',
		displayKey:'nama_ptn',
		limit:4
	});
	$('#ijur').typeahead({
		name:'nama_jur',
		remote: {
			url: base_url+'ptn/cari_jurusan?q=%QUERY',
			replace: function () {
				var q = base_url+'ptn/cari_jurusan?q='+$('#ijur').val();
				if ($('#iptn').val()) {
					q += "&ptn=" + encodeURIComponent($('#iptn').val());
				}
				return q;
			}
		},
		displayKey:'nama_jur',
		limit:4
	});
	$('.tt-query').css('background-color','#fff');
	
	$(document).ready(function() {
		
		$('#btnSimpanMinat').click(function() {
			if ($('#iptn').val()=="" ||$('#ijur').val()=="") {
				alert('Nama PTN dan Jurusan Harus Di Masukkan');
			} else {
				$('#form_minat').submit();
			}
		});
		
		$('#iptn').change(function() {
			$('#ijur').removeAttr('disabled');
		});
		
	});
</script>
