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
     * Show the form for creating a new resources
     */
    public function create(Request $request)
    {

        $end_date = null;
        $start_date = null;

        $sponsorhip_id = $request->query()['sponsorship_id'];
        $apartment_id = $request->query()['apartment_id'];

        $apartment = Apartment::find($apartment_id);
        $sponsor = Sponsorship::find($sponsorhip_id);

        $duration = $sponsor->duration;

        $apartment_sponsorship = $apartment->sponsorships()->where('end_date', '>', now())->first();

        if ($apartment_sponsorship != null) {
            if ($apartment_sponsorship->pivot->end_date && $apartment_sponsorship->pivot->end_date > now()->format('Y-m-d H:i:s')) {
                $start_date_sec = strtotime($apartment_sponsorship->pivot->end_date);
                $start_date = date("d-m-Y H:i:s", $start_date_sec);
                $time_remaining = strtotime($apartment_sponsorship->pivot->end_date) - strtotime(now());
                $end_date = date("d-m-Y H:i:s", strtotime("+" . $duration . ' Hours' . $time_remaining . ' seconds'));
            } else {
                $expiration = strtotime("+" . $duration . ' Hours');
                $start_date = now()->format('d-m-Y H:i:s');
                $end_date = date("d-m-Y H:i:s", $expiration);
            }
        } else {
            $expiration = strtotime("+" . $duration . ' Hours');
            $start_date = now()->format('d-m-Y H:i:s');
            $end_date = date("d-m-Y H:i:s", $expiration);
        }


        return view('admin.sponsorships.payment_page', compact('apartment', 'sponsor', 'start_date', 'end_date'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {

        $data = $request->all();

        $apartment = Apartment::find($data['apartment_id']);

        $end_date_str = strtotime($data['end_date']);
        $start_date_str = strtotime($data['start_date']);

        $end_date = date("Y-m-d H:i:s", $end_date_str);
        $start_date = date("Y-m-d H:i:s", $start_date_str);
        
        $apartment->sponsorships()->attach($data['sponsorship_id'], ['start_date' => $start_date, 'end_date' => $end_date]);

        return redirect()->route('admin.apartments.show', $apartment->id)->with('message-status', 'alert-success')->with('message-text', 'Sottoscrizione effettuata con successo');
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
