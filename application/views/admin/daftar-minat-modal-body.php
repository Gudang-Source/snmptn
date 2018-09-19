<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Daftar Minat Siswa</h4>
      </div>
      <div class="modal-body">
		<button id="tambahMinat" alt="<?php echo $nis; ?>" class="btn btn-primary" style="margin-bottom:10px;">Tambah Minat</button>
		<?php
		if ($minat->num_rows()<1) {
			echo '<h3><span class="label label-warning">Maaf, Siswa ini belum memasukkan minat PTN dan Jurusan</span></h3>';
		} else {
		?>
		<div class="table-responsive">
			<table id="daftarMinat" class="table table-bordered table-hover table-striped tablesorter">
				<thead>
					<tr>
						<th class="header">Nama PTN</th>
						<th class="header">Jurusan</th>
						<th class="header">Peringkat Saat Ini</th>
						<th class="header" style="width:200px;">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$jml_minat = 0;
					foreach ($minat->result() as $m) {
					?>
					<tr>
						<td><?php echo $m->nama_ptn; ?></td>
						<td><?php echo $m->nama_jurusan_ptn; ?></td>
						<td><?php echo $m->peringkat; ?></td>
						<td>
						<div style="width:90px; float:left;">
						<?php 
						if($m->status!='terima' || $m->status=='proses') {
						?>
						<a href="<?php echo base_url().'guru/ubah_status/terima/'.$m->kd_ptn_jur.'/'.$m->nis; ?>">Diterima</a>&nbsp;&nbsp;
						<?php
						} else { echo 'Diterima&nbsp;&nbsp;';} 
						?>
						</div>
						<div style="width:90px; float:left;">
						<?php
						if($m->status!='tolak' || $m->status=='proses') {
						?>
						<a href="<?php echo base_url().'guru/ubah_status/tolak/'.$m->kd_ptn_jur.'/'.$m->nis; ?>">Ditolak</a>&nbsp;&nbsp;
						<?php
						} else { echo 'Ditolak&nbsp;&nbsp;';} 
						?>
						</div><div style="clear:both;"></div>
						<div style="width:90px; float:left;">
						<?php
						if($m->status!='undurdiri' || $m->status=='proses') {
						?>
						<a href="<?php echo base_url().'guru/ubah_status/undurdiri/'.$m->kd_ptn_jur.'/'.$m->nis; ?>">Undur Diri</a>&nbsp;&nbsp;
						<?php
						} else { echo 'Undur Diri&nbsp;&nbsp;';} 
						?>
						</div>
						<div style="width:90px; float:left;">
						<a href="<?php echo base_url().'guru/hapus_minat/'.$m->kd_ptn_jur.'/'.$m->nis; ?>">Hapus Minat</a>
						</div>
						</td>
					</tr>
					<?php
						$jml_minat++;
					}
					?>
				</tbody>
			</table>
			<span id="jml_minat" style="display:none;"><?php echo $jml_minat?></span>
		</div>
		<?php
		}
		?>
      </div>
    </div>
  </div>
  <script>
  $(document).ready(function() {
	$('#tambahMinat').click(function() {
		var nis = $(this).attr('alt');
		var jml_minat = parseInt($('#jml_minat').html());
		if (jml_minat>=2) {
			alert('Jumlah Minat tidak boleh lebih dari 2');
		} else {
			$('#minatModal').load(base_url+'admin/form_minat/'+nis);
		}
		//$('#minatModal').modal('toggle');
	});
  });
  </script>