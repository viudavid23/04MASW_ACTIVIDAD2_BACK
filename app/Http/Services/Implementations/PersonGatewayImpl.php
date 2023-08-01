<?php

namespace App\Http\Services\Implementations;

use App\Exceptions\ElementAlreadyExistsException;
use App\Exceptions\ElementNotFoundException;
use App\Exceptions\ExceptionMessages;
use App\Http\Contracts\PersonGateway;
use App\Models\Person;

/**
 * Service class responsible to implement logic to model Person Model
 */
class PersonGatewayImpl implements PersonGateway
{

    /**
     * Get a person record in database.
     * 
     * @param String $documentNumber The person document number.
     * @return Person The stored Person object.
     */
    public function getPersonByDocumentNumber($documentNumber)
    {

        $personSaved = Person::where('persons_document', $documentNumber)->first();

        return $personSaved;
    }

    /**
     * Store a new person in database.
     * 
     * @param Person $newPerson The new person to be saved in the database.
     * @return Person The saved Person object.
     * @throws ElementAlreadyExistsException If a person with the same persons_document already exists in the database.
     */
    public function storePerson(Person $newPerson): Person
    {

        $existingPerson = $this->getPersonByDocumentNumber($newPerson->persons_document);

        if (!is_null($existingPerson)) {

            throw new ElementAlreadyExistsException(ExceptionMessages::ELEMENT_ALREADY_SAVED);
        }

        $newPerson->save();

        return $newPerson;
    }

    /**
     * Update an existing person in database
     * 
     * @param String $documentNumber Person document number
     * @param Person $personUpdate An existing Person object to be update
     * @return Person The updated Person Object.
     * @throws ElementNotFoundException If a record Person with the $documentNumber does not exist in the database.
     */
    public function updatePerson($documentNumber, Person $personUpdate)
    {

        $existingPerson = $this->getPersonByDocumentNumber($documentNumber);

        if (is_null($existingPerson)) {

            throw new ElementNotFoundException(ExceptionMessages::ELEMENT_NOT_FOUND);
        }

        $personUpdate->save();

        return $personUpdate;
    }

    
    public function deletePerson($documentNumber)
    {
    }
}
