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
										foreach($dft_ptn->result() as $p) {
										?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $p->nama_ptn; ?></td>
											<td>
												<span style="cursor:pointer;" class="dftJur" alt="<?php echo $p->id_ptn; ?>"><i class="glyphicon glyphicon-list" title="Daftar Jurusan"></i>&nbsp;</span>
												<span style="cursor:pointer;" class="ubahPtn" alt="<?php echo $p->id_ptn; ?>"><i class="glyphicon glyphicon-pencil" title="Ubah"></i>&nbsp;</span>
												<span style="cursor:pointer;" class="hapusPtn" alt="<?php echo $p->id_ptn; ?>"><i class="glyphicon glyphicon-remove" title="Hapus"></i></span>
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
	$('.ubahPtn').click(function() {
		var id_ptn = $(this).attr('alt');
		$('#ptnModal').load(base_url+'admin/form_ptn/'+id_ptn);
		$('#ptnModal').modal('toggle');
	});
	
	$('.hapusPtn').click(function() {
		var id_ptn = $(this).attr('alt');
		$('#ptnModal').load(base_url+'ptn/hapus_ptn/'+id_ptn);
	});
	
	$('.dftJur').click(function() {
		var id_ptn = $(this).attr('alt');
		$('#ptnModal').load(base_url+'admin/daftar_jurusan/'+id_ptn);
		$('#ptnModal').modal('toggle');
	});
});
</script>