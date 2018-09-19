<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_ptn extends CI_Model {
	public function daftar_ptn() {
		$query = $this->db->get('ptn');
		return $query;
	}
	
	public function ambil_ptn($id_ptn) {
		$this->db->where('id_ptn', $id_ptn);
		$query = $this->db->get('ptn');
		return $query;
	}
	
	public function ac_tambah_ptn($data) {
		$this->db->like('nama_ptn',$data['nama_ptn']);
		$cek_ptn = $this->db->get('ptn');
		$jml=0;
		if ($cek_ptn->num_rows()<1) {
			$query = $this->db->insert('ptn', $data);
			$jml = $this->db->affected_rows();
		}
		
		return $jml;
	}
	
	public function ac_ubah_ptn($data, $id) {
		$this->db->where('id_ptn', $id);
		$query = $this->db->update('ptn', $data);
		$jml = $this->db->affected_rows();
		return $jml;
	}
	
	public function ac_hapus_ptn($id) {
		$this->db->where('id_ptn', $id);
		$query = $this->db->delete('ptn_terdiri_dari_jurusan');
	
		$this->db->where('id_ptn', $id);
		$query = $this->db->delete('ptn');
		$jml = $this->db->affected_rows();
		return $jml;
	}
	
	public function daftar_jurusan($id_ptn=null) {
		if (isset($id_ptn)) {
			$this->db->where('ptn_terdiri_dari_jurusan.id_ptn',$id_ptn);
		}
		$this->db->from('ptn_terdiri_dari_jurusan');
		$this->db->join('ptn','ptn_terdiri_dari_jurusan.id_ptn=ptn.id_ptn');
		$this->db->join('jurusan_ptn','ptn_terdiri_dari_jurusan.id_jurusan_ptn=jurusan_ptn.id_jurusan_ptn');
		$result = $this->db->get();
		return $result;
	}
	
	public function ac_tambah_jurusan($id_ptn, $nmJur) {
		$id_ptn_awal = $id_ptn;
		$this->db->like('nama_jurusan_ptn',$nmJur);
		$cek_jur = $this->db->get('jurusan_ptn');
		$status ='';
		if($cek_jur->num_rows()<1) {
			$data_jur = array('nama_jurusan_ptn'=>$nmJur);
			$this->db->insert('jurusan_ptn', $data_jur);
		}
		
		$this->db->where('nama_jurusan_ptn',$nmJur);
		$cari_id_jur = $this->db->get('jurusan_ptn');
		foreach($cari_id_jur->result() as $jur) {
			$id_jur = $jur->id_jurusan_ptn;
		}
		
		$kd_ptn_jur = "PJ".str_pad($id_ptn, 2, "0", STR_PAD_LEFT).str_pad($id_jur, 2, "0", STR_PAD_LEFT);
		
		$this->db->where('kd_ptn_jur', $kd_ptn_jur);
		$cek_kd_ptn_jur = $this->db->get('ptn_terdiri_dari_jurusan');
		if($cek_kd_ptn_jur->num_rows()<1) {
			$data_ptn = array(
				'kd_ptn_jur' => $kd_ptn_jur,
				'id_ptn' => $id_ptn,
				'id_jurusan_ptn' => $id_jur
			);
			
			$this->db->insert('ptn_terdiri_dari_jurusan', $data_ptn);
		} else {
			$status = 'Jurusan Sudah Terdaftar Pada PTN Ini';
		}
		
		
		return $status;
		
		//return $cek_kd_ptn_jur->num_rows();
	}
	
	public function ac_hps_jur_ptn($kd_ptn_jur) {
		$this->db->where('kd_ptn_jur', $kd_ptn_jur);
		$this->db->delete('ptn_terdiri_dari_jurusan');
		return $this->db->affected_rows();
	}
	
	public function daftar_jur_ptn() {
		$query = $this->db->get('jurusan_ptn');
		return $query;
	}

	public function ac_tambah_jur_ptn($data) {
		$this->db->like('nama_jurusan_ptn',$data['nama_jurusan_ptn']);
		$cek_ptn = $this->db->get('jurusan_ptn');
		$jml=0;
		if ($cek_ptn->num_rows()<1) {
			$query = $this->db->insert('jurusan_ptn', $data);
			$jml = $this->db->affected_rows();
		}
		
		return $jml;
	}

	public function ac_ubah_jur_ptn($data, $id) {
		$this->db->where('id_jurusan_ptn', $id);
		$query = $this->db->update('jurusan_ptn', $data);
		$jml = $this->db->affected_rows();
		return $jml;
	}
	
	public function ambil_jur_ptn($id_jur_ptn) {
		$this->db->where('id_jurusan_ptn', $id_jur_ptn);
		$query = $this->db->get('jurusan_ptn');
		return $query;
	}

	public function ac_hapus_jur_ptn($id) {
		$this->db->where('id_jurusan_ptn', $id);
		$query = $this->db->delete('ptn_terdiri_dari_jurusan');
	
		$this->db->where('id_jurusan_ptn', $id);
		$query = $this->db->delete('jurusan_ptn');
		$jml = $this->db->affected_rows();
		return $jml;
	}
	
	public function daftar_ptn_jur($id_jur) {
		$this->db->where('ptn_terdiri_dari_jurusan.id_jurusan_ptn',$id_jur);
		$this->db->from('ptn_terdiri_dari_jurusan');
		$this->db->join('ptn','ptn_terdiri_dari_jurusan.id_ptn=ptn.id_ptn');
		$this->db->join('jurusan_ptn','ptn_terdiri_dari_jurusan.id_jurusan_ptn=jurusan_ptn.id_jurusan_ptn');
		$result = $this->db->get();
		return $result;
	}

	public function ac_tambah_ptn_jurusan($id_jur, $nmPtn) {
		$id_jur_awal = $id_jur;
		$this->db->like('nama_ptn',$nmPtn);
		$cek_ptn = $this->db->get('ptn');
		$status ='';
		if($cek_ptn->num_rows()<1) {
			$data_ptn = array('nama_ptn'=>$nmPtn);
			$this->db->insert('ptn', $data_ptn);
		}
		
		$this->db->where('nama_ptn',$nmPtn);
		$cari_id_ptn = $this->db->get('ptn');
		foreach($cari_id_ptn->result() as $ptn) {
			$id_ptn = $ptn->id_ptn;
		}
		
		$kd_ptn_jur = "PJ".str_pad($id_ptn, 2, "0", STR_PAD_LEFT).str_pad($id_jur, 2, "0", STR_PAD_LEFT);
		
		$this->db->where('kd_ptn_jur', $kd_ptn_jur);
		$cek_kd_ptn_jur = $this->db->get('ptn_terdiri_dari_jurusan');
		if($cek_kd_ptn_jur->num_rows()<1) {
			$data_ptn = array(
				'kd_ptn_jur' => $kd_ptn_jur,
				'id_ptn' => $id_ptn,
				'id_jurusan_ptn' => $id_jur
			);
			
			$this->db->insert('ptn_terdiri_dari_jurusan', $data_ptn);
		} else {
			$status = 'Jurusan Sudah Terdaftar Pada PTN Ini';
		}
		
		
		return $status;
		
		//return $cek_kd_ptn_jur->num_rows();
	}
}

/*End of file models*/