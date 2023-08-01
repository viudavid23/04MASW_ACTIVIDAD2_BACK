<?php

namespace App\Http\Contracts;

use App\Models\Person;
use App\Models\Resident;

interface ResidentGateway{

    public function getAllResident();

    public function getResidentById($id);

    public function storeResident(Resident $resident, Person $person);

    public function updateResident($id, Resident $reident);

    public function deleteResident($id);
}