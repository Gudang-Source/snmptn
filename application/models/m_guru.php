<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_guru extends CI_Model {
	public function login_guru($nip, $pass) {
		$this->db->select('id, nip, nama');
		$this->db->where('nip', $nip);
		$this->db->where('password', $pass);
		$result = $this->db->get('guru');
		return $result;
	}
	
	public function daftar_guru() {
		$query = $this->db->get('guru');
		return $query;
	}
	
	public function data_guru($id_guru) {
		$this->db->where('id', $id_guru);
		$query = $this->db->get('guru');
		return $query;
	}
	
	public function ac_tambah_guru($data) {
		$this->db->insert('guru', $data);
	}
	
	public function ac_ubah_guru($data, $id_guru) {
		$this->db->where('id', $id_guru);
		$query = $this->db->update('guru',$data);
		return $this->db->affected_rows();
	}
	
	public function ac_hapus_guru($id) {
		$this->db->where('id', $id);
		$query = $this->db->delete('guru');
		return $this->db->affected_rows();
	}
	
	public function daftar_evaluasi() {
		$query = $this->db->get('evaluasi_kelulusan');
		return $query;
	}
	
	public function data_evaluasi($id) {
		$this->db->where('id_evaluasi',$id);
		$query = $this->db->get('evaluasi_kelulusan');
		return $query;
	}
	
	public function ac_tambah_evaluasi($data) {
		$this->db->insert('evaluasi_kelulusan',$data);
		return $this->db->affected_rows();
	}
	
	public function ac_ubah_evaluasi($id, $data) {
		$this->db->where('id_evaluasi',$id);
		$ubah = $this->db->update('evaluasi_kelulusan',$data);
		if ($ubah) {
			return 1;
		} else {
			return 0;
		}
		
	}
	
	public function ac_hapus_evaluasi($id) {
		$this->db->where('id_evaluasi',$id);
		$this->db->delete('evaluasi_kelulusan');
		return $this->db->affected_rows();
	}
}
/*End of file models*/