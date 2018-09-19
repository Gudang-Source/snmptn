<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel" alt="<?php echo $this->uri->segment(3); ?>">Daftar Nilai Siswa</h4>
      </div>
      <div class="modal-body">
		<div class="bs-example">
			<ul id="semester" class="nav nav-tabs" style="margin-bottom: 15px;">
				<li <?php if (!isset($smt) || $smt==1) { echo 'class="active"'; } else { echo 'class=""'; } ?>>
					<a style="cursor:pointer;" data-toggle="tab" alt="1">Semester 1</a>
				</li>
				<li <?php if (!isset($smt) || $smt==2) { echo 'class="active"'; } else { echo 'class=""'; } ?>>
					<a style="cursor:pointer;" data-toggle="tab" alt="2">Semester 2</a>
				</li>
				<li <?php if (!isset($smt) || $smt==3) { echo 'class="active"'; } else { echo 'class=""'; } ?>>
					<a style="cursor:pointer;" data-toggle="tab" alt="3">Semester 3</a>
				</li>
				<li <?php if (!isset($smt) || $smt==4) { echo 'class="active"'; } else { echo 'class=""'; } ?>>
					<a style="cursor:pointer;" data-toggle="tab" alt="4">Semester 4</a>
				</li>
				<li <?php if (!isset($smt) || $smt==5) { echo 'class="active"'; } else { echo 'class=""'; } ?>>
					<a style="cursor:pointer;" data-toggle="tab" alt="5">Semester 5</a>
				</li>
				<li <?php if (!isset($smt) || $smt=='un') { echo 'class="active"'; } else { echo 'class=""'; } ?>>
					<a style="cursor:pointer;" data-toggle="tab" alt="un">Ujian Nasional</a>
				</li>
			</ul>
			<div id="myTabContent" class="tab-content">
				<div id="smt1" class="tab-pane fade active in">
					<div class="table-responsive">
						<form id="formNilai" method="post" action="<?php echo base_url(); ?>guru/ubah_nilai">
						<input type="hidden" name="nis" value="<?php echo $this->uri->segment(3); ?>" />
						<table class="table table-bordered table-hover table-striped tablesorter">
							<?php
							if ($smt!='un') {
							?>
							<thead>
								<tr>
									<th class="header">Nama Mata Pelajaran</th>
									<th class="header">KKM</th>
									<th class="header">Nilai</th>
								</tr>
							</thead>
							
							<tbody>
								
								<?php
								$no=1;
								foreach($daftar_mp->result() as $mp) {
								?>
								<tr>
									<td><?php echo $mp->nama_mp; ?></td>
									<td><?php echo $mp->kkm; ?></td>
									<td>
										<input type="hidden" class="form-control" name="kd_mp[]" value="<?php echo $mp->kd_mp; ?>">
										<input type="text" class="form-control" id="nilai<?php echo $no; ?>" name="nilai<?php echo $no; ?>" value="<?php if ($mp->nilai==0) { /*echo rand(70,100);*/ } else {echo $mp->nilai; } ?>">
									</td>
								</tr>
								<?php 
								$no++;
								}
								?>
							</tbody>
							<?php
							} else {
							?>
							<thead>
								<tr>
									<th class="header">Nama Mata Pelajaran</th>
									<th class="header">Nilai</th>
								</tr>
							</thead>
							
							<tbody>
								
								<?php
								$no=1;
								foreach($daftar_mp->result() as $mp) {
								?>
								<tr>
									<td><?php echo $mp->nama_mp; ?></td>
									<td>
										<input type="hidden" class="form-control" name="kd_mp[]" value="<?php echo $mp->kd_mp_un; ?>">
										<input type="text" class="form-control" id="nilai<?php echo $no; ?>" name="nilai<?php echo $no; ?>" value="<?php if ($mp->nilai==0) { /*echo rand(70,100);*/ } else {echo $mp->nilai; } ?>">
									</td>
								</tr>
								<?php 
								$no++;
								}
								?>
							</tbody>
							<?php
							}
							?>
						</table>
						</form>
						<span id="jmlMp" style="display:none;"><?php echo $no; ?></span>
					</div>
				</div>
			</div>

		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="btnSimpan" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
  
<script src="<?php echo base_url(); ?>asset/jquery-validation/dist/jquery.validate.min.js"></script>
<script>
$('#formNilai').validate();

for(var n=1; n<parseInt($('#jmlMp').html()); n++) {
	$("#nilai"+n).rules( "add", {
		required: true,
		number: true,
		messages: {
			required:'Field Nilai Harus Diisi',
			number:'Field Nilai Harus Angka'
		}
	});
}


</script>
<script>
$(document).ready(function() {
	$('#btnSimpan').click(function() {
		$('#formNilai').submit();
	});
	$('#semester li a').click(function() {
		var nis = $('#myModalLabel').attr('alt');
		var smt = $(this).attr('alt');
		//document.write(base_url+'admin/daftar_nilai/'+kelas+'/'+nis+'/'+smt);
		$('#nilaiModal').load(base_url+'admin/daftar_nilai/'+nis+'/'+smt);
	});
	
});
/*
function cek_nilai(item) {
	var nilai = $(item).val();
	alert(nilai);
	alert(typeof(nilai));
}
*/
</script>