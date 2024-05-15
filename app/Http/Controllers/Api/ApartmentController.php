<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;

use Illuminate\Support\Facades\DB;
use App\Models\Sponsorship;
use Illuminate\Http\Request;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ApartmentController extends Controller
{
    public function index()
    {
        // get all the apartment with active 
        $apartments = DB::table('apartments')->join('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
        ->select('apartments.id', 'apartments.name', 'apartments.slug', 'apartments.cover_img', 'apartments.address')
        ->where('apartment_sponsorship.end_date', '>', now(), 'and', 'apartment.visible', 1)
        ->groupBy('apartments.id')->paginate();

        // TODO:: sistemare con ricerca in base al numero di visualizzazioni
        if(empty($apartments)){
            $apartments = Apartment::all()->paginate();
        }
        
        // relative path in absolute path
        foreach ($apartments as $apartment) {
            $apartment->cover_img = $apartment->cover_img ? asset('storage/uploads/cover/' . $apartment->cover_img) : 'https://placehold.co/600x400';
        }

        
        // return json with all the apartments
        return response()->json($apartments);
    }

    public function show($id)
    {

        // selezione dell'appartmamento con id corrispondente
        $apartment = Apartment::where('id', $id)->with(['apartmentImages:apartment_id,url', 'services:id,name,icon'])->first();

        // sistemazione path assoluto cover img
        $apartment->cover_img = $apartment->cover_img ? asset('storage/uploads/cover/' . $apartment->cover_img) : 'https://placehold.co/600x400';

        // sistemazione path assoluto icona servizi
        foreach ($apartment->services as $service) {
            $service->icon = asset($service->icon);
        }

        // sistemazione path assoluto immagini per il carosello
        if ($apartment->apartmentImages) {
            foreach ($apartment->apartmentImages as $image) {
                $image->url = asset('storage/uploads/apartment_images/' . $image->url);
            }
        }

        // return api
        return response()->json($apartment);
    }

    public function research($lat, $lon, $radius)
    {
        // parse value from request
        $lat1 = floatval($lat);
        $lon1 = floatval($lon);
        $radiusInt = intval($radius);

        // array where we put the filtered apartment
        $filtered_apartments = [];

        // query to get all the visible apartment
        $apartments = DB::table('apartments')
        // ->join('apartment_service', 'apartments.id', '=', 'apartment_service.apartment_id')
        // ->join('services', 'apartment_service.service_id', '=', 'services.id')
        ->leftJoin('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
        ->select('apartments.id', 'apartments.name', 'apartments.slug', 'apartments.cover_img', 'apartments.address', 'apartments.lat', 'apartments.lon')
        ->where('apartment_sponsorship.end_date', '>', now())
        ->orWhere('apartments.visible', 1)
        ->orderBy('apartment_sponsorship.apartment_id', 'DESC')      
        ->get();

        dd($apartments);

        // relative path in absolute path
        foreach ($apartments as $apartment) {
            $apartment->cover_img = $apartment->cover_img ? asset('storage/uploads/cover/' . $apartment->cover_img) : 'https://placehold.co/600x400';

            foreach ($apartment->services as $service) {
                $service->icon = asset($service->icon);
            }
        }

        // calc if the specific apartment is include in the given radius
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


        // paginate the result
        $filtered_apartments_paginated = $this->paginate($filtered_apartments, 12);

        // send the result
        return response()->json($filtered_apartments_paginated);
    }


    // function that return a paginate object that accept as a parameters the array, number of items per page & the total page
    public function paginate($items, $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage;
        if ($total >= $perPage) {
            $itemstoshow = array_slice($items, $offset, $perPage);
        } else {
            $itemstoshow = $items;
        }
        return new LengthAwarePaginator($itemstoshow, $total, $perPage);
    }

    // fetch the services
    public function getServices()
    {
        // recupero tutti i servizi dal  database
        $services = Service::select('id', 'icon', 'name')->orderBy('name', 'ASC')->get();

        // sistemazione path assoluto icona servizi
        foreach ($services as $service) {
            $service->icon = asset($service->icon);
        }

        return response()->json($services);
    }

    public function filterApartments($lat, $lon, $radius, $n_room = null, $n_bathrooom = null, $n_bed = null, $square_meters = null, $floor = null, $services = null)
    {

        // create the raw query
        $query_raw = Apartment::select('id', 'name', 'slug', 'cover_img', 'address', 'lat', 'lon', 'n_room', 'n_bed', 'n_bathroom', 'floor', 'square_meters')->with('services:id,name,icon')->where('visible', 1);

        // filter by n_room
        if ($n_room != 'null') {
            $query_raw = $query_raw->where('n_room', '>=', $n_room);
        }

        // filter by n_bathrooom
        if ($n_bathrooom != 'null') {
            $query_raw = $query_raw->where('n_bathroom', '>=', $n_bathrooom);
        }

        // filter by n_bed        
        if ($n_bed != 'null') {
            $query_raw = $query_raw->where('n_bed', '>=', $n_bed);
        }

        // filter by square_meters
        if ($square_meters != 'null') {
            $query_raw = $query_raw->where('square_meters', '>=', $square_meters);
        }

        // filter by floor
        if ($floor != 'null') {
            $query_raw = $query_raw->where('floor', '>=', $floor);
        }

        // fetch all the apartments that respect the filters
        $apartments = $query_raw->get();
        


        // filter by array services
        if ($services != 'null') {
            $apartments_filtered = [];
            $services = explode(',', $services);
            for ($i = 0; $i < count($services); $i++) {
                $services[$i] = intval($services[$i]);
            }
            $value = 0;
            foreach ($apartments as $apartment) {
                $value = 0;
                foreach ($services as $service) {
                    if (in_array($service, $apartment->services->pluck('id')->toArray())) {
                        $value++;
                    }
                }
                if ($value == count($services)) $apartments_filtered[] = $apartment;
            }
        }

        if ($services != 'null') {
            foreach ($apartments_filtered as $apartment) {
                $apartment->cover_img = $apartment->cover_img ? asset('storage/uploads/cover/' . $apartment->cover_img) : 'https://placehold.co/600x400';
            }
            $filtered_apartments_paginated = $this->paginate($apartments_filtered, 12);
            return response()->json($filtered_apartments_paginated);
        } else {
            foreach ($apartments as $apartment) {
                $apartment->cover_img = $apartment->cover_img ? asset('storage/uploads/cover/' . $apartment->cover_img) : 'https://placehold.co/600x400';
            }
            $filtered_apartments_paginated = $this->paginate($apartments->toArray(), 12);
            return response()->json($filtered_apartments_paginated);
        }
    }
}
