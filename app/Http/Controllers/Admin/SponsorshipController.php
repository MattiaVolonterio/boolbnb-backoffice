<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Carbon\Traits\Timestamp;
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
        $apartments = Apartment::select('id', 'name')->where('user_id', Auth::id())->get();
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
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Europe/Rome');

        $sponsorhip_id = $request->query()['sponsorship_id'];
        $apartment_id = $request->query()['apartment_id'];


        $sponsorship = Sponsorship::find($sponsorhip_id);
        $duration = $sponsorship->duration;

        $apartments = Apartment::find($apartment_id);

        $apartment_sponsorship = $apartments->sponsorships()->where('end_date', '>', now())->first();

        if ($apartment_sponsorship != null) {
            if ($apartment_sponsorship->pivot->end_date && $apartment_sponsorship->pivot->end_date > now()->format('Y-m-d H:i:s')) {
                $start_date = $apartment_sponsorship->pivot->end_date;
                $time_remaining = strtotime($apartment_sponsorship->pivot->end_date) - strtotime(now());
                $end_date = date("Y-m-d H:i:s", strtotime("+" . $duration . ' Hours' . $time_remaining . ' seconds'));
            } else {
                $expiration = strtotime("+" . $duration . ' Hours');
                $start_date = now()->format('Y-m-d H:i:s');
                $end_date = date("Y-m-d H:i:s", $expiration);
            }
        } else {
            $expiration = strtotime("+" . $duration . ' Hours');
            $start_date = now()->format('Y-m-d H:i:s');
            $end_date = date("Y-m-d H:i:s", $expiration);
        }

        $apartments->sponsorships()->attach($sponsorhip_id, ['start_date' => $start_date, 'end_date' => $end_date]);

        return redirect()->route('admin.apartments.show', $apartment_id)->with('message', 'Sottoscrizione effettuata con successo');
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
