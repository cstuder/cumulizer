<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function simpleupload()
	{
		// Check for upload
		$config = array();
		$config['upload_path'] = sys_get_temp_dir() . '/';
		$config['allowed_types'] = 'csv';
		$config['max_size']	= '100';
		$this->load->library('upload', $config);
		
		if($this->upload->do_upload()) {
			$upload = $this->upload->data();
			$message = "File uploaded: " . $upload['file_name'];
			// Insert file into database
			$this->receipts->newUploadedReceipt($upload['full_path']);
		} else {
			$message = $this->upload->display_errors();
		}
		
		$this->load->view('simpleuploadform.php', array('message' => $message));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
