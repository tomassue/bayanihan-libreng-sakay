<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationAccountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $accountType = $request->input('accountType');

        if ($accountType == '1') {
            // Redirect to the Organization registration form.
            return redirect()->route('register.org')->withInput();
        } elseif ($accountType == '2') {
            // Redirect to the Individual registration form.
            return redirect()->route('register.ind')->withInput();
        } elseif ($accountType == '3') {
            // Redirect to the Client registration form.
            return redirect()->route('register.client')->withInput();
        }
    }

    public function registerOrg()
    {
        return view('auth.registerOrganization');
    }

    public function registerInd()
    {
        return view('auth.registerIndividual');
    }

    public function registerClient()
    {
        return view('auth.registerClient');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
