<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_siswa extends CI_Model {
	public function get_kelas($id_kelas) {
		$this->db->where('id_kelas',$id_kelas);
		$k = $this->db->get('kelas');
		return $k->row()->nama_kelas;
	}	
	
	public function daftar_siswa($id_kelas) {
		$this->db->where('id_kelas', $id_kelas);
		$this->db->order_by('nama');
		$query = $this->db->get('siswa');
		return $query;
	}
	
	public function data_siswa($nis) {
		$this->db->where('nis', $nis);
		return $this->db->get('siswa');
	}
	
	public function ac_tambah_siswa($data) {
		$this->db->select('nis');
		$this->db->where('nis',$data['nis']);
		$cs = $this->db->get('siswa')->num_rows();
		if ($cs<1) {
			$this->db->insert('siswa',$data);
			$hasil = $this->db->affected_rows();
		} else {
			$hasil=0;
		}
		
		return $hasil;
	}
	
	public function ac_ubah_siswa($data, $nis) {
		$this->db->where('nis', $nis);
		$this->db->update('siswa',$data);
		
		return $this->db->affected_rows();
	}
	
	public function ac_hapus_siswa($nis) {
		$this->db->where('nis', $nis);
		$this->db->delete('siswa');
		
		return $this->db->affected_rows();
	}
	
	public function daftar_minat($nis) {
		$this->db->from('memilih m');
		$this->db->join('ptn_terdiri_dari_jurusan pj','m.kd_ptn_jur=pj.kd_ptn_jur');
		$this->db->join('ptn p','pj.id_ptn=p.id_ptn');
		$this->db->join('jurusan_ptn j','pj.id_jurusan_ptn=j.id_jurusan_ptn');
		$this->db->where('nis',$nis);
		$minat = $this->db->get();
		return $minat;
	}
	
	public function tambah_minat($nm_ptn, $nm_jur, $nis) {
		$this->db->from('ptn_terdiri_dari_jurusan pj');
		$this->db->join('ptn p','pj.id_ptn=p.id_ptn');
		$this->db->join('jurusan_ptn j','pj.id_jurusan_ptn=j.id_jurusan_ptn');
		$this->db->where('p.nama_ptn',$nm_ptn);
		$this->db->where('j.nama_jurusan_ptn',$nm_jur);
		$query = $this->db->get();
		
		if ($query->num_rows()<1) {
			$this->db->where('nama_jurusan_ptn',$nm_jur);
			$jur = $this->db->get('jurusan_ptn');
			if ($jur->num_rows()>0) {
				$id_jur = $jur->row()->id_jurusan_ptn;
			} else {
				$this->load->model('m_ptn');
				$this->db->where('nama_jurusan_ptn',$nm_jur);
				$cek_jur = $this->db->get('jurusan_ptn');
				$status ='';
				if($cek_jur->num_rows()<1) {
					$data_jur = array('nama_jurusan_ptn'=>$nm_jur);
					$this->db->insert('jurusan_ptn', $data_jur);
				}
				
				$this->db->where('nama_jurusan_ptn',$nm_jur);
				$cari_id_jur = $this->db->get('jurusan_ptn');
				foreach($cari_id_jur->result() as $jur) {
					$id_jur = $jur->id_jurusan_ptn;
				}
			}
			echo 'id jurusan : '.$id_jur;
			
			$this->db->where('nama_ptn',$nm_ptn);
			$ptn = $this->db->get('ptn');
			if ($ptn->num_rows()>0) {
				$id_ptn = $ptn->row()->id_ptn;
			} else {
				$this->db->like('nama_ptn',$nm_ptn);
				$cek_ptn = $this->db->get('ptn');
				$status ='';
				if($cek_ptn->num_rows()<1) {
					$data_ptn = array('nama_ptn'=>$nm_ptn);
					$this->db->insert('ptn', $data_ptn);
				}
				
				$this->db->where('nama_ptn',$nm_ptn);
				$cari_id_ptn = $this->db->get('ptn');
				foreach($cari_id_ptn->result() as $ptn) {
					$id_ptn = $ptn->id_ptn;
				}
			}
			
			$kd_ptn_jur = "PJ".str_pad($id_ptn, 2, "0", STR_PAD_LEFT).str_pad($id_jur, 2, "0", STR_PAD_LEFT);
			
			$data = array(
				'kd_ptn_jur'=>$kd_ptn_jur,
				'id_ptn'=>$id_ptn,
				'id_jurusan_ptn'=>$id_jur
			);
			$status='kd_ptn_jurusan baru';
			$this->db->insert('ptn_terdiri_dari_jurusan',$data);
		} else {
			$kd_ptn_jur = $query->row()->kd_ptn_jur;
			$status='kd_ptn_jurusan lama';
		}
		
		$this->db->select('tahun_ajaran');
		$this->db->from('siswa s');
		$this->db->join('kelas k','s.id_kelas=k.id_kelas');
		$this->db->where('nis',$nis);
		
		$tahun_ajaran= $this->db->get()->row()->tahun_ajaran;
		
		$data_minat = array(
			'kd_ptn_jur'=>$kd_ptn_jur,
			'nis'=>$nis,
			'status'=>'terima',
			'tahun_pilih'=>$tahun_ajaran
		);
		
		$this->db->where('kd_ptn_jur', $kd_ptn_jur);
		$this->db->where('nis', $nis);
		$cm = $this->db->get('memilih');
		
		if ($cm->num_rows()<1) {
			$this->db->insert('memilih', $data_minat);
		}
		
		$this->db->query('call proc_beri_peringkat("'.$nm_ptn.'","'.$nm_jur.'")');
		return $kd_ptn_jur;
	}
	
	public function hapus_minat($kd_ptn_jur, $nis) {
		$this->db->from('ptn_terdiri_dari_jurusan pj');
		$this->db->join('ptn p','pj.id_ptn=p.id_ptn');
		$this->db->join('jurusan_ptn j','pj.id_jurusan_ptn=j.id_jurusan_ptn');
		$this->db->where('pj.kd_ptn_jur',$kd_ptn_jur);
		$dptn = $this->db->get();
		$nm_ptn = $dptn->row()->nama_ptn;
		$nm_jur = $dptn->row()->nama_jurusan_ptn;
		
		$this->db->where('kd_ptn_jur',$kd_ptn_jur);
		$this->db->where('nis', $nis);
		$hapus = $this->db->delete('memilih');
		
		$this->db->query('call proc_beri_peringkat("'.$nm_ptn.'","'.$nm_jur.'")');
		
		return $this->db->affected_rows();
	}
	
	public function ubah_minat($status, $kd_ptn_jur, $nis) {
		$data = array(
			'status'=>$status
		);
		$this->db->where('kd_ptn_jur',$kd_ptn_jur);
		$this->db->where('nis', $nis);
		$hapus = $this->db->update('memilih',$data);
		return $this->db->affected_rows();
	}
}
/*End of file models*/