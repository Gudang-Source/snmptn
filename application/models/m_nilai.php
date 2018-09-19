<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_nilai extends CI_Model {
	public function daftar_mp ($jur) {
		$query = $this->db->query('select distinct nama_mp from mata_pelajaran where substr(kd_mp,6,1)='.$jur);
		return $query;
	}
	
	public function next_kd_mp ($jur, $smtr, $nm_mp) {
		$query_kd_mp = $this->db->query('select max(substr(kd_mp,3,2)) as kd_mp from mata_pelajaran where semester='.$smtr);
		
		$cek_mp = $this->db->query('select distinct substr(kd_mp,3,2) as kd_mp from mata_pelajaran where nama_mp="'.$nm_mp.'"');
		
		foreach($query_kd_mp->result() as $kd) {
			if ($cek_mp->row()->kd_mp!='') {
				$kd_mp = $cek_mp->row()->kd_mp;
			} else {
				$kd_mp = (int)$kd->kd_mp+1;
			}
			$next_kd_mp = "MP".str_pad($kd_mp, 2, "0", STR_PAD_LEFT).$smtr.$jur;
		}

		return $next_kd_mp;
	}
	
	public function tambah_mp ($data) {
		$query = $this->db->query('select kd_mp from mata_pelajaran where substr(kd_mp,1,4) = "MP'.$data['semester'].$data['jurusan'].'" and nama_mp = "'.$data['nama_mp'].'"');
		
		$cek_mp = $query->num_rows();
		if ($cek_mp<1) {
			$this->db->insert('mata_pelajaran',$data);
		}
		return $cek_mp;
	}
	
	public function cek_mp() {
		$this->db->select('kd_mp');
		$this->db->like('nama_mp',$nm_mp);
		$mp = $this->db->get('mata_pelajaran');
		if ($mp->num_rows()>=5) {
			return false;
		} else {
			return true;
		}
	}
	
	public function daftar_kkm($nm_mp, $jurusan) {
		$this->db->select('kd_mp, semester, kkm');
		$this->db->where('nama_mp', $nm_mp);
		$this->db->where('jurusan', $jurusan);
		$query = $this->db->get('mata_pelajaran');
		return $query;
	}
	
	public function ubah_kkm($kd_mp, $data) {
		$cari = $this->db->query('select count(*) as jml from mata_pelajaran where kd_mp="'.$kd_mp.'"');
		
		foreach($cari->result() as $j) {
			$jml = $j->jml;
		}
		
		if ($jml<1) {
			$data = array(
				'kd_mp' => $kd_mp,
				'nama_mp' => $data['nama_mp'],
				'kkm' => $data['kkm'],
				'semester' => $data['semester'],
				'jurusan' => $data['jurusan'],
				'ket_mp_un' => $data['ket_mp_un']
			);
			$query = $this->db->query('select kd_mp from mata_pelajaran where substr(kd_mp,1,4) = "MP'.$data['semester'].$data['jurusan'].'" and nama_mp = "'.$data['nama_mp'].'"');
		
			$cek_mp = $query->num_rows();
			if ($cek_mp<1) {
				$this->db->insert('mata_pelajaran',$data);
			}
			
			return $cek_mp;
		} else {
			$this->db->where('kd_mp', $kd_mp);
			$this->db->update('mata_pelajaran', $data);
		}
	}
	
	public function hapus_kkm($kd_mp) {
		$this->db->where('kd_mp', $kd_mp);
		$this->db->delete('mata_pelajaran');
		return $this->db->affected_rows();
	}
	
	public function daftar_mp_smt($nis, $smt) {
		$mp = $this->db->query('select nis, mp.kd_mp, nama_mp, kkm, nilai from mengambil_mp amp join mata_pelajaran mp on (amp.kd_mp=mp.kd_mp) where nis="'.$nis.'" and substr(mp.kd_mp,5,1)="'.$smt.'" order by kd_mp ');
		return $mp;
	}
	
	public function daftar_mp_un($nis) {
		$this->db->where('nis',$nis);
		$this->db->join('ujian_nasional un','un.kd_mp_un=mu.kd_mp_un');
		$mp = $this->db->get('mengerjakan_un mu');
		return $mp;
	}
	
	public function ubah_nilai($nis, $kd_mp, $data) {
		$this->db->where('kd_mp',$$kd_mp);
		$cmp = $this->db->get('mata_pelajaran')->num_rows();
		
		if ($cmp>1) {
			$this->db->where('nis', $nis);
			$this->db->where('kd_mp', $kd_mp);
			$ubah = $this->db->update('mengambil_mp',$data);
		} else {
			$this->db->where('nis', $nis);
			$this->db->where('kd_mp_un', $kd_mp);
			$ubah = $this->db->update('mengerjakan_un',$data);
		}
		
		return $this->db->affected_rows();
	}
}

/*End of file models*/