<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Guzzle\Http\Client;

class Maintenance extends CI_Controller
{
    private $categoryLinks = array(
        'lebensmittel' => 10,
        'prodotti-alimentari' => 10,
        'denrees-alimentaires' => 10,
        'koerperhygiene-und-kosmetik' => 9,
        'hygiene-corporelle-et-cosmetiques' => 9,
        'igiene-del-corpo-e-cosmetica' => 9,
        'baby-und-kinder' => 4,
        'bebe-e-progenie' => 4,
        'bebe-et-enfants' => 4,
        'haushalt' => 6,
        'produits-menagers' => 6,
        'casa' => 6
    );

    public function autocategorize()
    {
        $items = $this->receipts->getUncategorizedItems();

        $newVotes = array();

        foreach ($items as $item) {
            $productId = $item->productid;
            $migipediaCategories = $this->getMigipediaCategories($item->itemname);
            if (count($migipediaCategories) > 0) {
                $newVotes[$productId] = $migipediaCategories;
            }

            //TODO: try and remove substrings that are < 4 chars and search again?
        }

        $votesToSave = array();
        foreach ($newVotes as $productId => $itemData) {
            foreach ($itemData AS $categoryId => $votes) {
                $votesToSave[] = array(
                    'categoryId' => $categoryId,
                    'productId' => $productId,
                    'votes' => $votes
                );
            }
        }

        $this->receipts->saveVotes($votesToSave);
    }

    private function getMigipediaCategories($itemName)
    {
        $client = new Client();
        $return = array();

        try {
            $response = $client->get('http://www.migipedia.ch/suchen?q=title_ngram:(' . urlencode($itemName) . ')+type:product')->send();
        } catch (\Exception $e) {
            error_log('Guzzle Error: ' . $e->getMessage());

            return $return;
        }

        $xmlResponse = new SimpleXMLElement($response->getBody(true));

        if ($xmlResponse->result['numFound'][0] > 0) {
            foreach ($xmlResponse->result->doc AS $resultObject) {
                $apiCategory = substr($resultObject->str[6], 0, strpos($resultObject->str[6], '/'));
                if (!array_key_exists($apiCategory, $this->categoryLinks)) {
                    echo 'Category Link not defined for category: ' . $apiCategory . '<br />';
                    continue;
                }

                $category = $this->categoryLinks[$apiCategory];

                if (!isset($return[$category])) {
                    $return[$category] = 0;
                }

                $return[$category]++;
            }
        } else {
            echo 'Could not find item with name: ' . $itemName . '<br />';
        }

        return $return;
    }
    
    /**
     * Geocodes all stores with missing location information
     */
    public function geocodestores() {
    	$this->load->model('stores');
    
    	$this->stores->geocodeUnlocalizedStores();
    }
}
