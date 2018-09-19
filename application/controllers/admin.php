<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		/* Check if user already login or not */
		if ($this->session->userdata('islogin')!='ok') {
			redirect('login','refresh');
		}
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . 'GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-chace');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}	
	
	public function index()	{
		$data['title'] = 'Admin - Dashboard';
		$result = $this->db->query('select min(tahun_pilih) min_thn, max(tahun_pilih) max_thn from memilih where status="terima"');
		$data['tahun_min'] = $result->row()->min_thn;
		$data['tahun_max'] = $result->row()->max_thn;
		$this->load->model('m_guru');
		$data['evaluasi'] = $this->m_guru->daftar_evaluasi();
		$this->load->view('admin/dashboard', $data);
		//echo $this->session->flashdata('status');
	}
	
	public function profil_guru()	{
		$this->load->model('m_guru');
		
		$data['title'] = 'Profil Guru - Dashboard';
		$data['profil'] = $this->m_guru->data_guru($this->session->userdata('id'));
		$this->load->view('admin/profil_guru', $data);
		//echo $this->session->flashdata('status');
	}
	
	public function grafik($id_ptn) {
		$this->db->where('id_ptn', $id_ptn);
		$data['ptn'] = $this->db->get('ptn');
		$this->db->where('id_ptn', $id_ptn);
		$this->db->from('ptn_terdiri_dari_jurusan pj');
		$this->db->join('jurusan_ptn j','pj.id_jurusan_ptn=j.id_jurusan_ptn');
		$jur = $this->db->get();
		$data['jml_jur'] = $jur->num_rows();
		$result = $this->db->query('select min(tahun_pilih) min_thn, max(tahun_pilih) max_thn from memilih where status="terima"');
		$data['tahun_min'] = $result->row()->min_thn;
		$data['tahun_max'] = $result->row()->max_thn;
		$data['title'] = 'Admin - Grafik';
		$this->load->view('admin/dashboard', $data);
	}
	
	public function data_grafik_kelulusan($id_ptn=null) {
		if (!isset($id_ptn)) {
			if (isset($_GET['thn_dari']) && isset($_GET['thn_sampai'])) {
				$query = 'SELECT CONCAT("admin/grafik/", p.id_ptn, "?thn_dari='.$_GET['thn_dari'].'&thn_sampai='.$_GET['thn_sampai'].'") data_url,';
			} else {
				$query = 'SELECT CONCAT("admin/grafik/", p.id_ptn, "") data_url,';			
			}
			$query .= ' nama_ptn, count(nis) jumlah_lulus FROM (memilih m) JOIN ptn_terdiri_dari_jurusan pj ON m.kd_ptn_jur=pj.kd_ptn_jur JOIN ptn p ON p.id_ptn=pj.id_ptn WHERE m.status="terima" ';
			if (isset($_GET['thn_dari']) && isset($_GET['thn_sampai'])) {
				$query .= 'AND tahun_pilih>='.$_GET['thn_dari'].' AND tahun_pilih<='.$_GET['thn_sampai'];
			}
			$query .= ' GROUP BY p.id_ptn';
			$data = $this->db->query($query);
		} else {
			$query = 'SELECT nama_jurusan_ptn, count(nis) jumlah_lulus FROM (memilih m) JOIN ptn_terdiri_dari_jurusan pj ON (m.kd_ptn_jur=pj.kd_ptn_jur) JOIN ptn p ON (p.id_ptn=pj.id_ptn) JOIN jurusan_ptn j ON (pj.id_jurusan_ptn=j.id_jurusan_ptn) WHERE p.id_ptn='.$id_ptn.' and m.status="terima" ';
			if (isset($_GET['thn_dari']) && isset($_GET['thn_sampai'])) {
				$query .= 'AND tahun_pilih>='.$_GET['thn_dari'].' AND tahun_pilih<='.$_GET['thn_sampai'];
			}
			$query .= ' GROUP BY pj.id_jurusan_ptn';
			$data = $this->db->query($query);
		}
		echo json_encode($data->result_array());
	}
	
	public function form_evaluasi($id=null) {
		if (!isset($id)) {
			$this->load->view('admin/form-evaluasi-modal-body');
		} else {
			$this->load->model('m_guru');
			$data['evaluasi'] = $this->m_guru->data_evaluasi($id);
			$this->load->view('admin/form-evaluasi-modal-body', $data);
		}
	}
	
	public function kelas() {
		$data['title'] = 'Admin - Kelola Data Kelas';
		$this->load->model('m_kelas');
		$data['daftar_kelas'] = $this->m_kelas->daftar_kelas();
		
		$this->load->view('admin/kelas',$data);
	}
	
	public function form_kelas($kelas=null) {
	
		if (!isset($kelas)) {
			$this->load->view('admin/form-kelas-modal-body');
		} else {
			$this->load->model('m_kelas');
			$data['kelas'] = $this->m_kelas->data_kelas($kelas);
			$this->load->view('admin/form-kelas-modal-body', $data);
		}
	}
	
	public function siswa($id_kelas) {
		$data['title'] = 'Admin - Kelola Data Siswa';
		$this->load->model('m_siswa');
		$data['kelas'] = $this->m_siswa->get_kelas($id_kelas);
		$data['daftar_siswa'] = $this->m_siswa->daftar_siswa($id_kelas);
		$this->load->view('admin/siswa', $data);
	}
	
	public function daftar_nilai($nis, $smt=1) {
		$this->load->model('m_nilai');
		if ($smt!='un') {
			$data['daftar_mp'] = $this->m_nilai->daftar_mp_smt($nis, $smt);
		} else {
			$data['daftar_mp'] = $this->m_nilai->daftar_mp_un($nis);
		}
		
		$data['smt'] = $smt;
		$this->load->view('admin/daftar-nilai-modal-body',$data);
	}
	
	public function daftar_minat($nis) {
		$this->load->model('m_siswa');
		$data['nis'] = $nis;
		$data['minat'] = $this->m_siswa->daftar_minat($nis);
		$this->load->view('admin/daftar-minat-modal-body',$data);
	}
	
	public function form_minat($nis) {
		$data['nis'] = $nis;
		$this->load->view('admin/form-minat-modal-body',$data);
	}
	
	public function form_siswa($kelas, $nis=null) {
		if(!isset($nis)) {
			$this->db->select('tahun_ajaran');
			$this->db->where('id_kelas',$kelas);
			$data['tahun_ajaran'] = $this->db->get('kelas')->row()->tahun_ajaran;
			
			$data['kelas'] = $kelas;
			$this->load->view('admin/form-siswa-modal-body',$data);
		} else {
			$this->load->model('m_siswa');
			$data['daftar_siswa'] = $this->m_siswa->data_siswa($nis);
			$this->load->view('admin/form-siswa-modal-body',$data);
		}
	}
	
	public function guru() {
		$this->load->model('m_guru');
		$data['title'] = 'Kelola Data Guru';
		$data['daftar_guru'] = $this->m_guru->daftar_guru();
		$this->load->view('admin/guru',$data);
	}
	
	public function form_guru($id_guru=null) {
		if(!isset($id_guru)) {
			$this->load->view('admin/form-guru-modal-body');
		} else {
			$this->load->model('m_guru');
			$data['data_guru'] = $this->m_guru->data_guru($id_guru);
			$this->load->view('admin/form-guru-modal-body',$data);
		}
	}
	
	public function daftar_kelas($nip) {
		$this->load->model('m_kelas');
		$data['dft_kelas'] = $this->m_kelas->daftar_kelas($nip);
		$this->load->view('admin/daftar-kelas-modal-body', $data);
	}
	
	public function mata_pelajaran($jurusan=null) {
		$this->load->model('m_nilai');
		$data['title'] = 'Kelola Data Mata Pelajaran';
		//$data['mp'] = $this->m_nilai->daftar_mp();
		if (isset($jurusan)) {
			$data['jur'] = $jurusan;
		}
		$this->load->view('admin/mata_pelajaran',$data);
	}
	
	public function daftar_mp($jur) {

		$this->load->model('m_nilai');
		$data['mp'] = $this->m_nilai->daftar_mp($jur);
		$this->load->view('admin/daftar-mp-modal-body',$data);
	}
	
	public function form_mp($jur, $nm_mp=null) {
		
		if (!isset($nm_mp)) {
			$data['jurusan'] = $jur;
			$this->load->view('admin/form-mp-modal-body');
		} else {
			$this->load->model('m_nilai');
			$nm_mp = str_replace('_',' ',$nm_mp);
			$data['nama_mp'] = $nm_mp;
			$data['jurusan'] = $jur;
			$data['daftar_kkm'] = $this->m_nilai->daftar_kkm($nm_mp, $jur);
			//print_r($data['daftar_kkm']->result_array());
			//echo $this->db->last_query();
			$this->load->view('admin/form-mp-modal-body', $data);
		}
	}
	
	public function ptn() {
		$data['title'] = 'Daftar Perguruan Tinggi Negeri';
		$this->load->view('admin/ptn', $data);
	}
	
	public function daftar_ptn() {
		$this->load->model('m_ptn');
		$data['dft_ptn'] = $this->m_ptn->daftar_ptn();
		$this->load->view('admin/daftar-ptn', $data);
	}
	
	public function form_ptn($id_ptn=null) {
		//echo $id_ptn;
		
		if (!isset($id_ptn)) {
			$this->load->view('admin/form-ptn-modal-body');
		} else {
			$this->load->model('m_ptn');
			$data['ptn'] = $this->m_ptn->ambil_ptn($id_ptn);
			$this->load->view('admin/form-ptn-modal-body', $data);
		}
		
	}
	
	public function daftar_jurusan($id_ptn=null) {
		$this->load->model('m_ptn');
		
		if (isset($id_ptn)) {
			$data['id_ptn'] = $id_ptn;
			$data['dft_jurusan'] = $this->m_ptn->daftar_jurusan($id_ptn);
			
			$this->load->view('admin/daftar-jurusan-modal-body', $data);
		} else {
			$data['dft_jurusan'] = $this->m_ptn->daftar_jurusan();
			
			$this->load->view('admin/daftar-jurusan-modal-body', $data);
		}
	}
	
	public function form_jurusan($id_ptn=null, $id_jur=null) {
	
		//echo $id_ptn;
		
		if (!isset($id_jur)) {
			$data['id_ptn'] = $id_ptn;
			$this->load->view('admin/form-jurusan-modal-body', $data);
		} else {
			$this->load->model('m_ptn');
			$data['ptn'] = $this->m_ptn->ambil_ptn($id_ptn);
			$this->load->view('admin/form-ptn-modal-body', $data);
		}
		
	}
	
	public function jurusan_ptn() {
		$data['title'] = 'Daftar Jurusan';
		$this->load->view('admin/jurusan_ptn', $data);
	}
	
	public function daftar_jurusan_ptn() {
		$this->load->model('m_ptn');
		$data['dft_jur'] = $this->m_ptn->daftar_jur_ptn();
		$this->load->view('admin/daftar-jur-ptn', $data);
	}
	
	public function daftar_ptn_jur($id_jur) {
		$this->load->model('m_ptn');
		$data['id_jur'] = $id_jur;
		$data['dft_ptn'] = $this->m_ptn->daftar_ptn_jur($id_jur);
		
		$this->load->view('admin/daftar-ptn-jur-modal-body', $data);
	}
	
	public function form_jur_ptn($id_jur=null) {
		//echo $id_ptn;
		
		if (!isset($id_jur)) {
			$this->load->view('admin/form-jur-ptn-modal-body');
		} else {
			$this->load->model('m_ptn');
			$data['jur'] = $this->m_ptn->ambil_jur_ptn($id_jur);
			$this->load->view('admin/form-jur-ptn-modal-body', $data);
		}
		
	}
	
	public function form_ptn_jur($id_jur) {
		$data['id_jur'] = $id_jur;
		$this->load->view('admin/form-ptn-jur-modal-body', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */