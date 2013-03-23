<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	/**
	 * Geocodes all stores with missing location information
	 */
	public function geocodestores() {
		$this->load->model('stores');
		
		$this->stores->geocodeUnlocalizedStores();
	}

}
