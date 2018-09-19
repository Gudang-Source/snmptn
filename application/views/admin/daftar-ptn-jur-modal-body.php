<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Daftar PTN Pada </h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-lg-6" style="margin-bottom:10px;">
				<button id="tambahPtn" alt="<?php if(isset($id_jur)) echo $id_jur; ?>" class="btn btn-primary">Tambah PTN</button>
			</div>
		</div>
		<div class="row">
			<?php
			if ($dft_ptn->num_rows()<1) {
			echo '<h3><span class="label label-warning">Maaf, Jurusan ini belum Termasuk PTN Manapun</span></h3>';
			echo '<h4><span class="label label-warning">Silahkan Tambah PTN terlebih dahulu</span></h4>';
			} else {
			?>
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped tablesorter">
					<thead>
						<tr>
							<th class="header">No</th>
							<th class="header">Nama Jurusan</th>
							<th class="header">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no=1;
						foreach($dft_ptn->result() as $ptn) {
						?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><a href="#"><?php echo $ptn->nama_ptn; ?></a></td>
							<td>
								<!--<span style="cursor:pointer;" class="ubahJur" alt="<?php echo $ptn->kd_ptn_jur; ?>"><i class="glyphicon glyphicon-pencil" title="Ubah"></i>&nbsp;</span>-->
								<span style="cursor:pointer;" class="hapusPtn" alt="<?php echo $ptn->kd_ptn_jur; ?>"><i class="glyphicon glyphicon-remove" title="Hapus"></i></span>
							</td>
						</tr>
						<?php
						$no++;
						}
						?>
					</tbody>
				</table>

			</div>
			<?php 
			}
			?>
		</div>
      </div>
    </div>
  </div>
<script>
$(document).ready(function() {
	$('#tambahPtn').click(function() {
		var id_jur = $(this).attr('alt');
		$('#jurModal').load(base_url+'admin/form_ptn_jur/'+id_jur);
	});
	
	$('.hapusPtn').click(function() {
			var id_jur = $('#tambahJur').attr('alt');
			var kd_ptn_jur = $(this).attr('alt');
			
			$.ajax({
				url: base_url+'ptn/hapus_ptn_dgn_jur/'+kd_ptn_jur,
				success:function(msg) {
					$('#ptnModal .modal-dialog .modal-content .modal-body').append(msg);
					
					if (msg.indexOf('Berhasil')>0) {
					var kembali=setTimeout(function() {
								$('#jurModal').load(base_url+'admin/daftar_ptn_jur/'+id_jur);
							},1500);
					}
				}
			});
		});
});
</script>