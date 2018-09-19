<div class="modal-dialog">
    <div class="modal-content">
	<!-- form tambah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Tambah Jurusan</h4>
      </div>
      <div class="modal-body">
		<form id="formJur" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>ptn/tambah_jurusan">
		  <div class="form-group">
			<label class="col-sm-3 control-label">Nama Jurusan</label>
			<div class="col-sm-8">
			  <input type="hidden" id="idPtn" class="form-control" name="idPtn" value="<?php echo $id_ptn; ?>">
			  <input type="text" id="namaJur" class="form-control" name="namaJur" placeholder="Nama Jurusan">
			  <!--<select multiple data-role="tagsinpus" id="namaJur" name="namaJur">
				 <option value="Amsterdam">Amsterdam</option>
					<option value="Washington">Washington</option>
					<option value="Sydney">Sydney</option>
					<option value="Beijing">Beijing</option>
					<option value="Cairo">Cairo</option>
			  </select>
			  -->
			</div>
		  </div>
		</form>
		<div id="status"></div>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnClose" class="btn btn-default">Close</button>
        <button type="button" id="btnSimpan" class="btn btn-primary">Save changes</button>
      </div>
    </div>
	<!-- end form tambah-->
  </div>
<script>
	$('#namaJur').typeahead({
		name:'nama_jur',
		remote: base_url+'ptn/cari_jurusan?q=%QUERY',
		displayKey:'nama_jur',
		limit:4
	});
	$('.tt-query').css('background-color','#fff');
	
	$(document).ready(function() {
		$('#btnClose').click(function() {
			var id_ptn = $('#idPtn').val();
			$('#ptnModal').load(base_url+'admin/daftar_jurusan/'+id_ptn);
		});
		
		$('#btnSimpan').click(function() {
			var id_ptn=$('#idPtn').val();
			var namaJur=$('#namaJur').val();
			
			$.ajax({
				data:'id_ptn='+id_ptn+'&namaJur='+namaJur,
				type:'POST',
				url: base_url+'ptn/tambah_jurusan/',
				success:function(msg) {
					$('#ptnModal .modal-dialog .modal-content .modal-body #status').html(msg);
					/*if (msg.indexOf('Berhasil')>0) {
						var kembali=setTimeout(function() {
								$('#ptnModal').load(base_url+'admin/daftar_jurusan/'+id_ptn);
							},2000);
					}*/
				}
			});
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
			namaJur : {
				required : "Kolom Nama Jurusan Tidak Boleh Kosong"
			}
		}
	});
	</script>