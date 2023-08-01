<?php

namespace App\Http\Contracts;

use App\Models\Person;

interface PersonGateway{

    public function getPersonByDocumentNumber($documentNumber);

    public function storePerson(Person $person);

    public function updatePerson($documentNumber, Person $person);

    public function deletePerson($documentNumber);
}