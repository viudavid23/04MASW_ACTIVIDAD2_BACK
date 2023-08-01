<?php

namespace App\Http\Services\Implementations;

use App\Exceptions\CantExecuteOperationException;
use App\Exceptions\ElementAlreadyExistsException;
use App\Exceptions\ElementNotFoundException;
use App\Exceptions\ExceptionMessages;
use App\Http\Contracts\PersonGateway;
use App\Http\Contracts\ResidentGateway;
use App\Models\Person;
use App\Models\Resident;
use App\Models\Residents;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Service class responsible to implement logic to model Resident
 * 
 */
class ResidentGatewayImpl implements ResidentGateway
{

    protected PersonGateway $personGateway;

    public function __construct(PersonGateway $personGateway)
    {
        $this->personGateway = $personGateway;
    }

    /**
     * Get all residents
     * @return Array The set of residents saved in database
     * @throws ElementNotFoundException If does not exist resident records in the database.
     */
    public function getAllResident()
    {

        $residents = Resident::all();

        if ($residents->isEmpty()) {

            throw new ElementNotFoundException(ExceptionMessages::ELEMENT_NOT_FOUND);
        }

        return $residents;
    }

    /**
     * Get resident by id
     * @param int $id
     * @return Resident The Resident object saved in database
     * @throws ElementNotFoundException If a record Resident with the $id does not exist in the database.
     */
    public function getResidentById($id): Resident
    {

        try{
            $resident = Resident::findOrFail($id);

            return $resident;
        }catch (ModelNotFoundException $e ){

            throw new ElementNotFoundException(ExceptionMessages::ELEMENT_NOT_FOUND);
        }
    }

    /**
     * Store a new Resident in database
     * @param Resident
     * @param Person
     * @return Resident The Resident object saved in the database.
     * @throws CantExecuteOperationException If occurs an error during save the resident.
     */
    public function storeResident(Resident $resident, Person $person): Resident
    {

        try {
            return DB::transaction(function () use ($resident, $person) {
            
                $this->personGateway->storePerson($person);
        
                $resident->save();
        
                return $resident;
            });
        } catch (QueryException $exception) {

            throw new CantExecuteOperationException(ExceptionMessages::CANT_EXECUTE_OPERATION);
        }
    }

    public function updateResident($id, $resident)
    {

    }

    public function deleteResident($id)
    {
    }
}
