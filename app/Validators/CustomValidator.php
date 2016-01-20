<?php namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use App\Models\Services\CurrencyService;

class CustomValidator extends Validator {
    
    /**
     * Initialize the class
     */
    public function __construct() {
        // Init custom rules
        $this->extendValidators();
    }

    /* Function to add custom validation rules
     *
     * @return boolean
     */
    public function extendValidators()
    {
        // Function to call the Uuid validator
        Validator::extend('currency_code', function ($attribute, $value) {
            $currency = new CurrencyService();
            return $currency->checkCurrency( $value );
        }, 'Currency code is incorrect');
    }
    
    /* Call the validation function
     * 
     * @param Array $input
     * @param Array $rules
     * @param Array $messages
     * 
     * @return boolean
     */
    public function doValidation($input, $rules, $messages)
    {
        return  Validator::make($input, $rules, $messages);
    }

}
