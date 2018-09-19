<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Daftar Jurusan Pada </h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-lg-6" style="margin-bottom:10px;">
				<button id="tambahJur" alt="<?php if(isset($id_ptn)) echo $id_ptn; ?>" class="btn btn-primary">Tambah Jurusan</button>
			</div>
		</div>
		<div class="row">
			<?php
			if ($dft_jurusan->num_rows()<1) {
			echo '<h3><span class="label label-warning">Maaf, PTN ini belum memiliki Jurusan</span></h3>';
			echo '<h4><span class="label label-warning">Silahkan Tambah Jurusan terlebih dahulu</span></h4>';
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
						foreach($dft_jurusan->result() as $jur) {
						?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><a href="#"><?php echo $jur->nama_jurusan_ptn; ?></a></td>
							<td>
								<!--<span style="cursor:pointer;" class="ubahJur" alt="<?php echo $jur->kd_ptn_jur; ?>"><i class="glyphicon glyphicon-pencil" title="Ubah"></i>&nbsp;</span>-->
								<span style="cursor:pointer;" class="hapusJur" alt="<?php echo $jur->kd_ptn_jur; ?>"><i class="glyphicon glyphicon-remove" title="Hapus"></i></span>
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
	$('#tambahJur').click(function() {
		var id_ptn = $(this).attr('alt');
		$('#ptnModal').load(base_url+'admin/form_jurusan/'+id_ptn);
	});
	
	$('.hapusJur').click(function() {
			var id_ptn = $('#tambahJur').attr('alt');
			var kd_ptn_jur = $(this).attr('alt');
			
			$.ajax({
				url: base_url+'ptn/hapus_jurusan_di_ptn/'+kd_ptn_jur,
				success:function(msg) {
					$('#ptnModal .modal-dialog .modal-content .modal-body').append(msg);
					
					if (msg.indexOf('Berhasil')>0) {
					var kembali=setTimeout(function() {
								$('#ptnModal').load(base_url+'admin/daftar_jurusan/'+id_ptn);
							},2000);
					}
				}
			});
		});
});
</script>