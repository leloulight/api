<?php

use Illuminate\Support\Facades\File;
/**
 * Class that returns Array for JSON response
 */
class ResponseService {
    /**
     * @var array _fieldError
     */
    private $_fieldError = array();

    /**
     * @var array  _genricMessage
     */
    private $_genricMessage = array();

    /**
     * Convert response details as JSON array
     *
     * @param array $response response details
     *
     * @return JSON
     */
    public function responseArrayToJSON($response = array()) 
    {
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

        //Set Status
        //To Do: Commenting status from JSON.
        //It needs to be enabled when required
        //$json['status']  = $statusCode;
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

    /**
     * Read contents from JSON file
     *
     * @return type
     * @throws Exception
     */
    private function loadLaravelMessageToCodeJSON()
    {
        $path = storage_path() . "/json/LaravelMessageToCode.json";
        if (!File::exists($path)) {
            throw new Exception("Invalid File");
        }

        //To Do: Once all validation messages added in JSON, cache the data
        $file = File::get($path);
        return $file;
    }

    /**
     * Get error code of laravel default messages
     *
     * @param string $message message
     *
     * @return string
     */
    private function getErrorCode($message)
    {
        try {
            $jsonKey = json_decode($this->loadLaravelMessageToCodeJSON());
        } catch (Exception $e){
            return $message;
        }
        foreach ($jsonKey as $key => $value) {
            if ($key === $message) {
                return $value;
            }
        }
        return $message;
    }
}
