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
		$storeid = 1;
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
				// only real items (no cumulus points etc.)
				if(floatval($value['Umsatz']) > 0){

					// get storeid, if non-existent create one
					$array = array('storename' => $value['Filiale']);
					$this->db->where($array);
					$this->db->from('stores');
					$this->db->select('id');
					$count = $this->db->count_all_results();
					if($count == 0){
						$data = array(
							'storename' => $value['Filiale']
						);
						$this->db->insert('stores', $data);
						$storeid = $this->db->insert_id();
					}else{
						$array = array('storename' => $value['Filiale']);
						$this->db->where($array);
						$this->db->select('id');
						$query = $this->db->get('stores');
						$row = $query->row();
						$storeid = $row->id;
					}
					// var_dump($value); die();
					$date = explode ('.', $value['﻿Datum']);
					// datetime: e.g. 2012-03-22 18:09:59
					$datetime = "20".$date[2]."-".$date[1]."-".$date[0]." ".$value['Zeit'].":00";

                    $query = $this->db->query("
                        SELECT *
                        FROM product
                        WHERE itemname = '" . $this->db->escape_str($value['Artikel']) . "'
                    ");

                    if ($query->num_rows() > 0) {
                        $product = $query->row();
                        $productId = $product->id;
                    } else {
                        $this->db->insert('product', array('itemname' => $value['Artikel']));
                        $productId = $this->db->insert_id();
                    }

					$data = array(
						'datetime' => $datetime,
						'storeid' => $storeid,
						'transaction' => $value['Transaktionsnummer'],
						'product' => $productId,
						'quantity' => $value['Menge'],
						'discount' => $value['Rabatt'],
						'price' => $value['Umsatz'],
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
		$query = $this->db->query("
		    SELECT items.datetime, items.quantity, items.discount, items.price, items.product AS productid, product.itemname
		    FROM items
		    INNER JOIN product ON (product.id = items.product)
		    WHERE userid = ? AND datetime BETWEEN ? AND ?",
            array($this->temporaryUserID, $startdate, $enddate)
        );

        $items = $query->result();
        $productIds = array();
        foreach ($items as $item) {
            $productIds[] = $item->productid;
        }
        $categories = $this->getProductCategories($productIds);

        $indexedCategories = array();
        foreach ($categories AS $category) {
            $productId = $category->productid;
            $indexedCategories[$productId] = $category->categoryid;
        }

        foreach ($items as &$item) {
            $item->category = 0;
            $productId = $item->productid;
            if (isset($indexedCategories[$productId])) {
                $item->category = $indexedCategories[$productId];
            }
        }

		return $items;
	}

    public function getProductCategories(array $productIds)
    {
        $query = $this->db->query("
            SELECT *, MAX(votes)
            FROM autocategorizations
            WHERE productid IN (" . implode(', ', $productIds) . ")
            GROUP BY productid, categoryid
        ");

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

    public function getRandomProduct() {
        return $this->db->order_by('*', 'random')->get('product')->row();
    }

	/**
	 * Get all stores and their sales there
	 * 
	 * @return array
	 */
	public function getStoresAndMoney() {
		$query = $this->db->query('SELECT stores.storename, stores.lat, stores.lon, sum(items.price) as sales FROM stores, items WHERE stores.id=items.storeid GROUP BY items.storeid');
		return $query->result();
	}

    public function getUncategorizedItems() {
        $query = $this->db->query("
            SELECT DISTINCT product.itemname, product.id AS productid
            FROM product
            LEFT JOIN autocategorizations ON (autocategorizations.productid = product.id)
            WHERE autocategorizations.id IS NULL
        ");

        return $uncategorizedItems = $query->result();
    }

    public function saveVotes(array $votes) {
        foreach ($votes as $vote) {
            $this->db->query("
                INSERT INTO autocategorizations
                    (categoryid, productid, votes)
                VALUES
                    (" . (int)$vote['categoryId'] . ",
                    " . (int)$vote['productId'] . ",
                    " . (int)$vote['votes'] . ")
                ON DUPLICATE KEY UPDATE
                    votes=votes+" . (int)$vote['votes']
            );
        }
    }
}
