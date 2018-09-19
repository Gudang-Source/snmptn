<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_homepage extends CI_Model {
	public function ambil_data_kelulusan() {
		$this->db->select('p.id_ptn, nama_ptn, count(nis) as jml_lulus');
		$this->db->from('memilih m');
		$this->db->join('ptn_terdiri_dari_jurusan pj', 'm.kd_ptn_jur=pj.kd_ptn_jur');
		$this->db->join('ptn p','pj.id_ptn=p.id_ptn');
		$this->db->where('m.status','terima');
		$this->db->order_by('jml_lulus','desc');
		$this->db->group_by('p.id_ptn');
		$data = $this->db->get();
		return $data;
	}
	
	public function ambil_nama_ptn($id_ptn) {
		$this->db->where('id_ptn',$id_ptn);
		$data = $this->db->get('ptn');
		return $data->row()->nama_ptn;
	}
	
	public function data_lulus_by_ptn($id_ptn, $thn=null) {
		if (!isset($thn)) {
			$this->db->select('CONCAT("'.$id_ptn.'/", tahun_pilih ) data_url, tahun_pilih, count(nis) as jml_lulus');
			$this->db->from('memilih m');
			$this->db->join('ptn_terdiri_dari_jurusan pj', 'm.kd_ptn_jur=pj.kd_ptn_jur');
			$this->db->join('ptn p','pj.id_ptn=p.id_ptn');
			$this->db->where('m.status','terima');
			$this->db->where('p.id_ptn',$id_ptn);
			$this->db->order_by('tahun_pilih, jml_lulus','desc');
			$this->db->group_by('tahun_pilih');
			$data = $this->db->get();
		} else {
			$this->db->select('nama_jurusan_ptn, count(nis) as jml_lulus');
			$this->db->from('memilih m');
			$this->db->join('ptn_terdiri_dari_jurusan pj', 'm.kd_ptn_jur=pj.kd_ptn_jur');
			$this->db->join('jurusan_ptn j','pj.id_jurusan_ptn=j.id_jurusan_ptn');
			$this->db->where('m.status','terima');
			$this->db->where('pj.id_ptn',$id_ptn);
			$this->db->where('m.tahun_pilih',$thn);
			$this->db->order_by('jml_lulus','desc');
			$this->db->group_by('nama_jurusan_ptn');
			$data = $this->db->get();
		}
		return $data;
	}
	
	public function ambil_data_prediksi($id_ptn=null, $nilai=null, $acuan) {
				
		if($this->input->post('jml_nilai')!=0 && $this->input->post('jurusan')=='' && $this->input->post('ptn')=='' ) {
			// hanya jumlah nilai
			$w = "having min(".$acuan.")<=".$this->input->post('jml_nilai');
			
			$data = $this->db->query("select pj.id_ptn, p.nama_ptn, min(minim) minim, max(maxim) maxim, sum(jml_terima) jml_terima from ptn_terdiri_dari_jurusan pj join (select kd_ptn_jur, min(".$acuan.") minim, max(".$acuan.") maxim, count(nis) jml_terima from (select pj.kd_ptn_jur, jnmp.nis, ".$acuan." from (select nis, sum(".$acuan.") ".$acuan." from nilai_akhir group by nis) jnmp join memilih m on (jnmp.nis=m.nis) join ptn_terdiri_dari_jurusan pj on (m.kd_ptn_jur=pj.kd_ptn_jur) where status='terima' order by id_jurusan_ptn) jn group by kd_ptn_jur ".$w.") mm on (pj.kd_ptn_jur=mm.kd_ptn_jur) join ptn p on (pj.id_ptn=p.id_ptn) group by pj.id_ptn");
		} else if($this->input->post('jml_nilai')!=0 && $this->input->post('ptn')!='' && $this->input->post('jurusan')!='') {
			// jumlah nilai dan ptn dan jurusan
			
			$cn = $this->input->post('jml_nilai');
			$cp = "and nama_ptn like '%".$this->input->post('ptn')."%'";
			$cp .= " and nama_jurusan_ptn like '%".$this->input->post('jurusan')."%'";
			
			$w = "having min(".$acuan.")<=".$cn;
			
			$data = $this->db->query("select id_jurusan_ptn, nama_jurusan_ptn, min(".$acuan.") minim, max(".$acuan.") maxim, count(nis) jml_terima from (select pj.id_jurusan_ptn, j.nama_jurusan_ptn, jnmp.nis, ".$acuan." from (select nis, sum(".$acuan.") ".$acuan." from nilai_akhir group by nis) jnmp join memilih m on (jnmp.nis=m.nis) join ptn_terdiri_dari_jurusan pj on (m.kd_ptn_jur=pj.kd_ptn_jur) join ptn p on (pj.id_ptn=p.id_ptn) join jurusan_ptn j on (pj.id_jurusan_ptn=j.id_jurusan_ptn) where status='terima' ".$cp." order by pj.id_jurusan_ptn) jn group by id_jurusan_ptn, nama_jurusan_ptn ".$w." order by jml_terima desc");
		} else if($this->input->post('jml_nilai')!=0 && $this->input->post('jurusan')!='') {
			// jumlah nilai dan jurusan
			$w = "having min(".$acuan.")<=".$this->input->post('jml_nilai');
			$w2 = " and nama_jurusan_ptn like '%".$this->input->post('jurusan')."%'";
			
			$data = $this->db->query("select pj.id_ptn, p.nama_ptn, min(minim) minim, max(maxim) maxim, sum(jml_terima) jml_terima from ptn_terdiri_dari_jurusan pj join (select kd_ptn_jur, min(".$acuan.") minim, max(".$acuan.") maxim, count(nis) jml_terima from (select pj.kd_ptn_jur, jnmp.nis, ".$acuan." from (select nis, sum(".$acuan.") ".$acuan." from nilai_akhir group by nis) jnmp join memilih m on (jnmp.nis=m.nis) join ptn_terdiri_dari_jurusan pj on (m.kd_ptn_jur=pj.kd_ptn_jur) join jurusan_ptn j on (pj.id_jurusan_ptn=j.id_jurusan_ptn) where status='terima' and nama_jurusan_ptn like '%".$this->input->post('jurusan')."%' order by pj.id_jurusan_ptn) jn group by kd_ptn_jur ".$w.") mm on (pj.kd_ptn_jur=mm.kd_ptn_jur) join ptn p on (pj.id_ptn=p.id_ptn) group by id_ptn");
		} else if(($this->input->post('jml_nilai')!=0 && $this->input->post('ptn')!='') || (isset($id_ptn) && isset($nilai))) {
			// jumlah nilai dan ptn
			if ($this->input->post('jml_nilai')!=0 || $this->input->post('jml_nilai')!='') {
				$cn = $this->input->post('jml_nilai');
				$cp = "and nama_ptn like '%".$this->input->post('ptn')."%'";
			} else {
				$cn = $nilai;
				$cp = "and p.id_ptn = ".$id_ptn;
			}
			
			$w = "having min(".$acuan.")<=".$cn;
			
			$data = $this->db->query("select id_jurusan_ptn, nama_jurusan_ptn, min(".$acuan.") minim, max(".$acuan.") maxim, count(nis) jml_terima from (select pj.id_jurusan_ptn, j.nama_jurusan_ptn, jnmp.nis, ".$acuan." from (select nis, sum(".$acuan.") ".$acuan." from nilai_akhir group by nis) jnmp join memilih m on (jnmp.nis=m.nis) join ptn_terdiri_dari_jurusan pj on (m.kd_ptn_jur=pj.kd_ptn_jur) join ptn p on (pj.id_ptn=p.id_ptn) join jurusan_ptn j on (pj.id_jurusan_ptn=j.id_jurusan_ptn) where status='terima' ".$cp." order by pj.id_jurusan_ptn) jn group by id_jurusan_ptn, nama_jurusan_ptn ".$w." order by jml_terima desc");
		} else {
			$data = $this->db->query("select pj.id_ptn, p.nama_ptn, min(minim) minim, max(maxim) maxim, sum(jml_terima) jml_terima from ptn_terdiri_dari_jurusan pj join (select kd_ptn_jur, min(".$acuan.") minim, max(".$acuan.") maxim, count(nis) jml_terima from (select pj.kd_ptn_jur, jnmp.nis, ".$acuan." from (select nis, sum(".$acuan.") ".$acuan." from nilai_akhir group by nis) jnmp join memilih m on (jnmp.nis=m.nis) join ptn_terdiri_dari_jurusan pj on (m.kd_ptn_jur=pj.kd_ptn_jur) join jurusan_ptn j on (pj.id_jurusan_ptn=j.id_jurusan_ptn) where status='terima' order by pj.id_jurusan_ptn) jn group by kd_ptn_jur) mm on (pj.kd_ptn_jur=mm.kd_ptn_jur) join ptn p on (pj.id_ptn=p.id_ptn) group by id_ptn");
		}
		
		/*$this->db->select($data.'min(jml_nilai_mp) minim, max(jml_nilai_mp) maxim');
		$this->db->from('siswa s');
		$this->db->join('(select nis, sum(jml_nilai_mp) jml_nilai_mp from nilai_akhir group by nis) jnmp','s.nis=jnmp.nis');
		$this->db->join('memilih m','s.nis=m.nis');
		$this->db->join('ptn_terdiri_dari_jurusan pj', 'm.kd_ptn_jur=pj.kd_ptn_jur');
		$this->db->join('ptn p','pj.id_ptn=p.id_ptn');
		$this->db->join('jurusan_ptn j','pj.id_jurusan_ptn=j.id_jurusan_ptn');
		$this->db->where('m.status','terima');
		if($this->input->post('jml_nilai')!="") {
			$this->db->having('min(jml_nilai_mp) <=',$this->input->post('jml_nilai')+0);
		}
		if ($this->input->post('jurusan')!="") {
			$this->db->like('nama_jurusan_ptn',$this->input->post('jurusan'));
		}
		$this->db->order_by('jml_terima','desc');
		$this->db->group_by($gb);
		$data = $this->db->get();
		*/
		return $data;
	}
	
	public function cek_kd_ptn_jur($nm_ptn, $nm_jur) {
		$this->db->select('kd_ptn_jur');
		$this->db->from('ptn_terdiri_dari_jurusan pj');
		$this->db->join('ptn p','pj.id_ptn=p.id_ptn');
		$this->db->join('jurusan_ptn j','pj.id_jurusan_ptn=j.id_jurusan_ptn');
		$this->db->where('nama_ptn',$nm_ptn);
		$this->db->where('nama_jurusan_ptn',$nm_jur);
		$data = $this->db->get();
		return $data;
	}
	
	public function daftar_peringkat($nm_ptn, $nm_jur) {
		$this->db->select('s.nama, jml_nilai_mp, peringkat');
		$this->db->from('siswa s');
		$this->db->join('(select nis, sum(jml_nilai_mp) jml_nilai_mp from nilai_akhir group by nis) jnmp','s.nis=jnmp.nis');
		$this->db->join('memilih m','s.nis=m.nis');
		$this->db->join('ptn_terdiri_dari_jurusan pj', 'm.kd_ptn_jur=pj.kd_ptn_jur');
		$this->db->join('ptn p','pj.id_ptn=p.id_ptn');
		$this->db->join('jurusan_ptn j','pj.id_jurusan_ptn=j.id_jurusan_ptn');
		$this->db->where('m.status','proses');
		$this->db->where('nama_ptn',$nm_ptn);
		$this->db->where('nama_jurusan_ptn',$nm_jur);
		$this->db->order_by('peringkat');
		$data = $this->db->get();
		return $data;
	}
}
/*End of file models*/