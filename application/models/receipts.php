<?php
class Receipts extends CI_Model {
	/**
	 * Temporary fixed user ID until we get multiuser support
	 * 
	 * @var int
	 */
	protected $temporaryUserID = 1;
	
	/**
     * Database datetime format
     * 
     * @var string
	 */
	protected $datetimeformat = 'Y-m-d H:i:s';
	
	/**
	 * New uploaded receipt
	 * 
	 * - Open file
	 * - Parse CSV
	 * - Store all lines in the items database
	 */
	public function newUploadedReceipt($filename) {
		// TODO finish this
	}
	
	
	/**
	 * Get a list of all purchases for this month
	 * 
	 * @param int $year
	 * @param int $month
	 * @return array
	 */
	public function getMonthlyPurchases($year, $month) {
		$startdate = "{$year}-{$month}-01 00:00:00";
		$enddate = date($this->datetimeformat, strtotime("{$startdate} + 1 month"));
		$query = $this->db->query("SELECT datetime, itemname, quantity, discount, price, categoryid FROM items WHERE userid = ? AND datetime BETWEEN ? AND ?", array($this->temporaryUserID, $startdate, $enddate));
		
		return $query->result();
	}
	
	/**
	 * Get a sum of all purchases per month and category
	 * 
	 * @param int $startyear
	 * @param int $startmonth
	 * @param int $numberOfMonths
	 * @return array
	 */
	public function action_spendings($startyear, $startmonth, $numberOfMonths) {
		$spendings = array();
		
		$startdate = "{$startyear}-{$startmonth}-01 00:00:00";
		$enddate = date($this->datetimeformat, strtotime("{$startdate} + {$numberOfMonths} months"));
		
		$query = $this->db->query("SELECT sum(price) as pricesum, categoryid, EXTRACT(YEAR FROM `datetime`) as year, EXTRACT(MONTH FROM `datetime`) as month FROM items WHERE userid=? AND datetime BETWEEN ? AND ? GROUP BY month, year, categoryid", array($this->temporaryUserID, $startdate, $enddate));
		
		// TODO continue here
		
		// Mock data
		$spendings[] = array(10 => 22.30, 3 => 11.40);
		$spendings[] = array(10 => 2.30, 3 => 11.40);
		$spendings[] = array(10 => 223.30, 4 => 11.40);
		$spendings[] = array(10 => 2.30, 4 => 110.40);
		$spendings[] = array(10 => 42.30, 4 => 11.40);
		$spendings[] = array(10 => 22.30, 3 => 11.40);
		$spendings[] = array(10 => 12.30, 3 => 11.40);
		$spendings[] = array(10 => 52.30, 3 => 1.40);
		$spendings[] = array(10 => 32.30, 3 => 3.40);
		$spendings[] = array(10 => 22.30, 3 => 1.40);
		$spendings[] = array(9 => 22.30, 3 => 11.50);
		$spendings[] = array(10 => 22.30, 3 => 11.40);
		
		return $spendings;
	}
	
	/**
	 * Get a summary of the purchases of this year
	 * 
	 * @param int $year
	 * @return array
	 */
	public function getYearlySummary($year) {
		$summary = array();
		
		// TODO finish this
		
		// Mock data
		$summary = array(
			'numberOfPurchases' => 614,
			'inSeasonFruits' => 33,
			'meat' => 12,
			'totalPrice' => 1234.40,
			'totalDiscount' => 42.20,
		);
		
		return $summary;
	}
	
	/**
	 * Get all categories
	 * 
	 * @return array
	 */
	public function getCategories() {
		$categories = array();
		
		$query = $this->db->get('categories');
		foreach($query->result() as $row) {
			$categories[$row->id] = $row->categoryname;
		}
		
		return $categories;
	}
}