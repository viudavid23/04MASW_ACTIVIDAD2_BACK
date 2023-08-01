<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use App\Http\Middleware\ResultResponse;
use App\Http\Utils\Utils;
use Illuminate\Http\JsonResponse;
use App\Exceptions\BadRequestException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Exception dictionary. 
     * Allows to make the code more flexible and scale in case of needing many more exceptions.
     */
    protected $exceptionResponses =[
        BadRequestException::class => Response::HTTP_BAD_REQUEST, 
        ElementNotFoundException::class => Response::HTTP_CONFLICT,
        ElementAlreadyExistsException::class => Response::HTTP_CONFLICT,
        CantExecuteOperationException::class => Response::HTTP_UNPROCESSABLE_ENTITY
        //Put your customize exception here
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
   
    }

    /**
     * Render a captured exception in some part of the application.
     * 
     * @param Request $request. The incoming request.
     * @param Object $exception. The incoming exception.
     * @return JsonResponse The response in json format.
     */
    public function render($request, $exception): JsonResponse{
    
        $utils = new Utils();

        $resultResponse = new ResultResponse();

        foreach($this->exceptionResponses as $exceptionClass  => $httpCode){
     
            if($exception instanceof $exceptionClass){

                $resultResponse = $utils->createResponse($httpCode, $exception->getMessage());

                return $resultResponse;
            }
        }

        $resultResponse = $utils->createResponse(Response::HTTP_INTERNAL_SERVER_ERROR, ExceptionMessages::ERROR);
       
       return $resultResponse;
    }
}
