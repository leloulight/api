<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use Illuminate\Http\Request;
use App\Models\Services\CurrencyService;

class CurrencyConverterController extends Controller {

    private $service = array();
    
    /**
     * Initialize the class and set properties
     * 
     * @param Request $request
     */
    public function __construct() {
        
        $this->service = new CurrencyService();
    }

    /**
     * Dead method, haha.
     *
     * @return void
     */
    private function index() {
        return;
    }
    
    
    /**
     * Converting the given currency.
     * 
     * @param Request $request
     * @return JSON
     */
    public function convertCurrency( Request $request ) {
        
        if( !$this->isValidCurrency( $request ) ) {
            return false;
        }
        
        $curr = $this->service->formatCurrency( $request );
        $rate = $this->service->getRate( $curr['both'] );
        
        return $rate;
    }
    
    
    /**
     * Get currencies list.
     * 
     * @return Array
     */
    private function isValidCurrency( $request ) {
        
        $curr = $this->service->formatCurrency( $request );
        
        if( !$this->service->checkCurrency( $curr['from'] )
                || !$this->service->checkCurrency( $curr['to'] )
        ) {
            return false;
        }
        return true;
    }

}
