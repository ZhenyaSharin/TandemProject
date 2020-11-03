<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persons;

class PersonController extends Controller
{
    protected $persons;

    public function __construct(Persons $persons)
    {
        $this->persons = $persons;
    }

    public function index()
    {

        $result = $this->persons->index();

        return $result;
    }

    public function personById($id)
    {
        $result = $this->persons->getPersonById($id);

        return $result;
    }

    public function getRange()
    {
        $result = $this->persons->getRange();

        return $result;
    }

    public function getAge(Request $request)
    {
        $id = $request->id;
        $result = $this->persons->getAgePersonById($id);
        return $result;
    }
}
