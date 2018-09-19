<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sidang extends CI_Controller {
	public function prediksi() {
		$id_ptn = 1;
		$this->load->model('m_ptn');
		$data['jur'] = $this->m_ptn->daftar_jurusan($id_ptn);
		//echo $this->db->last_query();
		$this->load->view('prediksi-itb.php',$data);
	}
	
	public function tampilkan_prediksi() {
		$nilai = $this->input->post('jml_nilai');
		$jur = $this->input->post('jur');
		
		$passing_grade = array("1"=>"2500","2"=>"2600");
		
		
		if ($nilai>=$passing_grade[$jur]) {
			echo 'Anda Lulus';
		} else {
			echo 'Anda Tidak Lulus';
		}
		/*
		$w = "having min(jml_nilai_mp_un)<=".$nilai;
		$w2 = " and nama_jurusan_ptn like '%".$this->input->post('jurusan')."%'";
		
		$data = $this->db->query("select pj.id_ptn, p.nama_ptn, min(minim) minim, max(maxim) maxim, sum(jml_terima) jml_terima from ptn_terdiri_dari_jurusan pj join (select kd_ptn_jur, min(jml_nilai_mp_un) minim, max(jml_nilai_mp_un) maxim, count(nis) jml_terima from (select pj.kd_ptn_jur, jnmp.nis, jml_nilai_mp_un from (select nis, sum(jml_nilai_mp_un) jml_nilai_mp_un from nilai_akhir group by nis) jnmp join memilih m on (jnmp.nis=m.nis) join ptn_terdiri_dari_jurusan pj on (m.kd_ptn_jur=pj.kd_ptn_jur) join jurusan_ptn j on (pj.id_jurusan_ptn=j.id_jurusan_ptn) where status='terima' and j.id_jurusan_ptn = '".$jur."' order by pj.id_jurusan_ptn) jn group by kd_ptn_jur ".$w.") mm on (pj.kd_ptn_jur=mm.kd_ptn_jur) join ptn p on (pj.id_ptn=p.id_ptn) group by id_ptn");
		*/
	}
}