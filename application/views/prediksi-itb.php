<!DOCTYPE html>
<html>
<head>
<title>Prediksi Kelulusan ITB</title>
</head>
<body>
	<h2>Prediksi Kelulusan ITB</h2>
	<h4>Masukkan Jumlah Nilai dan Nama Jurusan</h4>
	<form method="post" action="<?php echo base_url(); ?>sidang/tampilkan_prediksi">
	<table>
		<tr>
			<td>Jumlah Nilai</td>
			<td>:</td>
			<td><input type="number" name="jml_nilai" /></td>
		</tr>
		<tr>
			<td>Nama Jurusan</td>
			<td>:</td>
			<td>
			<select name="jur">
			<?php
			print_r($jur->result_array());
			foreach($jur->result() as $j) {
				echo '<option value="'.$j->id_jurusan_ptn.'">'.$j->nama_jurusan_ptn.'</option>';
			}
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"><td>
			<td><input type="submit" value="Tampilkan Prediksi" /></td>
		</tr>
	</table>
	</form>
</body>
</html>