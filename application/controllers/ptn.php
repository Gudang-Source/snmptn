<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ptn extends CI_Controller {
	public function tambah_ptn() {
		echo $this->input->post('nama_ptn');
		
		$this->load->model('m_ptn');
		$data = array(
			'nama_ptn' => $this->input->post('nama_ptn')
			);
		$tambah = $this->m_ptn->ac_tambah_ptn($data);
		if ($tambah>0) {
			echo 'data berhasil di tambah';
		} else {
			echo 'data gagal di tambah';
		}
		
		redirect('admin/ptn');
		
	}
	
	public function ubah_ptn() {
		$this->load->model('m_ptn');
		$id_ptn = $this->input->post('id_ptn');
		$data = array(
			'nama_ptn' => $this->input->post('nama_ptn')
			);
		$ubah = $this->m_ptn->ac_ubah_ptn($data, $id_ptn);
		if ($ubah>0) {
			echo 'data berhasil di ubah';
		} else {
			echo 'data gagal di ubah';
		}
		
		redirect('admin/ptn');
	}
	
	public function hapus_ptn($id_ptn) {
		$this->load->model('m_ptn');
		
		$ubah = $this->m_ptn->ac_hapus_ptn($id_ptn);
		if ($ubah>0) {
			echo 'data berhasil di hapus';
		} else {
			echo 'data gagal di hapus';
		}
		redirect('admin/ptn');
	}
	
	public function cari_ptn($cari) {
		$cari = str_replace('%2F','/', $cari);
		$cari = str_replace('%20',' ', $cari);
		$this->db->like('nama_ptn',$cari);
		$this->db->select('id_ptn,nama_ptn');
		$ptn = $this->db->get('ptn');
		
		foreach($ptn->result() as $p) {
			$id_ptn[] = $p->id_ptn;
			$nama_ptn[] = $p->nama_ptn;
		}
		
		echo json_encode($nama_ptn);
	}
	
	public function cari_jurusan() {
		$cari=$_GET['q'];
		if(isset($_GET['ptn'])) {
			$nama_ptn = $_GET['ptn'];
		}
		if(!isset($nama_ptn)) {
			$cari = str_replace('%2F','/', $cari);
			$cari = str_replace('%20',' ', $cari);
			$this->db->like('nama_jurusan_ptn',$cari);
			$this->db->select('id_jurusan_ptn,nama_jurusan_ptn');
			$jur = $this->db->get('jurusan_ptn');
		} else {
			$cari = str_replace('%2F','/', $cari);
			$cari = str_replace('%20',' ', $cari);
			$this->db->like('nama_jurusan_ptn',$cari);
			$this->db->like('nama_ptn',$nama_ptn);
			$this->db->select('j.id_jurusan_ptn,nama_jurusan_ptn');
			$this->db->from('ptn p');
			$this->db->join('ptn_terdiri_dari_jurusan pj','p.id_ptn=pj.id_ptn');
			$this->db->join('jurusan_ptn j','j.id_jurusan_ptn=pj.id_jurusan_ptn');
			$jur = $this->db->get();
		}
		
		foreach($jur->result() as $p) {
			$id_jur[] = $p->id_jurusan_ptn;
			$nama_jur[] = $p->nama_jurusan_ptn;
		}
		if (!isset($nama_jur)) {
			$nama_jur = array('Jurusan Tidak Ditemukan');
		}
		//echo $this->db->last_query();
		echo json_encode($nama_jur);
	}
	
	public function daftar_jurusan_json() {
		$this->db->select('nama_jurusan_ptn');
		$jur = $this->db->get('jurusan_ptn');
		$djur = array();
		foreach($jur->result() as $j) {
			array_push($djur, $j->nama_jurusan_ptn);
		}
		
		header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 2027 05:00:00 GMT');
        header('Content-type: application/json');
		echo json_encode($djur);
	}
	
	public function tambah_jurusan() {
		
		
		$id_ptn = $this->input->post('id_ptn');
		$namaJur = $this->input->post('namaJur');
		
		/*echo $id_ptn;
		print_r( explode(',', $namaJur));
		*/
		$this->load->model('m_ptn');
		$tambah = $this->m_ptn->ac_tambah_jurusan($id_ptn, $namaJur);
		//echo $tambah;
		//print_r($tambah->result_array());
		
		if ($tambah!='') {
			echo '<h4><span class="label label-danger">Maaf, Gagal menambah Jurusan pada PTN</span></h4>';
			echo '<h4><span class="label label-danger">'.$tambah.'</span></h4>';
		} else {
			echo '<h4><span class="label label-success">Berhasil menambah Jurusan pada PTN</span></h4>';
		}
		
	}
	
	public function hapus_jurusan_di_ptn($kd_ptn_jur) {
		$this->load->model('m_ptn');
		$hapus = $this->m_ptn->ac_hps_jur_ptn($kd_ptn_jur);
		
		if ($hapus<1) {
			echo '<h4><span class="label label-danger">Maaf, Gagal menghapus Jurusan pada PTN</span></h4>';
		} else {
			echo '<h4><span class="label label-success">Berhasil menghapus Jurusan pada PTN</span></h4>';
		}
	}
	
	public function tambah_jur_ptn() {
		//echo $this->input->post('nama_jur');
		
		$this->load->model('m_ptn');
		$data = array(
			'nama_jurusan_ptn' => $this->input->post('nama_jur')
			);
		$tambah = $this->m_ptn->ac_tambah_jur_ptn($data);
		if ($tambah>0) {
			echo 'data berhasil di tambah';
		} else {
			echo 'data gagal di tambah';
		}
		
		redirect('admin/jurusan_ptn');
	}

	public function ubah_jur_ptn() {
		$this->load->model('m_ptn');
		$id_jur = $this->input->post('id_jur_ptn');
		$data = array(
			'nama_jurusan_ptn' => $this->input->post('nama_jur_ptn')
			);
		$ubah = $this->m_ptn->ac_ubah_jur_ptn($data, $id_jur);
		if ($ubah>0) {
			echo 'data berhasil di ubah';
		} else {
			echo 'data gagal di ubah';
		}
		
		redirect('admin/jurusan_ptn');
	}

	public function hapus_jur_ptn($id_jur) {
		$this->load->model('m_ptn');
		
		$hapus = $this->m_ptn->ac_hapus_jur_ptn($id_jur);
		if ($hapus>0) {
			echo 'data berhasil di hapus';
		} else {
			echo 'data gagal di hapus';
		}
		redirect('admin/jurusan_ptn');
	}
	
	public function hapus_ptn_dgn_jur($kd_ptn_jur) {
		$this->load->model('m_ptn');
		$hapus = $this->m_ptn->ac_hps_jur_ptn($kd_ptn_jur);
		
		if ($hapus<1) {
			echo '<h4><span class="label label-danger">Maaf, Gagal menghapus Jurusan pada PTN</span></h4>';
		} else {
			echo '<h4><span class="label label-success">Berhasil menghapus Jurusan pada PTN</span></h4>';
		}
	}

	public function tambah_ptn_jur() {
		
		
		$id_jur = $this->input->post('id_jur');
		$namaPtn = $this->input->post('namaPtn');
		
		/*echo $id_ptn;
		print_r( explode(',', $namaJur));
		*/
		$this->load->model('m_ptn');
		$tambah = $this->m_ptn->ac_tambah_ptn_jurusan($id_jur, $namaPtn);
		//echo $tambah;
		//print_r($tambah->result_array());
		
		if ($tambah!='') {
			echo '<h4><span class="label label-danger">Maaf, Gagal menambah PTN pada Jurusan</span></h4>';
			echo '<h4><span class="label label-danger">'.$tambah.'</span></h4>';
		} else {
			echo '<h4><span class="label label-success">Berhasil menambah PTN pada Jurusan</span></h4>';
		}
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */