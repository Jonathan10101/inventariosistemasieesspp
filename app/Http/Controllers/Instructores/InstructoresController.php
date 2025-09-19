<?php

namespace App\Http\Controllers\Instructores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstructoresController extends Controller
{
    public function index()
    {
        return view("instructores/index");
    }
}
