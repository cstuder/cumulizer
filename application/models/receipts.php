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
		$this->load->library('csvreader');
		$content = $this->csvreader->parse_file($filename);
		$userid = 1;

		// ﻿Datum;Zeit;Filiale;Kassennummer;Transaktionsnummer;Artikel;Menge;Rabatt;Umsatz
		// 28.07.12,11:42,Bern - Marktgasse,34710,5752,CREA D'OR ASSORT. DELUXE,1.000,0.00,7.70
		// datetime (0,1) storeid (2, prov 1) transaction (4) itemname (5) quantity (6) discount (7) price (8) categoryid (x, prov 0) userid (y, prov 1)

		// read only unique receipts
		$array = array('userid' => $userid, 'transaction' => $content[0]['Transaktionsnummer']);
		$this->db->where($array); 
		$this->db->from('items');
		$count = $this->db->count_all_results();

		if($count == 0){
			foreach ($content as $value){
				$transaction0 = 0;
				// only real items (no cumulus points etc.)
				if(floatval($value['Umsatz']) > 0){
					// var_dump($value); die();
					$date = explode ('.', $value['﻿Datum']);
					// datetime: e.g. 2012-03-22 18:09:59
					$datetime = "20".$date[2]."-".$date[1]."-".$date[0]." ".$value['Zeit'].":00";
					$data = array(
						'datetime' => $datetime,
						'storeid' => 1,
						'transaction' => $value['Transaktionsnummer'],
						'itemname' => $value['Artikel'],
						'quantity' => $value['Menge'],
						'discount' => $value['Rabatt'],
						'price' => $value['Umsatz'],
						'categoryid' => 0,
						'userid' => $userid
					);
					$this->db->insert('items', $data);
				}
			}
		}
		return $content; // comma separated
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
	public function getMonthlySpendings($startyear, $startmonth, $numberOfMonths) {
		$spendings = array();
		
		$startdate = "{$startyear}-{$startmonth}-01 00:00:00";
		$enddate = date($this->datetimeformat, strtotime("{$startdate} + {$numberOfMonths} months"));
		
		$query = $this->db->query("SELECT sum(price) as pricesum, categoryid, EXTRACT(YEAR FROM `datetime`) as year, EXTRACT(MONTH FROM `datetime`) as month FROM items WHERE userid=? AND datetime BETWEEN ? AND ? GROUP BY month, year, categoryid", array($this->temporaryUserID, $startdate, $enddate));
		
		return $query->result();
	}
	
	/**
	 * Get a summary of the purchases of this year
	 * 
	 * - numberOfPurchases
	 * - totalPrice
	 * - totalDiscount
	 * - numberOfShoppingTrips
	 * - averagePrice
	 * - averageShoppingTripPrice
	 * - averageNumberOfPurchasesPerShoppingTrip
	 * - mostExpensivePurchase
	 * - mostExpensiveShoppingTrip
	 * - cheapestPurchase
	 * - cheapestShoppingTrip 
	 * 
	 * @param int $year
	 * @return array
	 */
	public function getYearlySummary($year) {
		$summary = array();

		$startdate = "{$year}-01-01 00:00:00";
		$enddate = date($this->datetimeformat, strtotime("{$startdate} +1 year"));
		
		// Purchase information
		$query = $this->db->query("SELECT count(id) as numberOfPurchases, sum(price) as totalPrice, sum(discount) as totalDiscount, avg(price) as averagePrice, max(price) as mostExpensivePurchase, min(price) as cheapestPurchase FROM items WHERE userid=? AND datetime BETWEEN ? AND ?", array($this->temporaryUserID, $startdate, $enddate));		
		$summary = $query->row_array();
		
		// Shopping trip information
		$query = $this->db->query("SELECT count(numberOfItems) as numberOfShoppingTrips, avg(price) as averageShoppingTripPrice, max(price) as mostExpensiveShoppingTrip, min(price) as cheapestShoppingTrip, avg(numberOfItems) as averageNumberOfPurchasesPerShoppingTrip FROM (SELECT count(id) as numberOfItems, sum(price) as price FROM items WHERE userid=? AND datetime BETWEEN ? AND ? GROUP BY transaction) as trips", array($this->temporaryUserID, $startdate, $enddate));
		$summary = array_merge($summary, $query->row_array());
		
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
