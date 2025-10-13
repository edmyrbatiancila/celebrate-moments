<?php

namespace App\Http\Controllers;

use App\Models\GreetingRecipient;
use App\Http\Requests\StoreGreetingRecipientRequest;
use App\Http\Requests\UpdateGreetingRecipientRequest;

class GreetingRecipientController extends Controller
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
    public function store(StoreGreetingRecipientRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GreetingRecipient $greetingRecipient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GreetingRecipient $greetingRecipient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGreetingRecipientRequest $request, GreetingRecipient $greetingRecipient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GreetingRecipient $greetingRecipient)
    {
        //
    }
}
