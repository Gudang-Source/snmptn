<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teacher extends CI_Controller {

	public function index()	{
		echo 'tes';
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


	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */