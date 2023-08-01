<?php

namespace App\Http\Controllers\Validators;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonDataValidator
{

    public function __construct(){}

    /**
     * Validate the structure of the JSON received as a request in the API calls, following a set of specific rules associated with the data model.
     * @param Request $request The incoming request.
     * @param bool $create Indicator to determine if it's creating or updating a record.
     * @return object The validation result that may contain a set of errors resulting from the validation process.
     */
    public function  validatePersonData(Request $request, $create = false)
    {

        if ($create === true) {
            // If storing a new record, add the rule for the document type as the first element in the rules.
            $rules = ['person.persons_document' => 'required|string|min:1|max:15'];
        }

        // Definition of validation rules
        $rules += [
            'person.persons_first_name' => 'required|string|min:1|max:50',
            'person.persons_middle_name' => 'nullable|string|max:50',
            'person.persons_last_name' => 'required|string|min:1|max:50',
            'person.persons_second_surname' => 'nullable|string|max:50',
            'person.persons_direction' => 'nullable|string|max:100',
            'person.persons_phone' => 'nullable|string|max:20',
            'person.persons_mobile' => 'nullable|string|max:15',
            'person.persons_state' => 'in:0,1',
            'person.persons_notes' => 'nullable|string|max:500',
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
     * @return Person The Person object mapped.
     */
    public function fillModelFromData(Request $request): Person
    {

        /* $fields = [
            'persons_document',
            'persons_first_name',
            'persons_last_name',
            'persons_state',
            'persons_middle_name',
            'persons_second_surname',
            'persons_direction',
            'persons_phone',
            'persons_mobile',
            'persons_notes',
        ];*/

        $person = new Person();

        $person->fill($request->input('person'));

        return $person;
    }
}
