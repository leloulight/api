<?php namespace App\Http\Controllers\Currency;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Models\Services\CurrencyService;
use App\Models\Traits\ResponseTraitService;

class CurrencyConverterController extends Controller {
    
    /*
     * Response trait service
     */
    use ResponseTraitService;
    
    /**
     * Currency service class object
     * @var object 
     */
    private $service = array();
    
    /**
     * Initialize the class and set properties
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
    public function convertCurrency( CurrencyRequest $request ) {
        
        $curr = $this->service->formatCurrency( $request );
        $rate = $this->service->getRate( $curr );
        
        return $rate;
    }

}
