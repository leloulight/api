<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CurrencyRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }
    
    /**
     * Trim all input beofre processing
     * 
     * @return Array
     */
    public function all() {
        
        $array = array_map( 'trim', parent::all() );
        
        return parent::merge( $array );
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [
            'from' => 'required|max:3',
            'to' => 'required|max:3'
        ];
    }
}
