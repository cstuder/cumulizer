<?php
class Receipts extends CI_Model {
	/**
	 * Temporary fixed user ID until we get multiuser support
	 * 
	 * @var int
	 */
	protected $temporaryUserID = 1;
	
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
		$purchases = array();
		
		// TODO finish this
		
		// Mock data
		$purchases[] = array('datetime' => strtotime('2011-05-27 20:28:00'), 'itemname' => 'MB KARTOFFELGNOCCHI  700G', 'quantity' => 1, 'discount' => 0, 'price' => 2.75, 'categoryid' => 10);
		$purchases[] = array('datetime' => strtotime('2011-05-27 20:28:00'), 'itemname' => 'AGNESI ELICHE', 'quantity' => 1, 'discount' => 0.45, 'price' => 1.6, 'categoryid' => 10);
		$purchases[] = array('datetime' => strtotime('2011-05-27 20:28:00'), 'itemname' => 'BIO ITALIEN.SALAMI   MAXI', 'quantity' => 0.102, 'discount' => 1.05, 'price' => 4.15, 'categoryid' => 10);
		$purchases[] = array('datetime' => strtotime('2011-05-27 20:28:00'), 'itemname' => ';M-CLAS MAYONNAISE 170G TB', 'quantity' => 1, 'discount' => 0, 'price' => 1.30, 'categoryid' => 2);
		$purchases[] = array('datetime' => strtotime('2011-05-27 20:28:00'), 'itemname' => 'M-CLAS COTTAGE CHEESE NAT', 'quantity' => 1, 'discount' => 0, 'price' => 1.60, 'categoryid' => 9);
		$purchases[] = array('datetime' => strtotime('2011-05-27 20:28:00'), 'itemname' => 'GURKEN TP         ST S.', 'quantity' => 1, 'discount' => 0, 'price' => 1.60, 'categoryid' => 9);
		
		return $purchases;
	}
	
	/**
	 * Get a sum of all purchases per month and category
	 * 
	 * @param int $startyear
	 * @param int $startmonth
	 * @param int $numberOfMonths
	 */
	public function action_spendings($startyear, $startmonth, $numberOfMonths) {
		$spendings = array();
		
		// TODO finish this
		
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
}