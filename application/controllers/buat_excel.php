<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class buat_excel extends CI_Controller {
	public function index() {
		echo 'jalan';
		display_errors(1);
		/*
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		//set cell A1 content with some text
		$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		//merge cell A1 until D1
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 
		$filename='just_some_random_name.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		*/
	}
	
	/*
	public function read_excel() {
		//load our new PHPExcel library
		$this->load->library('excel');
		
		//load the excel file
		$file = './files/test.xlsx';
		
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		 
			//header will/should be in row 1 only. of course this can be modified to suit your need.
			if ($row == 1) {
				$header[$row][$column] = $data_value;
			} else {
				$arr_data[$row][$column] = $data_value;
			}
		}
		 
		//send the data in an array format
		$data['header'] = $header;
		$data['values'] = $arr_data;
		
		print_r($data['header']);
		echo '</br>';
		print_r($data['values']);
	}
	
	*/
	public function read_file() {
		//keterangan
		//$kls = $this->input->post('kelas');
		//$tahun_ajaran = $this->input->post('tahun_ajaran');
		
		$kls = '12 IPS 2';
		$tahun_ajaran = '2013';
		
		$this->db->select('id_kelas','id_kelas');
		$this->db->where('nama_kelas',$kls);
		$this->db->where('tahun_ajaran',$tahun_ajaran);
		$cek_kelas = $this->db->get('kelas');
				
		//import data
		
		//load our new PHPExcel library
		$this->load->library('excel');
		
		//load the excel file
		$file = './files/nilai2013.xlsx';
		
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		
		//custom
		$smp = array("A","B","C","D","E","F","G","H","I","Z","AA","AR","AS","BG","BH","BV","BW","CK","CL","CM","CN","CO","CP","CQ","CR","CS","CT");
		
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
		
		if ($cek_kelas->num_rows()<1) {
			$data_kelas = array(
				'nama_kelas'=>$kls,
				'tahun_ajaran'=>$tahun_ajaran,
				'id_guru'=>12,
				'id_jurusan'=>$jur
			);
			
			print_r($data_kelas);
			echo 'Menambah Data Kelas Baru<br/>';
			
			$this->db->insert('kelas',$data_kelas);
			
			$this->db->select_max('id_kelas');
			$this->db->where('nama_kelas',$kls);
			$id_kelas = $this->db->get('kelas')->row()->id_kelas;
		} else {
			$id_kelas = $cek_kelas->row()->id_kelas;
		}
		
		
		$siswaBaru = 0;
		
		for ($n=5; $n<count($nisn); $n++) {
			if(array_key_exists($n,$nisn)) {
			$inis =  $nisn[$n]['B']; 
			$inama  = $nama[$n]['C']; 
			$ikelas  = $kelas[$n]['I']; 
			if ($ikelas==$kls) {
				//echo $inis.$inama.$ikelas;
				
				$this->db->select('nis');
				$this->db->where('nis',$inis);
				$cek_siswa = $this->db->get('siswa');
				//echo $cek_siswa->num_rows();
				if($cek_siswa->num_rows()<1) {
				$data = array(
					'nis'=>$inis,
					'nama'=>$inama,
					'tahun_masuk'=>($tahun_ajaran-3),
					'id_kelas'=>$id_kelas,
				);
				
				$this->db->insert('siswa', $data);
				echo $this->db->last_query().'<br/>';
				$siswaBaru++;
				
				//print_r($data);
				$jml_siswa++;
				//echo '<br/>';
				}
				
				$daftar_kd_mp = array();
				for($m=1; $m<6; $m++) {
					$query = $this->db->query('select amp.kd_mp from mengambil_mp amp join mata_pelajaran mp ON (amp.kd_mp=mp.kd_mp) where nis='.$inis.' and semester='.$m);
					$kd_mp = array();
					foreach($query->result() as $k) {
						array_push($daftar_kd_mp, $k->kd_mp);
					}
					//array_push($daftar_kd_mp, $kd_mp);
				}
				
				//print_r($daftar_kd_mp);
				//echo count($daftar_kd_mp);
				//echo '<br/>';
				//echo '<br/>';
				
				//print_r($nilai[$n]);
				//echo count($nilai[$n]);
				//echo '<br/>';
				//echo '<br/>';
				
				
				for($i=0; $i<count($daftar_kd_mp); $i++) {
					if(array_key_exists($i, $nilai[$n])) {
						$nilai2=$nilai[$n][$i];
					} else {
						$nilai2=0;
					}
					$data = array('nilai'=>$nilai2);
					
					$this->db->where('kd_mp', $daftar_kd_mp[$i]);
					$this->db->where('nis',$inis);
					$this->db->update('mengambil_mp', $data);
					//echo $this->db->last_query();
					
					//echo '<br/>';
				}
			}
			}
		}
		
		echo 'Selesai';
		echo $jml_siswa;
		
	}
	
	public function read_file_2012() {
		$query_kd_mp = "select kd_mp, nama_mp from mata_pelajaran where semester=1 and nama_mp in ('Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Fisika', 'Biologi', 'Kimia')";
		
		//load our new PHPExcel library
		$this->load->library('excel');
		
		//load the excel file
		$file = './files/Daftar Nilai Kelas 12 IPS 2.xls';
		
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		
		//custom
		$smp = array("D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U");
		
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		 
			//header will/should be in row 1 only. of course this can be modified to suit your need.
			if ($row>=5) {
				if ($column == "A") {
					$nis[$row][$column] = $data_value;
				} else if ($column == "C") {
					$nama[$row][$column] = $data_value;
				} else if (in_array($column, $smp)) {
					if ($data_value=='') $data_value=0;
					$nilai[$row][] = $data_value;
				}
			}
		}
		 
		//send the data in an array format
		$kelas = substr($file, 27,8);
		echo $kelas;
		echo '<br />';
		
		$data = array(
			'nama_kelas'=>$kelas,
			'tahun_ajaran'=>'2012',
			'id_guru'=>12,
			'id_jurusan'=>3
		);
		
		
		$this->db->insert('kelas',$data);
		echo $this->db->last_query();
		
		echo '<br />';
		
		$this->db->select('max(id_kelas) id_kelas, id_jurusan');
		$this->db->where('nama_kelas', $kelas);
		$data_kelas=$this->db->get('kelas');
		$id_kelas = $data_kelas->row()->id_kelas;
		$id_jurusan = $data_kelas->row()->id_jurusan;
		
		$urut=427;
		
		for($n=5; $n<count($nis)+5; $n++) {
			$inis = '809111'.STR_PAD($urut,4,'0',STR_PAD_LEFT);
			$urut++;
			$inama = $nama[$n]['C'];
			
			
			echo $n.'. NIS : '.$inis.', Nama : '.$inama;
			echo '<br />';
			
			
			$data = array(
				'nis'=>$inis,
				'nama'=>$inama,
				'tahun_masuk'=>'2009',
				'id_kelas'=>$id_kelas
			);
			
			$this->db->insert('siswa', $data);
			echo $this->db->last_query().'<br/>';
			
			$daftar_kd_mp = array();
			for($m=3; $m<6; $m++) {
				$query = $this->db->query('select amp.kd_mp from mengambil_mp amp join mata_pelajaran mp ON (amp.kd_mp=mp.kd_mp) where nis='.$inis.' and semester='.$m.' and nama_mp in ("Matematika", "Bahasa Indonesia", "Bahasa Inggris", "Ekonomi", "Sosiologi", "Geografi")');
				//"Ekonomi", "Sosiologi", "Geografi"
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
		
		echo $urut;
		
		//print_r($data['nis']);
		//echo '</br>';
		//print_r($data['nama']);
		
	}
	
	public function update_nilai_kosong() {
		$data = $this->db->query('SELECT distinct m.nis FROM siswa s join mengambil_mp m on (s.nis=m.nis) WHERE nilai=0 and tahun_masuk=2011');
		
		foreach($data->result() as $nis) {
			
			$this->db->query('UPDATE mengambil_mp SET nilai=FLOOR(70 + (RAND() * 20)) WHERE nilai=0 and nis = '.$nis->nis);
			echo $this->db->last_query();
			echo '<br/>';
		}
	}
	
	public function insert_kelas() {
		for($n=1; $n<3; $n++) {
			if ($n<=3) {
				$idg=4;
			}
			$data = array(
			'nama_kelas'=>'12 IPS '.$n,
			'tahun_ajaran'=>2013,
			'id_guru'=>$idg,
			'id_jurusan'=>2
			);
			$this->db->insert('kelas', $data);
		}
	}
	
	public function update_nilai($smt, $inm_mp) {
		if ($inm_mp=='AGM') {
			$nm_mp="Agama";
		} else if ($inm_mp=='KWN') {
			$nm_mp="Kewarganegaraan";
		} else if ($inm_mp=='IND') {
			$nm_mp="Bahasa Indonesia";
		} else if ($inm_mp=='ING') {
			$nm_mp="Bahasa Inggris";
		} else if ($inm_mp=='MAT') {
			$nm_mp="Matematika";
		} else if ($inm_mp=='FIS') {
			$nm_mp="Fisika";
		} else if ($inm_mp=='KIM') {
			$nm_mp="Kimia";
		} else if ($inm_mp=='BIO') {
			$nm_mp="Biologi";
		} else if ($inm_mp=='SJR') {
			$nm_mp="Sejarah";
		} else if ($inm_mp=='GEO') {
			$nm_mp="Geografi";
		} else if ($inm_mp=='EKO') {
			$nm_mp="Ekonomi";
		} else if ($inm_mp=='SOS') {
			$nm_mp="Sosiologi";
		} else if ($inm_mp=='SNB') {
			$nm_mp="Seni dan Budaya";
		} else if ($inm_mp=='PJO') {
			$nm_mp="PJO";
		} else if ($inm_mp=='TIK') {
			$nm_mp="TIK";
		} else if ($inm_mp=='KBA') {
			$nm_mp="KBA";
		} 
		
		$this->db->select('kd_mp');
		$this->db->where('nama_mp', $nm_mp);
		$this->db->where('semester', $smt);
		$mp = $this->db->get('mata_pelajaran');
		
		return $mp->row()->kd_mp;
	}
	
	public function tambah_ptn_jurusan() {
		//load our new PHPExcel library
		$this->load->library('excel');
		
		//load the excel file
		$file = './files/daftar-lulusan.xlsx';
		
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		 
			//header will/should be in row 1 only. of course this can be modified to suit your need.
			if ($column == 'C') {
				$nama_siswa[$row][$column] = $data_value;
			} else if ($column == 'E') {
				$ptn[$row][$column] = $data_value;
			} else if ($column == 'F') {
				$prodi[$row][$column] = $data_value;
			}
		}
		 
		//send the data in an array format
		$list = array();
		for($i=39; $i<107; $i++) {
			//print_r($nama_siswa[$i]);
			//echo '</br>';
			//print_r($ptn[$i]);
			//echo '</br>';
			//print_r($prodi[$i]);
			//echo '</br>';
			
			$iptn = $ptn[$i]['E'];
			$iprodi = $prodi[$i]['F'];
			
			$this->db->select('nis');
			$this->db->where('nama', $nama_siswa[$i]['C']);
			$cnis = $this->db->get('siswa');
			$nis = $cnis->row()->nis;
			
			$this->db->from('ptn_terdiri_dari_jurusan pj');
			$this->db->join('ptn p','p.id_ptn=pj.id_ptn');
			$this->db->join('jurusan_ptn j','j.id_jurusan_ptn=pj.id_jurusan_ptn');
			$this->db->where('nama_ptn', $iptn);
			$this->db->where('nama_jurusan_ptn',$iprodi);
			$cpj = $this->db->get();
			
			$kd_ptn_jur = $cpj->row()->kd_ptn_jur;
			
			$data_pilih = array(
				'nis'=>$nis,
				'kd_ptn_jur'=>$kd_ptn_jur,
				'status'=>'terima',
				'tahun_pilih'=>2013
			);
			print_r($data_pilih);
			$this->db->insert('memilih',$data_pilih);
			echo $this->db->affected_rows();
			echo '<br/>';
			
			
			
			//$this->db->where('nama_ptn',$iptn);
			//$cptn = $this->db->get('ptn');
			//
			//$id_ptn = $cptn->row()->id_ptn;
			//$this->load->model('m_ptn');
			//
			//$tambah_jur = $this->m_ptn->ac_tambah_jurusan($id_ptn, $iprodi);
			///array_push($list, $tambah_jur);
			//
			//
			//if ($cptn->num_rows()<1) {
//				$data_ptn = array(
//					'nama_ptn' => $iptn
			//	);
			//	echo $cptn->row()->id_ptn.' : '.$cptn->row()->nama_ptn.'<br/>';
			//	$this->db->insert('ptn', $data_ptn);
			//}
			//
			//$this->db->where('nama_jurusan_ptn',$iprodi);
			//$cprodi = $this->db->get('jurusan_ptn');
			//
			//if ($cprodi->num_rows()<1) {
			//	$data_prodi = array(
			//		'nama_jurusan_ptn' => $iprodi
			//	);
			//	echo $cptn->row()->id_jurusan_ptn.' : '.$cptn->row()->nama_jurusan_ptn.'<br/>';
			//	$this->db->insert('jurusan_ptn', $data_prodi);
			//}
			//
		}
		print_r($list);
	}
	
	public function beri_peringkat_minat() {
		$this->db->select('nama_ptn, nama_jurusan_ptn');
		$this->db->from('ptn_terdiri_dari_jurusan pj');
		$this->db->join('ptn p','pj.id_ptn=p.id_ptn');
		$this->db->join('jurusan_ptn j','pj.id_jurusan_ptn=j.id_jurusan_ptn');
		$list = $this->db->get();
		
		foreach($list->result() as $l){
			$nmptn = $l->nama_ptn;
			$nmjur = $l->nama_jurusan_ptn;
			$this->db->query('call proc_beri_peringkat("'.$nmptn.'","'.$nmjur.'")');
			echo $this->db->last_query();
			echo '<br/>';
		}
	}
	
	public function baca_fungsi_lain() {
		$admin->kelas();
	}
	
	public function read_file_lulusan() {
		//load our new PHPExcel library
		$this->load->library('excel');
		
		//load the excel file
		$file = './files/daftar-lulusan.xlsx';
		
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		
		//custom
		//$smp = ["A","B","C","D","E","F","G","H","I","Z","AA","AR","AS","BG","BH","BV","BW","CK","CL","CM","CN","CO","CP","CQ","CR","CS","CT"];
		
		//extract to a PHP readable array format
		foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		 
			//header will/should be in row 1 only. of course this can be modified to suit your need.			
			
			if ($column == "C") {
				$nmsiswa[$row][$column] = $data_value;
			} else if ($column == "E") {
				$ptn[$row][$column] = $data_value;
			} else if ($column == "F") {
				$jur[$row][$column] = $data_value;
			}
		}
		
		//send the data in an array format
		$data['nm'] = $nmsiswa;
		$data['ptn'] = $ptn;
		$data['jur'] = $jur;
		echo '<br/>insert data siswa<br/>';
		
		$no = 1;
		for ($n=111; $n<171; $n++) {
			
			$inm =  $nmsiswa[$n]['C']; 
			$iptn  = $ptn[$n]['E']; 
			$ijur  = $jur[$n]['F']; 
			
			$this->db->select('nis, nama');
			$this->db->from('siswa');
			$this->db->where('lower(nama)',strtolower($inm));
			$dsiswa = $this->db->get();
			echo $this->db->last_query().'<br/>';
			
			
			foreach($dsiswa->result() as $s) {
				echo $s->nis.' - '.$s->nama.'<br/>';
				$nis = $s->nis;
				$no++;
			}
			
			$this->load->model('m_siswa');
			$this->m_siswa->tambah_minat($iptn, $ijur, $nis);
			
		}
		echo $no;
	}
	
	public function terima_minat() {
		$this->db->select('s.nis, kd_ptn_jur');
		$this->db->from('memilih m');
		$this->db->join('siswa s','m.nis=s.nis');
		$this->db->where('tahun_masuk','2007');
		$ds = $this->db->get();
		$this->load->model('m_siswa');
		$n=0;
		foreach($ds->result() as $s) {
			$this->m_siswa->ubah_minat('terima', $s->kd_ptn_jur, $s->nis);
			echo $this->db->last_query();
			$n++;
		}
		echo $n;
	}
	
	public function data_dummy() {
		$this->db->select('nama_kelas, id_guru, id_jurusan');
		$this->db->where('tahun_ajaran','2013');
		$ambil_kelas = $this->db->get('kelas');
		
		$this->db->select('nama');
		$this->db->where('tahun_masuk','2010');
		$this->db->order_by('id_kelas, nama');
		$ambil_siswa = $this->db->get('siswa');
		
		$ambil_jml_per_kelas = $this->db->query("SELECT nama_kelas, count(nis) jml FROM `siswa` s join kelas k on (s.id_kelas=k.id_kelas) WHERE tahun_masuk='2010' group by nama_kelas");
		
		$siswa = $ambil_siswa->result_array();
		
		foreach($ambil_kelas->result() as $kls) {
			$data_kelas = array(
				'nama_kelas'=>$kls->nama_kelas,
				'id_guru'=>$kls->id_guru,
				'id_jurusan'=>$kls->id_jurusan,
				'tahun_ajaran'=>'2014'
			);
			$this->db->insert('kelas',$data_kelas);
		}
		
		$nourut=0;
		
		
		$kelas_ke = 1;
		foreach($ambil_jml_per_kelas->result() as $j) {
			$nm_kelas = $j->nama_kelas;
			$jml = $j->jml;
			
			if($kelas_ke!=1) {
				$jml += $nourut;
			}
			
			$qidk = $this->db->query("SELECT max(id_kelas) id_kelas FROM kelas WHERE nama_kelas='".$nm_kelas."'");
			$idk = $qidk->row()->id_kelas;
			//echo $idk;
			
			for($n=$nourut; $n<$jml; $n++) {
				$nourut++;
				$inis = '811111'.STR_PAD($nourut,4,'0',STR_PAD_LEFT);
				$inama = $siswa[$n]['nama'];
				
				
				echo $n.'. NIS : '.$inis.', Nama : '.$inama.'<br/>';
				
				$data = array(
					'nis'=>$inis,
					'nama'=>$inama,
					'tahun_masuk'=>'2011',
					'id_kelas'=>$idk
				);
				$this->db->insert('siswa', $data);
				echo $this->db->last_query();
				echo '<br />';
			}
			$kelas_ke++;
		}
	}
	
	public function data_dummy_minat() {
		$this->db->select('nama_ptn, nama_jurusan_ptn');
		$this->db->from('ptn_terdiri_dari_jurusan pj');
		$this->db->join('ptn p','pj.id_ptn=p.id_ptn');
		$this->db->join('jurusan_ptn j','pj.id_jurusan_ptn=j.id_jurusan_ptn');
		$data_ptn = $this->db->get()->result_array();
		
		print_r($data_ptn);
		echo '<br />';
		
		
		$siswa = $this->db->query('select * from siswa where tahun_masuk="2011" order by rand() limit '.rand(20,60));
		
		$this->load->model('m_siswa');
		
		$no=1;
		foreach($siswa->result() as $s) {			
			$rand_key = array_rand($data_ptn,1);
			$ptn = $data_ptn[$rand_key];
			
			$this->m_siswa->tambah_minat($ptn['nama_ptn'], $ptn['nama_jurusan_ptn'], $s->nis);
			echo $this->db->last_query();
			$no++;
		}
		echo $no;
	}
	
	public function read_excel_pdss() {
		$kls = '12 IPA 1';
		$tahun_ajaran = '2014';
		$semester = '4';
		$id_guru = '1';
		
		$this->db->select('id_kelas','id_kelas');
		$this->db->where('nama_kelas',$kls);
		$this->db->where('tahun_ajaran',$tahun_ajaran);
		$cek_kelas = $this->db->get('kelas');
				
		//import data
		
		//load our new PHPExcel library
		$this->load->library('excel');
		
		//load the excel file
		$file = './files/tmp/nilai_siswa_kelas_12_IPA_1_TA_2014_semester_4.xls';
		
		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		
		//get only the Cell Collection
		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
		
		//custom
		$smp = array("D","E","F","G","H","I","J","K","L","M","N","O","P");
		
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
			} else if (in_array($column, $smp)) {
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
		
		if ($cek_kelas->num_rows()<1) {
			$data_kelas = array(
				'nama_kelas'=>$kls,
				'tahun_ajaran'=>$tahun_ajaran,
				'id_guru'=>$id_guru,
				'id_jurusan'=>$jur
			);
			
			if($this->db->insert('kelas',$data_kelas)) {
				print_r($data_kelas);
				echo 'Menambah Data Kelas Baru<br/>';
			}
			
			$this->db->select_max('id_kelas');
			$this->db->where('nama_kelas',$kls);
			$id_kelas = $this->db->get('kelas')->row()->id_kelas;
		} else {
			$id_kelas = $cek_kelas->row()->id_kelas;
		}
		
		$siswaBaru = 0;
		
		
		//echo '<pre>';
		//print_r($nisn);
		//echo '</pre>';
		//echo '<br/>';
		
		
		for ($n=5; $n<(count($nisn)+2); $n++) {
			$this->db->where('nis',$nisn[$n]['B']);
			$cek_siswa = $this->db->get('siswa');
			
			if ($cek_siswa->num_rows()>0) {
				$data_siswa = array(
					'nis' => $cek_siswa->row()->nis,
					'nama' => $cek_siswa->row()->nama,
					'tahun_masuk' => ($tahun_ajaran-3),
					'id_kelas' => $id_kelas
				);
			} else {
				$data_siswa = array(
					'nis' => $nisn[$n]['B'],
					'nama' => $nama[$n]['C'],
					'tahun_masuk' => ($tahun_ajaran-3),
					'id_kelas' => $id_kelas
				);
				if($this->db->insert('siswa',$data_siswa)) {
					echo 'Berhasil Tambah Siswa Baru<br />';
				} else {
					echo 'Berhasil Tambah Siswa Baru<br />';
				}
			}
			
			echo '<pre>';
			print_r($data_siswa);
			echo '</pre>';
			
			//ambil daftar mp
			$daftar_mp = $this->db->query('select mp.kd_mp, nama_mp from mengambil_mp amp join mata_pelajaran mp on (amp.kd_mp=mp.kd_mp) where semester="'.$semester.'" and nis="'.$data_siswa['nis'].'"');
			
			echo '<pre>';
			print_r($daftar_mp->result_array());
			echo '</pre>';
			echo '<pre>';
			print_r($nilai[$n]);
			echo '</pre>';
			
			$index_mp = 0;
			foreach($daftar_mp->result() as $mp) {
				$data_nilai = array('nilai'=>$nilai[$n][$index_mp]);
				$this->db->where('nis',$data_siswa['nis']);
				$this->db->where('kd_mp',$mp->kd_mp);
				if ($this->db->update('mengambil_mp',$data_nilai)) {
					echo 'Berhasil Tambah Nilai<br/>';
				} else {
					echo 'Gagal Tambah Nilai<br/>';
				}
				$index_mp++;
			}
			
			echo '=============================================================================';
		}
		
		$this->db->query("call proc_tambah_na_siswa(".($tahun_ajaran-3).")") or die( mysql_error());
	}
	
}
/*end of file */