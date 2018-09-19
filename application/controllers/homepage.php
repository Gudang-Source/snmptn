<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends CI_Controller {

	public function index()	{
		$data['title'] = 'Halaman Utama';
		$this->load->view('homepage/home', $data);
	}
	
	public function perkembangan_kelulusan($id_ptn=null) {
		$this->load->model('m_homepage');
		/*
		if ($this->input->post('id_ptn')!='') {
			$id_ptn = $this->input->post('id_ptn');
		}
		*/
		$data['title'] = 'Perkembangan Kelulusan Siswa';
		$data['lulus'] = $this->m_homepage->ambil_data_kelulusan();
		if(isset($id_ptn)) {
			$data['id_ptn'] = $id_ptn;
			$data['nm_ptn'] = $this->m_homepage->ambil_nama_ptn($id_ptn);
		}
		$this->load->view('homepage/grafik-perkembangan', $data);
		//echo $this->db->last_query();
	}
	
	public function prediksi($ptn=null, $nilai=null,$acuan=null) {
		$this->load->model('m_homepage');
		$data['title'] = 'Prediksi Kelulusan';
		
		if(!isset($acuan)) {
			if($this->input->post('acuan')=='semua' || $this->input->post('acuan')=='') {
				$jml_nilai = 'jml_nilai_mp';
			} else {
				$jml_nilai = 'jml_nilai_mp_un';
			}
			$data['acuan'] = $this->input->post('acuan');
		} else {
			if($acuan=='semua') {
				$jml_nilai = 'jml_nilai_mp';
			} else {
				$jml_nilai = 'jml_nilai_mp_un';
			}
			$data['acuan'] = $acuan;
		}
		
		$data['prediksi'] = $this->m_homepage->ambil_data_prediksi($ptn, $nilai, $jml_nilai);
		if($this->input->post('jml_nilai')!=0 && $this->input->post('jurusan')=='' && $this->input->post('ptn')=='') {
			//jika hanya jumlah nilai
			
			$data['pencarian'] = 'nilai';
			$data['jml_nilai'] = $this->input->post('jml_nilai');
		} else if (($this->input->post('jml_nilai')!=0 && $this->input->post('ptn')!='') || (isset($ptn) && isset($nilai))) {
			$data['jml_nilai'] = $this->input->post('jml_nilai');
			$data['jurusan'] = $this->input->post('jurusan');
			$data['ptn'] = $this->input->post('ptn');
			$data['pencarian'] = 'nilai ptn jurusan';
		} else if ($this->input->post('jml_nilai')!=0 && $this->input->post('jurusan')!='') {
			//jika jumlah nilai dan jurusan
			
			$data['jml_nilai'] = $this->input->post('jml_nilai');
			$data['jurusan'] = $this->input->post('jurusan');
			$data['pencarian'] = 'nilai jurusan';
		} else if (($this->input->post('jml_nilai')!=0 && $this->input->post('ptn')!='') || (isset($ptn) && isset($nilai))) {
			//jika jumlah nilai dan ptn
			if ($this->input->post('jml_nilai')!=0 && $this->input->post('ptn')!='') {
				$data['jml_nilai'] = $this->input->post('jml_nilai');
				$data['ptn'] = $this->input->post('ptn');
			} else {
				$data['jml_nilai'] = $nilai;
				$this->db->select('nama_ptn');
				$this->db->where('id_ptn',$ptn);
				$np = $this->db->get('ptn');
				$data['ptn'] = $np->row()->nama_ptn;
			}
			$data['pencarian'] = 'nilai ptn';
		}
		//print_r($data['prediksi']->result_array());
		$this->load->view('homepage/prediksi-kelulusan', $data);
	}
	
	public function peringkat() {
		if ($this->input->post('ptn')!='') {
			$nm_ptn = $this->input->post('ptn');
			$nm_jur = $this->input->post('jurusan');
			$this->load->model('m_homepage');
			//cek ptn dan jurusan
			$kd_ptn_jur = $this->m_homepage->cek_kd_ptn_jur($nm_ptn, $nm_jur);
			if ($kd_ptn_jur->num_rows()>0) {
				$data['status'] = 'ada';
				$data['peringkat'] = $this->m_homepage->daftar_peringkat($nm_ptn, $nm_jur);
			} else {
				$data['status'] = 'tidak ada';
			}
		}
		
		$data['title'] = 'Lihat Peringkat Siswa';
		$this->load->view('homepage/peringkat-siswa', $data);
	}
	
	public function grafik_kelulusan_per_ptn($id_ptn,$thn=null) {
		$this->load->model('m_homepage');
		
		$lulus = $this->m_homepage->data_lulus_by_ptn($id_ptn, $thn);
		
		/*$data['title'] = 'Perkembangan Kelulusan Siswa';
		$this->load->view('homepage/grafik-perkembangan', $data);
		*/
		echo json_encode($lulus->result_array());
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */