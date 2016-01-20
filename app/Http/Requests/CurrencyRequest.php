<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Traits\ResponseTraitService;

class CurrencyRequest extends Request {
    
    use ResponseTraitService;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'from' => 'required|currency_code|max:3',
            'to' => 'required|currency_code|max:3'
        ];
    }
    
    
    /**
     * Get the error messages as response json.
     *
     * @return array
     */
    public function response(array $errors) {
        
        foreach ($errors as $field => $error) {
            $this->_errors_field[$field] = $error[0];
        }
        
        return $this->buildResponse();
    }
}
