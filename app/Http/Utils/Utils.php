<?php

namespace App\Http\Utils;

use App\Http\Middleware\ResultResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Util class that contains trasversal functions uses in all application
 */
class Utils{
    
    public function __construct(){}

    /**
     * Create a response in json format
     * 
     * @param int $httpCode HTTP code.
     * @param String $message The out message
     * @param Object $data The object with the response of the executed operation."
     * 
     * @return JsonResponse The response in json format
     */
    public function createResponse(int $httpCode, String $message, $data = null): JsonResponse
    {
        $resultResponse = new ResultResponse();

        $resultResponse->setStatusCode($httpCode);
        $resultResponse->setMessage($message);
        if(isset($data)){
            $resultResponse->setData($data);
        }
       
        return response()->json(["response " => $resultResponse], $httpCode);
    }

    /**
     * Validate validator response
     * 
     * @param Object $validationResult Validator response
     * @return bool Flag that indicates if request cointains or not errors.
     */
    public function isValidationFailed($validationResult): bool
    {
        return isset($validationResult) && !empty($validationResult) && (!is_array($validationResult) && property_exists($validationResult, 'messages') && is_array($validationResult->getMessages()));
    }

}