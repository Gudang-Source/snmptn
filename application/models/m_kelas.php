<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_kelas extends CI_Model {
	public function daftar_kelas($nip=null) {
		if ($nip==null) {
			$id_guru = $this->session->userdata('id');
		} else {
			$id_guru = $nip;
		}
		$this->db->select('kelas.*, count(nis) as jml_siswa, nama_jurusan');
		$this->db->from('kelas');
		$this->db->join('siswa', 'siswa.id_kelas=kelas.id_kelas','LEFT');
		$this->db->join('jurusan', 'kelas.id_jurusan=jurusan.id_jurusan');
		$this->db->where('id_guru', $id_guru);
		$this->db->group_by('kelas.id_kelas');
		$this->db->order_by('tahun_ajaran','desc');
		$this->db->order_by('kelas.id_kelas','asc');
		$query = $this->db->get();
		return $query;
	}
	
	public function get_kelas_by_nis($nis) {
		$this->db->where('nis', $nis);
		$k = $this->db->get('siswa');
		return $k->row()->id_kelas;
	}
	
	public function data_kelas($id_kelas) {
		$this->db->where('id_kelas', $id_kelas);
		return $this->db->get('kelas');
	}
	
	public function ac_tambah_kelas($data) {
		$this->db->select('id_kelas');
		$this->db->where('nama_kelas',$data['nama_kelas']);
		$this->db->where('tahun_ajaran',$data['tahun_ajaran']);
		$ck = $this->db->get('kelas')->num_rows();
		if ($ck<1) {
			$this->db->insert('kelas',$data);
			$hasil = $this->db->affected_rows();
		} else {
			$hasil = 0;
		}
		
		return $hasil;
	}
	
	public function ac_ubah_kelas($data, $id_kelas) {
		$this->db->where('id_kelas', $id_kelas);
		$this->db->update('kelas',$data);
		
		return $this->db->affected_rows();
	}
	
	public function ac_hapus_kelas($id_kelas) {
		$this->db->where('id_kelas', $id_kelas);
		$this->db->delete('kelas');
		
		return $this->db->affected_rows();
	}
	
}
/*End of file models*/