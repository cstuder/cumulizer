<?php
/**
 * JSON API
 * 
 * @author christian studer <cstuder@existenz.ch>
 */
class Api extends CI_Controller {
	/**
	 * General API handler
	 * 
	 * All API requests pass through here, with the 'action' as GET-parameter
	 */
	public function index() {
		$action = 'action_' . $this->input->get('action');
		
		if(is_callable(array($this, $action))) {
			$this->outputJSON($this->$action());
		} else {
			$this->outputJSONError("Unknown API action.");
		}
	}
	
	/**
	 * Show monthly purchases
	 * 
	 * Parameters:
	 * 	year
	 * 	month
	 * 
	 * @return array
	 */
	public function action_monthlypurchases() {
		$year = intval($this->input->get('year'));
		if($year < 1900) $year = date('Y');
		
		$month = intval($this->input->get('month'));
		if($month < 1 or $month > 12) $month = date('m');
		
		return $this->receipts->getMonthlyPurchases($year, $month);
	}
	
	/**
	 * Get yearly usmmary of purchases
	 * 
	 * Parameters:
	 *  year
	 *  
	 * @return array
	 */
	public function action_summary() {
		$year = intval($this->input->get('year'));
		if($year < 1900) $year = date('Y');
		
		return $this->receipts->getYearlySummary($year);
	}
	
	/**
	 * Get monthly spendings
	 * 
	 * Parameters:
	 * 	year
	 * 	month
	 * 	numberofmonths
	 * 
	 * @return array
	 */
	public function action_spendings() {
		$year = intval($this->input->get('year'));
		if($year < 1900) $year = date('Y');
		
		$month = intval($this->input->get('month'));
		if($month < 1 or $month > 12) $month = date('m');
		
		$numberOfMonths = intval($this->input->get('numberofmonths'));
		if($numberOfMonths < 1) $numberOfMonths = 12;
		
		return $this->receipts->getMonthlySpendings($year, $month, $numberOfMonths);
	}

	/**
	 * Helper method: Output data as JSON
	 * 
	 * @param mixed $data
	 */
	protected function outputJSON($data) {
		$this->load->view('json', array('payload' => $data));
	}
	
	/**
	 * Helper method: Output JSON error message
	 * 
	 * @param string $message
	 */
	protected function outputJSONError($message) {
		$this->output->set_status_header(400);
		$this->outputJSON(array('error' => $message));
	}
}