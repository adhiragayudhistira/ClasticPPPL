<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DropOffController extends Controller
{
    public function index()
    {
        return view('dropoff.index');
    }

    public function create()
    {
        return view('dropoff.create');
    }

    public function store(Request $request)
    {
        // Later: save dropoff
        return redirect()->route('dropoff')->with('success', 'Dropoff requested!');
    }
}