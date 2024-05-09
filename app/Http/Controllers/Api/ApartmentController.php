<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(){
        $aparments = Apartment::select('id', 'name', 'slug', 'cover_img', 'address')->get();
    
        foreach($aparments as $apartment){
            $apartment->cover_img = $apartment->cover_img ? asset('storage/' . $apartment->cover_img) : 'https://placehold.co/600x400';
        }

        return response()->json($aparments);
    }
}
