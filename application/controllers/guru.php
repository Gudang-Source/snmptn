<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guru extends CI_Controller {

	public function index()	{
		redirect('admin/profil_guru');
	}
	
	public function ubah_guru() {
		$this->load->model('m_guru');
		$id = $this->input->post('id');
		if($this->input->post('password')!='') {
			$data = array(
				'nip' => $this->input->post('nip'),
				'nama' => $this->input->post('nama_guru'),
				'password' => md5($this->input->post('password'))
			);
		} else {
			$data = array(
				'nip' => $this->input->post('nip'),
				'nama' => $this->input->post('nama_guru'),
			);
		}
		
		$ubah = $this->m_guru->ac_ubah_guru($data, $id);
		if ($ubah>0) {
			$pesan = 'Berhasil Ubah Profil';
			$status = 'success';
		} else {
			$pesan = 'Gagal Ubah Profil';
			$status = 'danger';
		}
		
		$this->session->set_flashdata('status', '<div class="alert alert-'.$status.'">'.$pesan.'</div>');
		redirect('admin/profil_guru');
	}
	
	public function hapus_guru($id_guru) {
		$this->load->model('m_guru');
		$hapus = $this->m_guru->ac_hapus_guru($id_guru);
		if ($hapus>0) {
			echo 'Berhasil Hapus Data Guru';
		} else {
			echo 'Gagal Hapus Data Guru';
		}
	}
	
	public function tambah_catatan() {
		$thn = $this->input->post('thn');
		$ket = $this->input->post('ket');
		
		$data = array(
			'tahun'=>$thn,
			'hasil_evaluasi'=>$ket
		);
		$this->load->model('m_guru');
		$tambah = $this->m_guru->ac_tambah_evaluasi($data);
		
		if ($tambah>0) {
			$pesan = 'Berhasil Tambah Catatan';
			$status = 'success';
		} else {
			$pesan = 'Gagal Tambah Catatan';
			$status = 'danger';
		}
		
		$this->session->set_flashdata('status', '<div style="margin-top:15px;" class="alert alert-'.$status.'">'.$pesan.'</div>');
		redirect('admin');
	}
	
	public function ubah_catatan($id) {
		$thn = $this->input->post('thn');
		$ket = $this->input->post('ket');
		
		$data = array(
			'tahun'=>$thn,
			'hasil_evaluasi'=>$ket
		);
		$this->load->model('m_guru');
		$ubah = $this->m_guru->ac_ubah_evaluasi($id, $data);
		
		if ($ubah>0) {
			$pesan = 'Berhasil Ubah Catatan';
			$status = 'success';
		} else {
			$pesan = 'Gagal Ubah Catatan';
			$status = 'danger';
		}
		
		$this->session->set_flashdata('status', '<div style="margin-top:15px;" class="alert alert-'.$status.'">'.$pesan.'</div>');
		redirect('admin');
	}
	
	public function hapus_catatan($id) {
		$this->load->model('m_guru');
		$hapus = $this->m_guru->ac_hapus_evaluasi($id);
		
		if ($hapus>0) {
			$pesan = 'Berhasil Hapus Catatan';
			$status = 'success';
		} else {
			$pesan = 'Gagal Hapus Catatan';
			$status = 'danger';
		}
		
		$this->session->set_flashdata('status', '<div style="margin-top:15px;" class="alert alert-'.$status.'">'.$pesan.'</div>');
	}
	
	public function tambah_kelas() {
		$data = array(
			'nama_kelas' => $this->input->post('nama_kelas'),
			'id_jurusan' => $this->input->post('jurusan'),
			'tahun_ajaran' => $this->input->post('tahun_ajaran'),
			'id_guru' => $this->session->userdata('id')
		);
		
		$this->load->model('m_kelas');
		$tambah = $this->m_kelas->ac_tambah_kelas($data);
		
		if ($tambah>0) {
			$pesan = 'Berhasil Tambah Kelas';
			$status = 'success';
		} else {
			$pesan = 'Gagal Tambah Kelas';
			$status = 'danger';
		}
		
		$this->session->set_flashdata('status', '<div class="alert alert-'.$status.'">'.$pesan.'</div>');
		redirect('admin/kelas');
	}
	
	public function ubah_kelas() {
		$id_kelas = $this->input->post('id_kelas');
		$data = array(
			'nama_kelas' => $this->input->post('nama_kelas'),
			'id_jurusan' => $this->input->post('jurusan'),
			'tahun_ajaran' => $this->input->post('tahun_ajaran'),
			'id_guru' => $this->session->userdata('id')
		);
		
		$this->load->model('m_kelas');
		$tambah = $this->m_kelas->ac_ubah_kelas($data, $id_kelas);
		
		echo $this->db->last_query();
		
		if ($tambah>0) {
			$pesan = 'Berhasil Ubah Kelas';
			$status = 'success';
		} else {
			$pesan = 'Gagal Ubah Kelas';
			$status = 'danger';
		}
		
		$this->session->set_flashdata('status', '<div class="alert alert-'.$status.'">'.$pesan.'</div>');
		redirect('admin/kelas');
	}
	
	public function hapus_kelas($id_kelas) {
		$this->load->model('m_kelas');
		$hapus = $this->m_kelas->ac_hapus_kelas($id_kelas);
		if ($hapus>0) {
			$pesan = 'Berhasil Hapus Data Kelas';
			$status = 'success';
		} else {
			$pesan = 'Gagal Hapus Data Kelas';
			$status = 'danger';
		}
		
		$this->session->set_flashdata('status', '<div class="alert alert-'.$status.'">'.$pesan.'</div>');
	}
	
	public function tambah_siswa() {
				
		$data = array(
			'nis' => $this->input->post('nis'),
			'nama' => $this->input->post('nama'),
			'tahun_masuk' => $this->input->post('tahun_masuk'),
			'id_kelas' => $this->input->post('id_kelas'),
		);
		
		$this->load->model('m_siswa');
		$tambah = $this->m_siswa->ac_tambah_siswa($data);
		
		if ($tambah>0) {
			$pesan = 'Berhasil Tambah Siswa';
			$status = 'success';
		} else {
			$pesan = 'Gagal Tambah Siswa';
			$status = 'danger';
		}
		
		$this->session->set_flashdata('status', '<div class="alert alert-'.$status.'">'.$pesan.'</div>');
		redirect('admin/siswa/'.$data['id_kelas']);
	}
	
	public function hapus_siswa($nis) {
		$this->load->model('m_siswa');
		$hapus = $this->m_siswa->ac_hapus_siswa($nis);
		if ($hapus>0) {
			$pesan = 'Berhasil Hapus Data Siswa';
			$status = 'success';
		} else {
			$pesan = 'Gagal Hapus Data Siswa';
			$status = 'danger';
		}
		
		$this->session->set_flashdata('status', '<div class="alert alert-'.$status.'">'.$pesan.'</div>');
	}
	
	public function ubah_siswa() {
		$nis = $this->input->post('nis');
		$data = array(
			'nama' => $this->input->post('nama'),
			'tahun_masuk' => $this->input->post('tahun_masuk'),
			'id_kelas' => $this->input->post('id_kelas'),
		);
		
		$this->load->model('m_siswa');
		$ubah = $this->m_siswa->ac_ubah_siswa($data, $nis);
		
		//echo $this->db->last_query();
		
		if ($ubah>0) {
			$pesan = 'Berhasil Ubah Siswa';
			$status = 'success';
		} else {
			$pesan = 'Gagal Ubah Siswa';
			$status = 'danger';
		}
		
		$this->session->set_flashdata('status', '<div class="alert alert-'.$status.'">'.$pesan.'</div>');
		redirect('admin/siswa/'.$data['id_kelas']);
	}
	
	public function ubah_nilai() {
		$this->load->model('m_nilai');
		$nis = $this->input->post('nis');
		$ubah = 0;
		$this->load->library('form_validation');
		
		$dft_mp = $this->input->post('kd_mp');
		for($n=0; $n<count($dft_mp); $n++) {
			$kd_mp = $dft_mp[$n];
			$data = array(
				'nilai' => $this->input->post('nilai'.($n+1))
			);
			
			
			echo 'Data ke-'.$n.' : ';
			print_r($data);
			echo '<br />';
			
			$nilai = $this->m_nilai->ubah_nilai($nis, $kd_mp, $data);
			$ubah = $ubah+$nilai;
			echo $this->db->last_query();
		}
		
		
		if ($ubah>0) {
			// hitung nilai akhir siswa
			$this->db->query('call proc_tambah_na('.$nis.')');
			
			$pesan = 'Berhasil Ubah Nilai Siswa';
			$status = 'success';
		} else {
			$pesan = 'Gagal Ubah Nilai Siswa';
			$status = 'danger';
		}
		
		$this->db->select('id_kelas');
		$this->db->where('nis', $nis);
		$siswa = $this->db->get('siswa');
		foreach ($siswa->result() as $s) {
			$id_kelas = $s->id_kelas;
		}
		$this->session->set_flashdata('status', '<div class="alert alert-'.$status.'">'.$pesan.'</div>');
		
		//redirect('admin/siswa/'.$id_kelas);
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
	
	public function tambah_minat() {
		$nis = $this->input->post('nis');
		$nm_ptn = $this->input->post('nm_ptn');
		$nm_jur = $this->input->post('nm_jur');
		
		$this->load->model('m_siswa');
		$minat = $this->m_siswa->tambah_minat($nm_ptn, $nm_jur, $nis);
		echo $minat;
		echo $this->db->last_query();
		
		$this->load->model('m_kelas');
		redirect('admin/siswa/'.$this->m_kelas->get_kelas_by_nis($nis));
	}
	
	public function hapus_minat($kd_ptn_jur, $nis) {
		$this->load->model('m_siswa');
		$minat = $this->m_siswa->hapus_minat($kd_ptn_jur, $nis);
		echo $minat;
		$this->load->model('m_kelas');
		redirect('admin/siswa/'.$this->m_kelas->get_kelas_by_nis($nis));
	}
	
	public function ubah_status($status, $kd_ptn_jur, $nis) {
		$this->load->model('m_siswa');
		$minat = $this->m_siswa->ubah_minat($status, $kd_ptn_jur, $nis);
		echo $minat;
		$this->load->model('m_kelas');
		redirect('admin/siswa/'.$this->m_kelas->get_kelas_by_nis($nis));
	}
	
	//import data kelas
	
	public function form_upload() {
		$data['title'] = 'Admin - Import Data Siswa';
		$this->load->view('admin/form_import_data2',$data);
	}
	
	public function test_ajax_import() {
		echo $_FILES['files']['name'];
		echo 'something controller';
	}
	
	public function ac_upload() {
		ini_set('max_execution_time', 1200);
		
		//keterangan
		$kls = $this->input->post('kelas');
		$tahun_ajaran = $this->input->post('tahun_ajaran');
		
		$this->db->select('id_kelas','id_kelas');
		$this->db->where('nama_kelas',$kls);
		$this->db->where('tahun_ajaran',$tahun_ajaran);
		$cek_kelas = $this->db->get('kelas');
		
		
		//Upload file
		$file = $_FILES['files'];
		$tmp = explode('.',$file['name']);
		$ext = end($tmp);
		$filename = 'nilai_siswa_tahun_ajaran_'.$tahun_ajaran.'.'.$ext;
		
		
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
			echo 'Upload File berhasil<br/>';
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
				'id_guru'=>$this->session->userdata('id'),
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
				echo $inis.$inama.$ikelas;
				
				$this->db->select('nis');
				$this->db->where('nis',$inis);
				$cek_siswa = $this->db->get('siswa');
				echo $cek_siswa->num_rows();
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
				
				print_r($data);
				$jml_siswa++;
				echo '<br/>';
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
		
		$this->db->query("call proc_tambah_na_siswa(".($tahun_ajaran-3).")") or die( mysql_error());
		
		echo 'Selesai';
		echo $jml_siswa;
	}
	
	public function ac_upload2() {
		ini_set('max_execution_time', 1200);
		
		//keterangan
		$kls = $this->input->post('kelas');
		$tahun_ajaran = $this->input->post('tahun_ajaran');
		$semester = $this->input->post('semester');
		$id_guru = $this->session->userdata('id');
		
		$this->db->select('id_kelas','id_kelas');
		$this->db->where('nama_kelas',$kls);
		$this->db->where('tahun_ajaran',$tahun_ajaran);
		$cek_kelas = $this->db->get('kelas');
		
		
		//Upload file
		$file = $_FILES['files'];
		$tmp = explode('.',$file['name']);
		$ext = end($tmp);
		$filename = 'nilai_siswa_kelas_'.str_replace(' ','_',$kls).'_TA_'.$tahun_ajaran.'_semester_'.$semester.'.'.$ext;
		
		
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
			echo 'Upload File berhasil<br/>';
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
		$smp = array("D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S");
		
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
		
		/*
		echo '<pre>';
		print_r($nisn);
		echo '</pre>';
		echo '<br/>';
		*/
		
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
					echo 'Gagal Tambah Siswa Baru<br />';
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
		
		echo 'Selesai';
		echo $jml_siswa;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */