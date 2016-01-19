<?php
/**
 * File that returns array for JSON response
 */
namespace App\Models\Services\Tarits;

/**
 * Class that returns Array for JSON response
 */
trait ResponseTraitService
{
    /*
     * Array variable to collect generic errors
     */
    public $_errors_generic = array();

    /*
     * Array variable to collect generic errors
     */
    public $_errors_field = array();

    /*
     * Array variable to collect generic errors
     */
    public $_response_data = array();

    /**
     * Function to build response array
     *
     * @return array
     */
    public function buildResponse() {
        
        $response['data'] = $this->_response_data;
        $response['status'] = false;
        if (empty($this->_errors_field) && empty($this->_errors_generic)) {
            $response['status'] = true;
        }
        $response['message']['field'] = $this->_errors_field;
        $response['message']['global'] = $this->_errors_generic;

        $jsonResponse = $this->responseArrayToJSON($response);

        return $jsonResponse;
    }
    
    /**
     * Build JSON response
     * 
     * @param array $response array with response details
     * 
     * @return JSON \Illuminate\Http\Response
     */   
    public function responseArrayToJSON($response = array()) {
        $json = array();
        $success = false;

        if ($response['status'] == true) {
            $statusCode = 200;
             $success = true;
        } elseif (!empty($response['status_code'])) {
            $statusCode = $response['status_code'];
        } else {
            $statusCode = 400;
        }

        $json['success'] = $success;

        if (!empty($response['data'])) {
            $json['data'] = $response['data'];
        }

        if (!empty($response['message']['field'])) {
            foreach ($response['message']['field'] as $key => $item) {
                $this->_fieldError[$key] = $this->getErrorCode($item);
            }
            $json['messages'] = $this->_fieldError;
        }

        if (!empty($response['message']['global'])) {
            foreach ($response['message']['global'] as $message) {
                $this->_genricMessage[] = $this->getErrorCode($message);
            }
            $json['messages']['global'] =  $this->_genricMessage;
        }
        
        return response()->json($json);
    }
}
