<?php namespace App\Models\Services;

use File;
use Exception;
use GuzzleHttp\Client;

/**
 * Class that returns Array for JSON response
 */
class CurrencyService {

    private $currency_path;

    /**
     * Initialize the class and set properties
     * 
     * @param Request $request
     */
    public function __construct() {

        $this->currency_path = storage_path('json/currencies.json');
    }


    /**
     * Get currencies list.
     * 
     * @return Array
     */
    private function currencies() {
        
        $currencies = [];
        
        try {
            $json_file = File::get( $this->currency_path );
            if( json_decode( $json_file ) != null ) {
                $currencies = json_decode( $json_file );
            }
        } catch (Exception $ex) {
            return $currencies;
        }
        
        return $currencies;
    }
    
    
    /**
     * Check if given currency exists.
     * 
     * @param String $currency
     */
    public function checkCurrency( $currency ) {

        $currencies = $this->currencies();
        
        if( in_array( $currency, $currencies ) ) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Make the API call
     * @param string $cuurency
     * @return Mixed
     */
    public function getRate( $currency ) {
        
        $client   = new Client(['verify' => false, 'exceptions' => false]);
        $response = $client->request( 'GET', $this->getAPIUrl( $currency ) );
        if( $response->getStatusCode() != 200 ) {
            return false;
        }
        $result = $response->getBody();
        $decoded = json_decode( $result, true );
	$rate = $decoded['query']['results']['rate'];
        
        return $rate;
    }
    
    /**
     * Get url of the API server
     * 
     * @link https://developer.yahoo.com/yql/console/
     * @param string $currency
     * @return string
     */
    private function getAPIUrl( $currency ) {
        
	$sql = 'select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22' . $currency . '%22)';
	$url = 'https://query.yahooapis.com/v1/public/yql?q=' . $sql . '&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';
	
        return $url;
    }
    
    /**
     * Make formatted currency array from request
     * 
     * @param Request $request
     * @return array
     */
    public function formatCurrency( $request ) {
        
        $from = strtoupper( $request->get('from') );
        $to = strtoupper( $request->get('to') );
        $currencies = [
            'from' => $from,
            'to' => $to,
            'both' => $from.$to
        ];
        
        return $currencies;
    }
}
