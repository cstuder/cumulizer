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
		$this->load->library('csvreader');
		$content = $this->csvreader->parse_file($filename);

		// ﻿Datum;Zeit;Filiale;Kassennummer;Transaktionsnummer;Artikel;Menge;Rabatt;Umsatz
		// 28.07.12,11:42,Bern - Marktgasse,34710,5752,CREA D'OR ASSORT. DELUXE,1.000,0.00,7.70
		// datetime (0,1) storeid (2, prov 1) transaction (4) itemname (5) quantity (6) discount (7) price (8) categoryid (x, prov 0) userid (y, prov 1)

		foreach ($content as $value){
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
				'userid' => 1
			);
			$this->db->insert('items', $data);
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
		$purchases = array();
		
		// TODO finish this
		
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
		
		return $summary;
	}
}
