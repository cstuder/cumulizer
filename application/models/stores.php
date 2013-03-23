<?php
/**
 * Stores model
 * 
 * @author christian studer <cstuder@existenz.ch>
 */
class Stores extends CI_Model {
	protected $nominatimUrl = 'http://open.mapquestapi.com/nominatim/v1/search.php?format=json&osm_type=N&limit=1&q=';
	
	public function geocodeUnlocalizedStores() {
		// Find unloclized stores
		$query = $this->db->query("SELECT id, storename FROM stores WHERE lat IS NULL or lon IS NULL");
		
		foreach($query->result() as $row) {
			// Find stores
			$url = $this->nominatimUrl . $row->storename . ', Schweiz';
			
			$response = @json_decode(file_get_contents($url));
			
			if(!empty($response) and isset($response[0])) {
				$store = $response[0];
				
				if(isset($store->lat, $store->lon, $store->display_name)) {
					$this->db->where('id', $row->id)->update('stores', array('lat' => $store->lat, 'lon' => $store->lon, 'address' => $store->display_name));
				}
			}
		}
	}
}