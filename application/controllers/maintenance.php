<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Guzzle\Http\Client;

class Maintenance extends CI_Controller
{
    public function autocategorize()
    {
        $items = $this->receipts->getUncategorizedItems();

        $newVotes = array();

        foreach ($items as $itemName) {
            $migipediaCategories = $this->getMigipediaCategories($itemName);
            if (count($migipediaCategories) > 0) {
                $newVotes[$itemName] = $migipediaCategories;
            }

            //TODO: try and remove substrings that are < 4 chars and search again?
        }

        $votesToSave = array();
        foreach ($newVotes as $itemName => $itemData) {
            foreach ($itemData AS $categoryId => $votes) {
                $votesToSave[] = array(
                    'categoryId' => $categoryId,
                    'itemName' => $itemName,
                    'votes' => $votes
                );
            }
        }

        $this->receipts->saveVotes($votesToSave);
    }

    private function getMigipediaCategories($itemName)
    {
        $categoryLinks = array(
            'lebensmittel' => 10,
            'prodotti-alimentari' => 10,
            'denrees-alimentaires' => 10,
            'koerperhygiene-und-kosmetik' => 9,
            'hygiene-corporelle-et-cosmetiques' => 9,
            'igiene-del-corpo-e-cosmetica' => 9
        );

        $client = new Client();
        $return = array();

        $response = $client->get('http://www.migipedia.ch/suchen?q=title_ngram:(' . urlencode($itemName) . ')+type:product')->send();

        $xmlResponse = new SimpleXMLElement($response->getBody(true));

        if ($xmlResponse->result['numFound'][0] > 0) {
            foreach ($xmlResponse->result->doc AS $resultObject) {
                $apiCategory = substr($resultObject->str[6], 0, strpos($resultObject->str[6], '/'));
                if (!array_key_exists($apiCategory, $categoryLinks)) {
                    echo 'Category Link not defined for category ' . $apiCategory . '<br />';
                    continue;
                }

                $category = $categoryLinks[$apiCategory];

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
}
