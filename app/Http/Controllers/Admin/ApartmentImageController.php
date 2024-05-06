<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\ApartmentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ApartmentImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store(Request $request)
    {

        // Recupero i dati dopo averli validati
        $data = $request->all();

        // Aggiungo l'ID dell'appartamento autenticato ai dati validati
        $data['apartment_id'] = Auth::id();

        // Creazione del nuovo appartamento
        $new_apartment = new Apartment;

        // Gestisco l'immagine
        if(isset($data['url'])){
            $apartment_images_path = Storage::put('uploads/apartment_images', $data['url']);
            $new_apartment->url = $apartment_images_path;
            //Ciclo FOR?

        }
        
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Apartment_image  $apartment_image
    //  * @return \Illuminate\Http\Response
    //  */
    public function show(ApartmentImage $apartment_image)
    {   
        $image_services = $apartment_image->services;
        $apartment_image->url = !empty($apartment_image->url) ? asset('/storage/' . $apartment_image->url) : null;
        return view('admin.apartments.show', compact('apartment','services'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApartmentImage  $apartment_image
    //  * @return \Illuminate\Http\Response
     */
    public function edit(ApartmentImage $apartment_image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApartmentImage  $apartment_image
    //  * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApartmentImage $apartment_image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApartmentImage  $apartment_image
    //  * @return \Illuminate\Http\Response
     */
    public function destroy(ApartmentImage $apartment_image)
    {
        //
        $apartment= $apartment_image->apartment->id;
        $apartment_image->delete();
        return redirect()->route('admin.apartments.edit', $apartment);

    }
}
