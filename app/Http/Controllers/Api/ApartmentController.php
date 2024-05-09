<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $radiusInt = intval($radius);

        $filtered_apartments = [];

        $apartments = Apartment::select('id', 'name', 'slug', 'cover_img', 'address', 'lat', 'lon')->where('visible', 1)->get();

        foreach ($apartments as $apartment) {
            $apartment->cover_img = $apartment->cover_img ? asset('storage/' . $apartment->cover_img) : 'https://placehold.co/600x400';
        }

        foreach ($apartments as $apartment) {
            $lat2 = floatval($apartment->lat);
            $lon2 = floatval($apartment->lon);

            if (($lat1 == $lat2) && ($lon1 == $lon2)) {
                $filtered_apartments[] = $apartment;
            } else {
                $theta = $lon1 - $lon2;
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $m = $dist * 60 * 1.1515 * 1.609344 * 1000;
                if ($m <= $radiusInt) {
                    $filtered_apartments[] = $apartment;
                }
            }
        }



        $filtered_apartments_paginated = $this->paginate($filtered_apartments, 8);

        return response()->json($filtered_apartments_paginated);
    }


    public function paginate($items, $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage;
        $itemstoshow = array_slice($items, $offset, $perPage);
        return new LengthAwarePaginator($itemstoshow, $total, $perPage);
    }
}
