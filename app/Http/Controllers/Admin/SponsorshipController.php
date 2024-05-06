<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sponsorships = Sponsorship::all();
        $apartments = Apartment::select('id', 'title')->where('user_id', Auth::id());
        return view('admin.sponsorships.index', compact('sponsorships', 'apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function show(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function edit(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sponsorship $sponsorship)
    {
        //
    }
}
