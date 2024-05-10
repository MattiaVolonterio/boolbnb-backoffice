<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
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
        if ($apartment->apartmentImages) {
            foreach ($apartment->apartmentImages as $image) {
                $image->url = asset('storage/' . $image->url);
            }
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

        $apartments = Apartment::select('id', 'name', 'slug', 'cover_img', 'address', 'lat', 'lon')->where('visible', 1)->with('services:id,name,icon')->get();

        foreach ($apartments as $apartment) {
            $apartment->cover_img = $apartment->cover_img ? asset('storage/' . $apartment->cover_img) : 'https://placehold.co/600x400';

            foreach ($apartment->services as $service) {
                $service->icon = asset($service->icon);
            }
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

        $services_num = explode(',', $services);
        $apartments_filtered = [];

        for ($i = 0; $i < count($services_num); $i++) {
            $services_num[$i] = intval($services_num[$i]);
        }

        $apartments = Apartment::select('id', 'name', 'slug', 'cover_img', 'address', 'lat', 'lon', 'n_room', 'n_bed', 'n_bathroom', 'floor', 'square_meters')->where('visible', 1)->with('services:id,name,icon')->get();


        // filtro per numero di stanze
        if ($n_room != null) {
            $n_room = intval($n_room);
            if (!$apartments_filtered) {
                foreach ($apartments as $apartment) {
                    if ($apartment->n_room >= $n_room) {
                        $apartments_filtered[] = $apartment;
                    }
                }
            }
        }


        // filtro per numero di bagno 
        if ($n_bathrooom != null) {
            $n_bathrooom = intval($n_bathrooom);

            $bathrooom = $n_bathrooom;

            if (empty($apartments_filtered)) {

                foreach ($apartments as $apartment) {
                    if ($apartment->n_bathrooom >= $n_bathrooom) {
                        $apartments_filtered[] = $apartment;
                    }
                }
            } else {
                $apartments_filtered = array_filter($apartments_filtered, function ($apartment) use ($bathrooom) {
                    return $apartment->n_bathroom >= $bathrooom;
                });
            }
        }



        // filtro per numero di letti
        if ($n_bed != null) {

            $n_bed = intval($n_bed);

            $bed = $n_bed;

            if (!$apartments_filtered) {
                foreach ($apartments as $apartment) {
                    if ($apartment->n_bed >= $n_bed) {
                        $apartments_filtered[] = $apartment;
                    }
                }
            } else {
                $apartments_filtered = array_filter($apartments_filtered, function ($apartment) use ($bed) {
                    return $apartment->n_bed >= $bed;
                });
            }
        }


        // filtro per metri quadrati
        if ($square_meters != null) {

            $square_meters = intval($square_meters);

            $mq = $square_meters;

            if (!$apartments_filtered) {
                foreach ($apartments as $apartment) {
                    if ($apartment->square_meters >= $square_meters) {
                        $apartments_filtered[] = $apartment;
                    }
                }
            } else {
                $apartments_filtered = array_filter($apartments_filtered, function ($apartment) use ($mq) {
                    return $apartment->square_meters >= $mq;
                });
            }
        }

        // filtro per piano
        if ($floor != null) {

            $floor = intval($floor);

            $n_floor = $floor;

            if (!$apartments_filtered) {
                foreach ($apartments as $apartment) {
                    if ($apartment->floor >= $floor) {
                        $apartments_filtered[] = $apartment;
                    }
                }
            } else {
                $apartments_filtered = array_filter($apartments_filtered, function ($apartment) use ($n_floor) {
                    return $apartment->floor >= $n_floor;
                });
            }
        }

        // filtro per servizi
        if ($services != null) {
            $value = 0;
            foreach ($apartments as $apartment) {
                $value = 0;
                foreach ($services_num as $service) {
                    if (in_array($service, $apartment->services->pluck('id')->toArray())) {
                        $value++;
                    }
                }
                if ($value == count($services_num)) $apartments_filtered[] = $apartment;
            }
        }

        if ($apartments_filtered) {

            return response()->json($apartments_filtered);
        } else {
            return response()->json($apartments);
        }
    }
}
