<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mata_pelajaran extends CI_Controller {
	public function tambah_mp() {
		$this->load->model('m_nilai');
		$jurusan = $this->input->post('jurusan');
		$nama_mp = $this->input->post('nama_mp');
		$ket_mp_un = $this->input->post('ket_mp_un');
		
		if ($this->m_nilai->cek_mp($nama_mp)) {
			for($n=0; $n<count($this->input->post('smt')); $n++) {
				$semester = $this->input->post('smt')[$n];
				$kkm = $this->input->post('kkm'.$n);
				if ($semester!='') {
				$kd_mp = $this->m_nilai->next_kd_mp($jurusan, $semester, $nama_mp);
				$data = array(
					'kd_mp' => $kd_mp,
					'nama_mp' => $nama_mp,
					'kkm' => $kkm,
					'semester' => $semester,
					'jurusan' => $jurusan,
					'ket_mp_un' => $ket_mp_un
				);
				echo $kd_mp;
				$tambah = $this->m_nilai->tambah_mp($data);
				}
				//echo $tambah;
				//echo $this->db->last_query();
			}
			$this->session->set_flashdata('status', '<div class="alert alert-success">Berhasil Menambah Mata Pelajaran</div>');
		} else {
			$this->session->set_flashdata('status', '<div class="alert alert-danger">Gagal, Mata Pelajaran Sudah Terdaftar</div>');
		}
		redirect('admin/mata_pelajaran/'.$jurusan);
	}
	
	public function ubah_mp() {
		$this->load->model('m_nilai');
		$nama_mp = $this->input->post('nama_mp');
		$jurusan = $this->input->post('jurusan');
		$ket_mp_un = $this->input->post('ket_mp_un');
		
		echo 'Data yang akan di rubah : <br/>';
		
		for($n=0; $n<count($this->input->post('smt')); $n++) {
			$semester = $this->input->post('smt')[$n];
			$kkm = $this->input->post('kkm'.$n);
			if ($this->input->post('kdMp')[$n]!='') {
				$kd_mp = $this->input->post('kdMp')[$n];
			} else {
				$kd_mp = $this->m_nilai->next_kd_mp($jurusan, $semester, $nama_mp);
			}
			$data = array(
				'semester' => $semester,
				'nama_mp' => $nama_mp,
				'kkm' => $kkm,
				'jurusan' => $jurusan,
				'ket_mp_un' => $ket_mp_un
			);
			if ($data['kkm']!=''||$data['kkm']!=0) {
			$ubah = $this->m_nilai->ubah_kkm($kd_mp, $data);
			/*echo $ubah;
			echo $this->db->last_query();
			echo '<br/>'.($n+1).'. kdMP : '.$kd_mp.', namaMp : '.$nama_mp.', kkm : '.$kkm.'<br/>';
			echo '<br/>';
			*/
			}
			
		}
		
		redirect('admin/mata_pelajaran/'.$jurusan);
	}
	
	public function hapus_mp($kdMp) {
		$this->load->model('m_nilai');
		$hapus = $this->m_nilai->hapus_kkm($kdMp);
		if($hapus>0) {
			echo '<p class="bg-success">KKM Berhasil Di Hapus</p>';
		} else {
			echo '<p class="bg-success">KKM Gagal Di Hapus</p>';
		
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */