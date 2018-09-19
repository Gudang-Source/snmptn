<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {
	public function form_upload() {
		$data['title'] = 'Admin - Import Data Siswa';
		$this->load->view('admin/form_import_data',$data);
	}
	
	public function ac_upload() {
		//keterangan
		$kls = $this->input->post('kelas');
		$tahun_ajaran = $this->input->post('tahun_ajaran');
		
		//Upload file
		$file = $_FILES['files'];
		$tmp = explode('.',$file['name']);
		$ext = end($tmp);
		$filename = 'nilai_siswa_tahun_ajaran_'.$tahun_ajaran.'.'.$ext;
		
		if (!file_exists($filename)) {
		$config['upload_path'] = './files/tmp/';
		$config['allowed_types'] = 'xls|xlsx';
		$config['max_size']	= '2048';
		$config['file_name']	= $filename;
		$config['overwrite']	= TRUE;
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('files'))
		{
			$error = array('error' => $this->upload->display_errors());

			print_r($error);
			//$this->load->view('upload', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			
			print_r($data);
			//$this->load->view('upload_success', $data);
		}
		}
		//import data
		
		//load our new PHPExcel library
		$this->load->library('excel');
		
		//load the excel file
		$file = './files/tmp/'.$filename;
		
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		
		//custom
		$smp = ["A","B","C","D","E","F","G","H","I","Z","AA","AR","AS","BG","BH","BV","BW","CK","CL","CM","CN","CO","CP","CQ","CR","CS","CT"];
		
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		 
			//header will/should be in row 1 only. of course this can be modified to suit your need.			
			
			if ($column == "B") {
				$nisn[$row][$column] = $data_value;
			} else if ($column == "C") {
				$nama[$row][$column] = $data_value;
			} else if ($column == "I") {
				$kelas[$row][$column] = $data_value;
			} else if ($row==4) {
				$nm_mp[$column] = $data_value;
			} else if (!in_array($column, $smp)) {
				if ($data_value=='') $data_value=0;
				$nilai[$row][] = $data_value;
			}
		}
		
		//send the data in an array format
		$data['nisn'] = $nisn;
		$data['nama'] = $nama;
		$jml_siswa = 0;
		
		if(strtolower(substr($kls,3,3))=='ipa') {
			$jur=2;
		} else if (strtolower(substr($kls,3,3))=='ips') {
			$jur=3;
		} else {
			die('Kesalahan pada nama kelas');
		}
		
		$data_kelas = array(
			'nama_kelas'=>$kls,
			'tahun_ajaran'=>$tahun_ajaran,
			'id_guru'=>$this->session->userdata('id'),
			'id_jurusan'=>$jur
		);
		
		print_r($data_kelas);
		
		$this->db->insert('kelas',$data_kelas);
		
		$this->db->select_max('id_kelas','id_kelas');
		$this->db->where('nama_kelas',$kls);
		$id_kelas = $this->db->get('kelas')->row()->id_kelas;
		
		for ($n=5; $n<count($nisn); $n++) {
			if(array_key_exists($n,$nisn)) {
			$inis =  $nisn[$n]['B']; 
			$inama  = $nama[$n]['C']; 
			$ikelas  = $kelas[$n]['I']; 
			if ($ikelas==$kls) {
				//echo $inis.$inama.$ikelas;
				 
				
				$data = array(
					'nis'=>$inis,
					'nama'=>$inama,
					'tahun_masuk'=>($tahun_ajaran-3),
					'id_kelas'=>$id_kelas,
				);
				$jml_siswa++;
				
				$this->db->insert('siswa', $data);
				echo $this->db->last_query().'<br/>';
				
				print_r($data);
				echo '<br/>';
				
				$daftar_kd_mp = array();
				for($m=1; $m<6; $m++) {
					$query = $this->db->query('select amp.kd_mp from mengambil_mp amp join mata_pelajaran mp ON (amp.kd_mp=mp.kd_mp) where nis='.$inis.' and semester='.$m);
					$kd_mp = array();
					foreach($query->result() as $k) {
						array_push($daftar_kd_mp, $k->kd_mp);
					}
					//array_push($daftar_kd_mp, $kd_mp);
				}
				
				print_r($daftar_kd_mp);
				echo count($daftar_kd_mp);
				echo '<br/>';
				echo '<br/>';
				
				print_r($nilai[$n]);
				echo count($nilai[$n]);
				echo '<br/>';
				echo '<br/>';
				
				
				for($i=0; $i<count($daftar_kd_mp); $i++) {
					$data = array('nilai'=>$nilai[$n][$i]);
					
					$this->db->where('kd_mp', $daftar_kd_mp[$i]);
					$this->db->where('nis',$inis);
					$this->db->update('mengambil_mp', $data);
					echo $this->db->last_query();
					
					echo '<br/>';
				}
			}
			}
		}
		
		echo 'Selesai';
		echo $jml_siswa;
	}

	public function tabel_mendatar ($id_kelas) {
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Daftar Nilai Siswa');
		
		$nilai = $this->db->query('SELECT amp.nis, nama, kd_mp, nilai, substr(kd_mp, 5, 1 ) as smt FROM (siswa s) JOIN mengambil_mp amp ON s.nis=amp.nis WHERE id_kelas = "'.$id_kelas.'" ORDER BY nama,smt,kd_mp');
		
		//$this->to_excel($nilai,'daftar_nilai_siswa_kelas_'.$id_kelas);
		
		$nis_sblm = '';
		$html = '<html><body><table style="width:5120px;">';
		$html .= '<tr>
			<td style="width:150px;">NIS</td>
			<td style="width:250px;">Nama Siswa</td>';
		$mp = $this->db->query("select amp.kd_mp, nama_mp from siswa s join mengambil_mp amp on (s.nis=amp.nis) join mata_pelajaran mp on (amp.kd_mp=mp.kd_mp) where id_kelas='".$id_kelas."' group by amp.kd_mp order by substr(amp.kd_mp,5,1),amp.kd_mp");
		
		foreach($mp->result() as $m) {
			$html .= '<td>'.$m->kd_mp.' - '.$m->nama_mp.'</td>';
		}
		$html .= '</tr>';
		
		foreach($nilai->result() as $n) {
			if($nis_sblm!=$n->nis) {
				if($nis_sblm!='') {
					$html .= '</tr>';
				}
				$html .= '<tr><td>'.$n->nis.'</td><td>'.$n->nama.'</td>';
			}
			$html .= '<td>'.$n->nilai.'</td>';
			$nis_sblm = $n->nis;
		}
		$html .= '</table></body></html>';
		
		//echo $html;
		
		// Put the html into a temporary file
		$tmpfile = time().'.html';
		$file = fopen($tmpfile,"w");
		fwrite($file,$html);
		fclose($file);
		
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		
		$filename='daftar_nilai_siswa_kelas.xlsx'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		// Read the contents of the file into PHPExcel Reader class
		$reader = new PHPExcel_Reader_HTML; 
		$content = $reader->load($tmpfile); 

		// Pass to writer and output as needed
		$objWriter = PHPExcel_IOFactory::createWriter($content, 'Excel2007');
		$objWriter->save('php://output');

		// Delete temporary file
		unlink($tmpfile) or die('cannot delete file');
		
	}
	
	public function test_sql() {
		$thn = $this->db->query("SELECT DISTINCT tahun_pilih FROM memilih order by tahun_pilih");
		$column = '';
		$tbl_jml_thn = '';
		$no=1;
		foreach($thn->result() as $t) {
			$column .= ", ifnull(thn".$no.".".$t->tahun_pilih.",0) as '".$t->tahun_pilih."'";
			if ($no!=1) $tbl_jml_thn .= ' left join ';
			$tbl_jml_thn .= "(select kd_ptn_jur, count(nis) as '".$t->tahun_pilih."' from memilih where tahun_pilih='".$t->tahun_pilih."' and status='terima' group by kd_ptn_jur) thn".$no." on (pj.kd_ptn_jur=thn".$no.".kd_ptn_jur)";
			$no++;
		}
		
		$query = 'select pj.kd_ptn_jur, nama_ptn, nama_jurusan_ptn '.$column.'from ptn_terdiri_dari_jurusan pj left join '.$tbl_jml_thn.' join ptn p on (pj.id_ptn=p.id_ptn) join jurusan_ptn j on (pj.id_jurusan_ptn=j.id_jurusan_ptn)';
		$hasil = $this->db->query($query);
		
		//$this->to_excel($hasil,'daftar_perkembangan_kelulusan');
		
		
		$html = '<html><body><table border="1">';
		$html .= '<tr>
			<td>Kode PTN Jurusan</td>
			<td>Nama PTN</td>
			<td>Nama Jurusan</td>';
		foreach($thn->result() as $t) {
			$html .= '<td>'.$t->tahun_pilih.'</td>';
		}
		$html .= '</tr>';
		foreach($hasil->result_array() as $dft_jml) {
			$html .= '<tr>
				<td>'.$dft_jml['kd_ptn_jur'].'</td>
				<td>'.$dft_jml['nama_ptn'].'</td>
				<td>'.$dft_jml['nama_jurusan_ptn'].'</td>';
				foreach($thn->result() as $t) {
					$thn_pilih = $t->tahun_pilih;
					$html .= '<td>'.$dft_jml[$thn_pilih].'</td>';
				}
			$html .= '</tr>';
		}
		$html .= '</table></body></html>';
		
		//echo $html;
		
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Daftar Jumlah Kelulusan Siswa');
		
		// Put the html into a temporary file
		$tmpfile = time().'.html';
		$file = fopen($tmpfile,"w");
		fwrite($file,$html);
		fclose($file);
		
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		
		$filename='daftar_perkembangan_kelulusan.xlsx'; //save our workbook as this file name
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		// Read the contents of the file into PHPExcel Reader class
		$reader = new PHPExcel_Reader_HTML; 
		$content = $reader->load($tmpfile); 

		// Pass to writer and output as needed
		$objWriter = PHPExcel_IOFactory::createWriter($content, 'Excel2007');
		$objWriter->save('php://output');

		// Delete temporary file
		unlink($tmpfile) or die('cannot delete file');
		
	}
	
	function export() {
		$this->db->select('kd_mp, nama_mp');
		$this->db->order_by('kd_mp','asc');
		$query = $this->db->get('mata_pelajaran');
		$this->to_excel($query,'daftar_mata_pelajaran');
	}
	
	function to_excel($array, $filename) {
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename='.$filename.'.xls');

		$h = array();
		foreach($array->result_array() as $row){
		   foreach($row as $key=>$val){
			   if(!in_array($key, $h)){
				$h[] = $key; 
			   }
		   }
		}
		//echo the entire table headers
		echo '<table><tr>';
		foreach($h as $key) {
		   $key = ucwords($key);
		   echo '<th>'.$key.'</th>';
		}
		echo '</tr>';

		foreach($array->result_array() as $row){
			echo '<tr>';
		   foreach($row as $val)
				$this->writeRow($val); 
		}
		echo '</tr>';
		echo '</table>';
	}

	function writeRow($val) {
		echo '<td>'.utf8_decode($val).'</td>';             
	}
	
	function manual_excel_exp($id) {
		
		$this->load->library('excel');//Panggil Library Excel
		
		$style_num = array('font' =>
                                    array('color' =>
                                      array('rgb' => '000000'),
                                      'bold' => false,
                                    ),
                           'alignment' => array(
                                            'wrap'       => true,
                                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                        ),
                     );

		$this->excel->getActiveSheet()->setTitle('Daftar Nilai Siswa');
				
		$mp = $this->db->query("select amp.kd_mp, nama_mp from siswa s join mengambil_mp amp on (s.nis=amp.nis) join mata_pelajaran mp on (amp.kd_mp=mp.kd_mp) where id_kelas='".$id."' group by amp.kd_mp order by substr(amp.kd_mp,5,1),amp.kd_mp");
		
		$this->db->where('id_kelas',$id);
		$kls = $this->db->get('kelas');
		
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(26);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(26);
		
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 2, 'Nama Kelas : ');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, $kls->row()->nama_kelas);
		$this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, 'Tahun Ajaran : ');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, $kls->row()->tahun_ajaran);
		$this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		$index_smt = array();
		
		$row_header = 5;
		$row=$row_header+1;;
		$col=2;
		
		
		$this->excel->getDefaultStyle()
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
	
		// daftar header
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row_header, 'NIS');
		$this->excel->setActiveSheetIndex(0)->mergeCellsByColumnAndRow(0,$row_header,0,$row_header+1);
		$this->excel->getActiveSheet()->getStyle('A'.$row_header)->applyFromArray($style_num);
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row_header, 'Nama Siswa');
		$this->excel->setActiveSheetIndex(0)->mergeCellsByColumnAndRow(1,$row_header,1,$row_header+1);
		$this->excel->getActiveSheet()->getStyle('B'.$row_header)->applyFromArray($style_num);
		

		foreach($mp->result_array() as $m) {
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $m['nama_mp']);
			if($m['nama_mp']=='Agama') {
				$index_smt[] = $col;
			}
			$col++;
		}
		
		$last_col = $col;
		
		array_push($index_smt, $last_col);
		$merge_cell = array();
		
		for($n=0; $n<count($index_smt)-1; $n++) {
			$fromCol = $index_smt[$n];
			$toCol = $index_smt[$n+1]-1;
			$cell = array('from'=>$fromCol,'to'=>$toCol);
			array_push($merge_cell, $cell);
		}
		
		$smt=1;
		foreach($merge_cell as $mg) {
			$this->excel->setActiveSheetIndex(0)->mergeCellsByColumnAndRow($mg['from'],$row_header,$mg['to'],$row_header);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($mg['from'], $row_header, 'Semester '.$smt);
			//$this->excel->getActiveSheet()->getStyle($mg['from'].$row_header)->applyFromArray($style_num);
			$smt++;
		}
		
		//daftar nilai
		$nilai = $this->db->query('SELECT amp.nis, nama, kd_mp, nilai, substr(kd_mp, 5, 1 ) as smt FROM (siswa s) JOIN mengambil_mp amp ON s.nis=amp.nis WHERE id_kelas = "'.$id.'" ORDER BY nama,smt,kd_mp');
		
		$nis_sblm='';
		$smt_sbl='';
		$mrg = 1;
		foreach($nilai->result_array() as $row_data) {
			if($nis_sblm!=$row_data['nis']) {
				$col = 0;
				$row++;
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_data['nis']);
				$this->excel->getActiveSheet()->getStyleByColumnAndRow($col,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$col++;
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_data['nama']);
				$this->excel->getActiveSheet()->getStyleByColumnAndRow($col,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				$col++;
			}
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $row_data['nilai']);
			$col++;
			$nis_sblm = $row_data['nis'];
		}

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		
		
		
		
		$file_name = 'data_nilai_kelas_'.$kls->row()->nama_kelas.'_TA_'.$kls->row()->tahun_ajaran;
		//$objWriter->save(FCPATH."files/".$file_name.".xlsx");    //Simpan file ke server
		
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter->save('php://output');
	}
	
	public function manual_excel_exp2($thn_dari=null, $thn_sampai=null) {
		$this->load->library('excel');//Panggil Library Excel

		$this->excel->getActiveSheet()->setTitle('Daftar Nilai Siswa');
		
		// daftar header
		
		//daftar kelulusan
		//jika ada tahun_pilih
		if (isset($thn_dari) && isset($thn_sampai)) {
			$thn_pil = ' WHERE tahun_pilih>='.$thn_dari.' AND tahun_pilih<='.$thn_sampai;
		}
		
		if(!isset($thn_pil)) {
			$thn_pil='';
		}
		
		$thn = $this->db->query("SELECT DISTINCT tahun_pilih FROM memilih".$thn_pil." order by tahun_pilih");
		$column = '';
		$tbl_jml_thn = '';
		$no=1;
		foreach($thn->result() as $t) {
			$column .= ", ifnull(thn".$no.".".$t->tahun_pilih.",0) as '".$t->tahun_pilih."'";
			if ($no!=1) $tbl_jml_thn .= ' left join ';
			$tbl_jml_thn .= "(select kd_ptn_jur, count(nis) as '".$t->tahun_pilih."' from memilih where tahun_pilih='".$t->tahun_pilih."' and status='terima' group by kd_ptn_jur) thn".$no." on (pj.kd_ptn_jur=thn".$no.".kd_ptn_jur)";
			$no++;
		}
		
		$query = 'select pj.kd_ptn_jur, nama_ptn, nama_jurusan_ptn '.$column.'from ptn_terdiri_dari_jurusan pj left join '.$tbl_jml_thn.' join ptn p on (pj.id_ptn=p.id_ptn) join jurusan_ptn j on (pj.id_jurusan_ptn=j.id_jurusan_ptn)';
		$hasil = $this->db->query($query);
		
		//$this->to_excel($hasil,'daftar_perkembangan_kelulusan');
		$row=1;
		$col=0;
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Kode PTN Jurusan');
		$col++;
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Nama PTN');
		$col++;
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Nama Jurusan');
		$col++;
		foreach($thn->result() as $t) {
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $t->tahun_pilih);
			$col++;
		}
		$row++;
		
		foreach($hasil->result_array() as $dft_jml) {
			$col=0;
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dft_jml['kd_ptn_jur']);
			$col++;
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dft_jml['nama_ptn']);
			$col++;
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dft_jml['nama_jurusan_ptn']);
			$col++;
			foreach($thn->result() as $t) {
				$thn_pilih = $t->tahun_pilih;
				$this->excel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $dft_jml[$thn_pilih]);
				$col++;
			}
			$row++;
		}
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		
		$file_name = 'pekembangan_kelulusan_siswa';
		if (isset($thn_dari) && isset($thn_sampai)) {
			$file_name .= '_dari_'.$thn_dari.'_sampai_'.$thn_sampai;
		}
		
		//$objWriter->save(FCPATH."files/".$file_name.".xlsx");    //Simpan file ke server
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output'); 
		
	}
	
	function base_path() {
		echo FCPATH;
	}
}