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
	
	/**
	 * Shows a simple upload form to add single files to the database
	 * 
	 */
	public function simpleupload()
	{
		// Check for upload
		$config = array();
		$config['upload_path'] = sys_get_temp_dir() . '/';
		$config['allowed_types'] = 'csv';
		$config['max_size']	= '2048';
		$this->load->library('upload', $config);
		
		if($this->upload->do_upload()) {
			$upload = $this->upload->data();
			$message = "File uploaded: " . $upload['file_name'];
			// Insert file into database
			$this->receipts->newUploadedReceipt($upload['full_path']);
		} else {
			$message = $this->upload->display_errors();
		}
		
		$this->load->view('simpleuploadform', array('message' => $message));
	}
	
	/**
	 * Shows a heatmap with the sales
	 */
	public function heatmap()
	{
		$this->load->view('heatmap');
	}

    public function vote()
    {
        if (!$this->input->get('productid') || $this->input->get('categoryid') === false) {
            return show_error('Bad Parameters', 400);
        }

        $this->receipts->saveVotes(array(array(
            'categoryId' => $this->input->get('categoryId'),
            'productId' => $this->input->get('productId'),
            'votes' => 1
        )));
    }

    public function getCategoryVoteData()
    {
        $product = $this->receipts->getRandomProduct();

        $output = array('product' => array(
            'name' => $product->itemname,
            'id' => $product->id
        ));
        $output['categories'] = array();

        $categories = $this->receipts->getCategories();
        $randomCategoryIds = array_rand($categories, 3);

        foreach ($randomCategoryIds as $categoryId) {
            $output['categories'][] = array('id' => $categoryId, 'name' => $categories[$categoryId]);
        }

        $this->load->view('json', array('payload' => $output));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
