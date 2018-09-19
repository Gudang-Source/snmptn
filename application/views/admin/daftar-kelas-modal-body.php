<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Daftar Kelas Yang Dikelola</h4>
      </div>
      <div class="modal-body">
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped tablesorter">
				<thead>
					<tr>
						<th class="header">Nama Kelas</th>
						<th class="header">Jumlah Siswa</th>
						<th class="header">Jurusan</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($dft_kelas->result() as $k) {
					?>
					<tr>
						<td><a href="<?php echo base_url(); ?>admin/siswa/<?php echo $k->id_kelas; ?>"><?php echo $k->nama_kelas; ?></a></td>
						<td><?php echo $k->jml_siswa; ?></td>
						<td><?php echo $k->nama_jurusan; ?></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>

		</div>
      </div>
    </div>
  </div>