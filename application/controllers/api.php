<?php
/**
 * JSON API
 * 
 * @author christian studer <cstuder@existenz.ch>
 */
class Api extends CI_Controller {
	/**
	 * Helper method: Output data as JSON
	 */
	protected function outputJSON($data) {
		$this->load->view('json', array('payload' => $data));
	}
	
	
}