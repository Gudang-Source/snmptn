<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index() {
		$data['title'] = 'Login Guru';
		$this->load->view('admin/form-login',$data);
	}
	
	public function do_login() {
		$nip = str_replace(' ','',$this->input->post('nip'));
		$pass = md5($this->input->post('password'));
		$this->load->model('m_guru');
		$cek = $this->m_guru->login_guru($nip, $pass);
		/*echo 'nip : '.$nip;
		echo 'pass : '.$pass;
		echo 'return : '.$cek->num_rows();
		echo $this->db->last_query();*/
		
		if ($cek->num_rows()>0) {
			//echo 'Login sukses';
			foreach($cek->result() as $g) {
				$this->session->set_userdata('id',$g->id);
				$this->session->set_userdata('nip',$g->nip);
				$this->session->set_userdata('nama',$g->nama);
			}
			$this->session->set_userdata('islogin','ok');
			$this->session->set_flashdata('status','sukses login');
			redirect('admin');
		} else {
			//echo 'Login gagal';
			$this->session->set_flashdata('status','Maaf, Username atau Password Salah');
			redirect('login');
		}
		
		//echo substr($nip, 0,8);
	}
	
	public function do_logout() {
		$this->session->sess_destroy();
		redirect('login');
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */