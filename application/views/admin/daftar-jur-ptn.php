<div class="panel panel-primary">
						<div class="panel-heading">Daftar Perguruan Tinggi Negeri</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped tablesorter">
									<thead>
										<tr>
											<th class="header">No</th>
											<th class="header">Nama PTN</th>
											<th class="header">Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no=1;
										foreach($dft_jur->result() as $j) {
										?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $j->nama_jurusan_ptn; ?></td>
											<td>
												<span style="cursor:pointer;" class="dftPtn" alt="<?php echo $j->id_jurusan_ptn; ?>"><i class="glyphicon glyphicon-list" title="Daftar Jurusan"></i>&nbsp;</span>
												<span style="cursor:pointer;" class="ubahJur" alt="<?php echo $j->id_jurusan_ptn; ?>"><i class="glyphicon glyphicon-pencil" title="Ubah"></i>&nbsp;</span>
												<span style="cursor:pointer;" class="hapusJur" alt="<?php echo $j->id_jurusan_ptn; ?>"><i class="glyphicon glyphicon-remove" title="Hapus"></i></span>
											</td>
										</tr>
										<?php
										$no++;
										}
										?>
									</tbody>
								</table>

							</div>
						</div>
					</div>
<script>
$(document).ready(function() {
	$('.ubahJur').click(function() {
		var id_jur_ptn = $(this).attr('alt');
		$('#jurModal').load(base_url+'admin/form_jur_ptn/'+id_jur_ptn);
		$('#jurModal').modal('toggle');
	});
	
	$('.hapusJur').click(function() {
		var id_jur_ptn = $(this).attr('alt');
		$('#jurModal').load(base_url+'ptn/hapus_jur_ptn/'+id_jur_ptn);
	});
	
	$('.dftPtn').click(function() {
		var id_jur = $(this).attr('alt');
		$('#jurModal').load(base_url+'admin/daftar_ptn_jur/'+id_jur);
		$('#jurModal').modal('toggle');
	});
});
</script>