<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Department;
use App\Http\Resources\DepartmentCollection;

class DepartmentController extends Controller
{
    public function index()
    {
        return new DepartmentCollection(Department::all());
    }
}
