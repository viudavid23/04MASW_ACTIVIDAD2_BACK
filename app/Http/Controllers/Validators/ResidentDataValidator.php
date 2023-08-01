<?php

namespace App\Http\Controllers\Validators;

use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResidentDataValidator
{

    public function __construct(){}

    /**
     * Validate the structure of the JSON received as a request in the API calls, following a set of specific rules associated with the data model.
     * @param Request $request The incoming request.
     * @return object The validation result that may contain a set of errors resulting from the validation process.
     */
    public function  validateResidentData(Request $request)
    {

        // Definition of validation rules
        $rules = [
            'residents_date_of_birth' => 'required|date_format:Y-m-d',
            'residents_registration_date' => 'required|date|date_format:Y-m-d H:i:s',
            'residents_sons_number' => 'nullable|integer',
            'residents_clothing_size' => 'nullable|string|max:10',
        ];

        // Execute the validation with the defined rules.
        $validator = Validator::make($request->all(), $rules);

        // Check if the validation has failed
        return $validator->fails() ? $validator->errors() : $validator->validated();
    }

    /**
     * Map an object from the data received in the request of the petition.
     * 
     * @param Request $request. The incoming request.
     * @return Resident The Resident object mapped.
     */
    public function fillModelFromData(Request $request): Resident
    {

        $fields = [
            'residents_date_of_birth',
            'residents_registration_date',
            'residents_sons_number',
            'residents_clothing_size',
        ];

        $resident = new Resident();

        $resident->fill($request->only($fields));
        
        $resident->persons_document = $request->input('person.persons_document');

        return $resident;
    }
}
