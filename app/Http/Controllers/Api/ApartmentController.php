<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(){
        // selezione di tutti gli appartmenti
        $apartments = Apartment::select('id', 'name', 'slug', 'cover_img', 'address')->get();
    
        // sistemazione path assoluto cover img
        foreach($apartments as $apartment){
            $apartment->cover_img = $apartment->cover_img ? asset('storage/' . $apartment->cover_img) : 'https://placehold.co/600x400';
        }

        // return api
        return response()->json($apartments);
    }

    public function show($id){

        // selezione dell'appartmamento con id corrispondente
        $apartment = Apartment::select('id', 'name', 'slug', 'cover_img', 'address')->with(['apartmentImages:id,url', 'services:id,name,icon'])->where('id', $id)->first();
        
        // sistemazione path assoluto cover img
        $apartment->cover_img = $apartment->cover_img ? asset('storage/' . $apartment->cover_img) : 'https://placehold.co/600x400';

        // sistemazione path assoluto icona servizi
        foreach($apartment->services as $service ){
            $service->icon = asset($service->icon);
        }

        // return api
        return response()->json($apartment);
    }

}
