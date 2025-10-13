<?php

namespace App\Http\Controllers;

use App\Models\Greeting;
use App\Http\Requests\StoreGreetingRequest;
use App\Http\Requests\UpdateGreetingRequest;

class GreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGreetingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Greeting $greeting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Greeting $greeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGreetingRequest $request, Greeting $greeting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Greeting $greeting)
    {
        //
    }
}
