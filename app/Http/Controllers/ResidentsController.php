<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use App\Exceptions\ExceptionMessages;
use App\Http\Contracts\ResidentGateway;
use App\Http\Controllers\Validators\PersonDataValidator;
use App\Http\Controllers\Validators\ResidentDataValidator;
use App\Http\Utils\Utils;
use App\Models\Resident;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResidentsController extends Controller
{

    protected ResidentGateway $residentGateway;

    private $utils;

    public function __construct(ResidentGateway $residentGateway)
    {
        $this->residentGateway = $residentGateway;

        $this->utils = new Utils();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $residents = $this->residentGateway->getAllResident();

        $response = $this->utils->createResponse(Response::HTTP_OK, ExceptionMessages::SUCCESS, $residents);

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $personDataValidator = new PersonDataValidator();

        $residentDataValidator = new ResidentDataValidator();

        $validationPersonResult = $personDataValidator->validatePersonData($request, true);

        $validationResidentResult = $residentDataValidator->validateResidentData($request);

        if ($this->utils->isValidationFailed($validationPersonResult) || $this->utils->isValidationFailed($validationResidentResult)) {

            throw new BadRequestException(ExceptionMessages::BAD_REQUEST);
        }

        $person = $personDataValidator->fillModelFromData($request);

        $resident = $residentDataValidator->fillModelFromData($request);

        $residentSaved = $this->residentGateway->storeResident($resident, $person);

        $data = [
            'residents_id' => $residentSaved->id,
            "residents_date_of_birth" => $residentSaved->residents_date_of_birth,
            "residents_registration_date" => $residentSaved->residents_registration_date,
            "residents_sons_number" => $residentSaved->residents_sons_number,
            "residents_clothing_size" => $residentSaved->residents_clothing_size,
            "person" => $residentSaved->person->toArray(),
        ];

        $response = $this->utils->createResponse(Response::HTTP_OK, ExceptionMessages::SUCCESS, $data);

        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $residentSaved = $this->residentGateway->getResidentById($id);

        $data = [
            'residents_id' => $residentSaved->id,
            "residents_date_of_birth" => $residentSaved->residents_date_of_birth,
            "residents_registration_date" => $residentSaved->residents_registration_date,
            "residents_sons_number" => $residentSaved->residents_sons_number,
            "residents_clothing_size" => $residentSaved->residents_clothing_size,
            "person" => $residentSaved->person->toArray(),
        ];

        $response = $this->utils->createResponse(Response::HTTP_OK, ExceptionMessages::SUCCESS, $data);

        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resident $resident)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resident $resident)
    {
        //fixme: doesnt works
        
       /* $personDataValidator = new PersonDataValidator();

        $residentDataValidator = new ResidentDataValidator();

        $validationPersonResult = $personDataValidator->validatePersonData($request, false);

        $validationResidentResult = $residentDataValidator->validateResidentData($request);

        if ($this->utils->isValidationFailed($validationPersonResult) || $this->utils->isValidationFailed($validationResidentResult)) {

            throw new BadRequestException(ExceptionMessages::BAD_REQUEST);
        }

        $person = $personDataValidator->fillModelFromData($request);

        $resident = $residentDataValidator->fillModelFromData($request);

        $residentSaved = $this->residentGateway->updateResident($resident, $person);

        $data = [
            'residents_id' => $residentSaved->id,
            "residents_date_of_birth" => $residentSaved->residents_date_of_birth,
            "residents_registration_date" => $residentSaved->residents_registration_date,
            "residents_sons_number" => $residentSaved->residents_sons_number,
            "residents_clothing_size" => $residentSaved->residents_clothing_size,
            "person" => $residentSaved->person->toArray(),
        ];

        $response = $this->utils->createResponse(Response::HTTP_OK, ExceptionMessages::SUCCESS, null);

        return $response;*/
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resident $resident)
    {
        //
    }
}
