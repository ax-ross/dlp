<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;

class CourseController extends Controller
{
    public function index()
    {
        return CourseResource::collection(auth()->user()->getCourses());
    }
}
