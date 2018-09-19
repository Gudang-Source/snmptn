<div class="modal-dialog">
    <div class="modal-content">
	<?php if (!isset($data_guru)) {?>
	<!-- form tambah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Tambah Guru</h4>
      </div>
      <div class="modal-body">
		<form id="formGuru" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>guru/tambah_guru">
		  <div class="form-group">
			<label class="col-sm-3 control-label">NIP</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="nip" placeholder="Nomor Induk Pegawai">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Nama Guru</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="nama_guru" placeholder="Nama Guru">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Password</label>
			<div class="col-sm-8">
			  <input type="password" class="form-control" name="password" placeholder="Password">
			</div>
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="btnSimpan" type="button" class="btn btn-primary">Save changes</button>
      </div>
	<!-- end form tambah-->
	<?php } else {
		foreach($data_guru->result() as $g) {
	?>
	<!-- form ubah -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Form Tambah Guru</h4>
      </div>
      <div class="modal-body">
		<form id="formGuru" class="form-horizontal" role="form" method="post" action="<?php echo base_url(); ?>guru/ubah_guru">
		  <div class="form-group">
			<label class="col-sm-3 control-label">NIP</label>
			<div class="col-sm-8">
			  <input type="hidden" class="form-control" name="id" value="<?php echo $g->id; ?>">
			  <input type="text" class="form-control" name="nip" placeholder="Nomor Induk Pegawai" value="<?php echo $g->nip; ?>">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Nama Guru</label>
			<div class="col-sm-8">
			  <input type="text" class="form-control" name="nama_guru" placeholder="Nama Guru" value="<?php echo $g->nama; ?>">
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-3 control-label">Password</label>
			<div class="col-sm-8">
			  <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo $g->password; ?>">
			</div>
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="btnSimpan" type="button" class="btn btn-primary">Save changes</button>
      </div>
	<!-- end form ubah-->
	<?php 
		}
	}
	?>
    </div>
  </div>
<script>
$(document).ready(function() {
	$('#btnSimpan').click(function() {
		$('#formGuru').submit();
	});
});
</script>