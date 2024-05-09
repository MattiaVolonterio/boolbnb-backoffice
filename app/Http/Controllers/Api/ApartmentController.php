<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index()
    {
        // selezione di tutti gli appartmenti con visibilità attiva
        $apartments = Apartment::select('id', 'name', 'slug', 'cover_img', 'address')->where('visible', 1)->get();

        // sistemazione path assoluto cover img
        foreach ($apartments as $apartment) {
            $apartment->cover_img = $apartment->cover_img ? asset('storage/' . $apartment->cover_img) : 'https://placehold.co/600x400';
        }

        // return api
        return response()->json($apartments);
    }

    public function show($id)
    {

        // selezione dell'appartmamento con id corrispondente
        $apartment = Apartment::select('id', 'name', 'slug', 'cover_img', 'address')->with(['apartmentImages:apartment_id,url', 'services:id,name,icon'])->where('id', $id)->first();

        // sistemazione path assoluto cover img
        $apartment->cover_img = $apartment->cover_img ? asset('storage/' . $apartment->cover_img) : 'https://placehold.co/600x400';

        // sistemazione path assoluto icona servizi
        foreach ($apartment->services as $service) {
            $service->icon = asset($service->icon);
        }

        // sistemazione path assoluto immagini per il carosello
        foreach ($apartment->apartmentImages as $image) {
            $image->url = asset('storage/' . $image->url);
        }

        // return api
        return response()->json($apartment);
    }

    public function research($lat, $lon, $radius)
    {
        $lat1 = floatval($lat);
        $lon1 = floatval($lon);

        $filtered_apartments = [];

        // $apartments = Apartment::all();

        $apartments = Apartment::select('id', 'name', 'slug', 'cover_img', 'address')->where('visible', 1)->get();

        foreach ($apartments as $apartment) {
            $lat2 = $apartment->lat;
            $lon2 = $apartment->lon;

            if (($lat1 == $lat2) && ($lon1 == $lon2)) {
                $filtered_apartments[] = $apartment;
            } else {
                $theta = $lon1 - $lon2;
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $km = $dist * 60 * 1.1515 * 1.609344;
                if ($km <= $radius) {
                    $filtered_apartments[] = $apartment;
                }
            }
        }

        return response()->json($filtered_apartments);
    }
}
