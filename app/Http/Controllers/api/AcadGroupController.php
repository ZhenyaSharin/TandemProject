<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcadGroups;

class AcadGroupController extends Controller
{
    protected $groups;

    public function __construct(AcadGroups $groups)
    {
        $this->groups = $groups;
    }

    public function getPersonsByGroupId(Request $request)
    {
        $groupid = $request->groupid;
        $result = $this->groups->getPersonsByGroupId($groupid);
        return $result;
    }

    public function groupsList()
    {
        $result = $this->groups->getAllGroups();
        return $result;
    }
}
