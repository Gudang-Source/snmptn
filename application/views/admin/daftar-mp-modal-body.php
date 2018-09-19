<div class="panel panel-primary">
						<div class="panel-heading"><strong>Daftar Mata Pelajaran</strong></div>
						<div class="panel-body">
							<div class="table-responsive">
										<table class="table table-bordered table-hover table-striped tablesorter">
											<thead>
												<tr>
													<th width="50px" class="header">No</th>
													<th class="header">Nama Mata Pelajaran</th>
													<th class="header">Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no=1;
												foreach($mp->result() as $mp) {
												?>
												<tr>
													<td><?php echo $no; ?></td>
													<td><?php echo $mp->nama_mp; ?></td>
													<td>
														<span class="ubahMp" alt="<?php echo str_replace(' ','_',$mp->nama_mp); ?>" style="cursor:pointer"><i class="glyphicon glyphicon-pencil" title="Ubah"></i>&nbsp;</span>
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
	
	$('.ubahMp').click(function() {
		var jur = $('#jurusan .active a').attr('alt');
		var nm_mp = $(this).attr('alt');
		$('#mpModal').load(base_url+'admin/form_mp/'+jur+'/'+nm_mp);
		$('#mpModal').modal('toggle');
	});
});
</script>