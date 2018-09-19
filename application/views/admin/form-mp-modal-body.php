<div class="modal-dialog">
    <div class="modal-content">
	<?php
	if (!isset($nama_mp)) {
	?>
	<!-- form tambah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Tambah Mata Pelajaran</h4>
      </div>
      <div class="modal-body">
		<form id="formMp" method="post" action="<?php echo base_url(); ?>mata_pelajaran/tambah_mp">
		  <div class="row" style="margin-bottom:15px;">
			<div class="col-sm-12">
			<label class="col-sm-4 control-label">Nama Mata Pelajaran</label>
			<div class="col-sm-6">
				<input type="hidden" class="form-control" id="ijurusan" name="jurusan" value="<?php echo $this->uri->segment(3); ?>">
			  <input type="text" class="form-control" id="inama_mp" name="nama_mp" placeholder="Nama Mata Pelajaran">
			</div>
			</div>
		  </div>
		  <div class="row" style="margin-bottom:15px;">
			<div class="col-sm-12">
			<label class="col-sm-4 control-label">Apakah Termasuk Mata Pelajaran UN?</label>
			<div class="col-sm-6">
				<select class="form-control" name="ket_mp_un">
					<option value="tidak">Tidak</option>
					<option value="ya">Ya</option>
				</select>
			</div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-sm-12">
			<table class="table" id="tabelMp">
				<thead>
					<tr>
						<th>Semester</th><th>KKM</th>
					</tr>
				</thead>
				<tbody>
				<tr class="kkm">
					<td><input type="text" class="form-control" id="inputSmtr" name="smt[]" value="1" readonly="readonly" placeholder="Semester"></td>
					<td><input type="number" class="form-control" id="inputKKM0" name="kkm0" value="70" placeholder="KKM"></td>
				</tr>
				<tr class="kkm">
					<td><input type="text" class="form-control" id="inputSmtr" name="smt[]" value="2" readonly="readonly"  placeholder="Semester"></td>
					<td><input type="number" class="form-control" id="inputKKM1" name="kkm1" value="70" placeholder="KKM"></td>
				</tr>
				<tr class="kkm">
					<td><input type="text" class="form-control" id="inputSmtr" name="smt[]" value="3" readonly="readonly" placeholder="Semester"></td>
					<td><input type="number" class="form-control" id="inputKKM2" name="kkm2" value="70" placeholder="KKM"></td>
				</tr>
				<tr class="kkm">
					<td><input type="text" class="form-control" id="inputSmtr" name="smt[]" value="4" readonly="readonly" placeholder="Semester"></td>
					<td><input type="number" class="form-control" id="inputKKM3" name="kkm3" value="70" placeholder="KKM"></td>
				</tr>
				<tr class="kkm">
					<td><input type="text" class="form-control" id="inputSmtr" name="smt[]" value="5" readonly="readonly" placeholder="Semester"></td>
					<td><input type="number" class="form-control" id="inputKKM4" name="kkm4" value="70" placeholder="KKM"></td>
				</tr>
				</tbody>
			</table>
			<!--<button type="button" id="tambahKKM" class="btn">Tambah KKM</button>-->
			</div>
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="simpanMp" class="btn btn-primary">Save changes</button>
      </div>
	<!-- end form tambah-->
	<?php 
	} else {
	?>
	<!-- form ubah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Ubah Mata Pelajaran</h4>
      </div>
      <div class="modal-body">
		<form id="formMp" method="post" action="<?php echo base_url(); ?>mata_pelajaran/ubah_mp">
		  <div class="row" style="margin-bottom:15px;">
			<div class="col-sm-12">
			<label class="col-sm-4 control-label">Nama Mata Pelajaran</label>
			<div class="col-sm-6">
				<input type="hidden" class="form-control" id="ijurusan" name="jurusan" value="<?php echo $jurusan ?>">
				<input type="text" class="form-control" id="inama_mp" name="nama_mp" value="<?php echo $nama_mp ?>">
			</div>
			</div>
		  </div>
		  <div class="row" style="margin-bottom:15px;">
			<div class="col-sm-12">
			<label class="col-sm-4 control-label">Apakah Termasuk Mata Pelajaran UN?</label>
			<div class="col-sm-6">
				<select class="form-control" name="ket_mp_un">
					<option value="tidak">Tidak</option>
					<option value="ya">Ya</option>
				</select>
			</div>
			</div>
		  </div>
		  <div class="row">
			<div class="col-sm-12">
			<table class="table" id="tabelMp">
				<thead>
					<tr>
						<th>Semester</th><th>KKM</th>
					</tr>
				</thead>
				<tbody>
				<?php 
				$no=0;
				foreach($daftar_kkm->result() as $kkm) {
				?>
				<tr class="kkm">
					<td>
					<input type="hidden" class="form-control" id="inputKdMp" name="kdMp[]" value="<?php echo $kkm->kd_mp; ?>" /><?php echo $kkm->semester; ?><input type="hidden" class="form-control" id="inputSmtr" name="smt[]" placeholder="Semester" value="<?php echo $kkm->semester; ?>"></td>
					<td><input type="number" id="inputKKM<?php echo $no; ?>" class="form-control" id="inputKKM" name="kkm<?php echo $no; ?>" value="<?php echo $kkm->kkm; ?>"/></td>
					<td><span title="Hapus KKM" class="hapusMp" alt="<?php echo $kkm->kd_mp; ?>"><i class="glyphicon glyphicon-remove" style="vertical-align:middle; cursor:pointer;" ></i></span></td>
				</tr>
				<?php
				$no++;
				}
				?>
				</tbody>
			</table>
			<button type="button" id="tambahKKM" class="btn">Tambah KKM</button>
			</div>
		  </div>
		</form>
      </div>
	  <div id="status"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="simpanMp" class="btn btn-primary">Save changes</button>
      </div>
	<!-- end form ubah-->
	<?php 
	}
	?>
	</div>
  </div>
  <script src="<?php echo base_url(); ?>asset/jquery-validation/dist/jquery.validate.min.js"></script>
<script>
$('#formMp').validate();

for(var n=0; n<5; n++) {
	$("#inputKKM"+n).rules( "add", {
		required: true,
		number: true,
		messages: {
			required:'Field KKM Harus Diisi',
			number:'Field KKM Harus Angka'
		}
	});
}


</script>
<script>
$(document).ready(function() {
$('#tambahKKM').click(function() {
	$('#tabelMp tbody').append('<tr class="kkm"><td><input type="hidden" class="form-control" id="inputKdMp" name="kdMp[]"><input type="text" class="form-control" id="inputSmtr" name="smt[]" placeholder="Semester"></td><td><input type="number" class="form-control" id="inputKKM" name="kkm[]" placeholder="KKM"></td></tr>');
});

$('#simpanMp').click(function() {
	$('#formMp').submit();
});

$('.hapusMp').click(function() {
	var kdMp = $(this).attr('alt');
	var jur = kdMp.substr(2,1);
	var nm_mp = $('#inama_mp').val();
	
	$.ajax({
		url: base_url+'mata_pelajaran/hapus_mp/'+kdMp,
		success:function(msg) {
			$('#mpModal').load(base_url+'admin/form_mp/'+jur+'/'+nm_mp.replace(" ","_"));
			$('#status').html(msg);
		}
	});
	
});

});
</script>