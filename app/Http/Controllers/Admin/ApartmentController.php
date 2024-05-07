<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\ApartmentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {   
        //prendo l'íd del utente loggato 
        $userId = auth()->id(); 
        //filtro per user_id
        $apartments = Apartment::where('user_id', $userId)->paginate(10);
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $apartment = new Apartment();
        $services = Service::all();
        $apartment_images = ApartmentImage::all();

        return view('admin.apartments.create', compact('apartment', 'services','apartment_images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        //dd($request);
         // Validazione dei dati inviati dal form
         $data = $request->validate([
            'name' => 'required|string',
             'n_room' => 'required|integer|min:1',
             'n_bathroom' => 'required|integer|min:1',
             'n_bed' => 'required|integer|min:1',
             'square_meters' => 'required|integer|min:1',
             'floor' => 'required|integer',
             'address' => 'required|string',
             'visible' => 'required', 
             'cover_img' => 'nullable|image|mimes:jpeg,png|max:2048',  
         ]);

        
        // Recupro i dati dopo averli validati
        $data = $request->all();
    
        // Aggiungo l'ID dell'utente autenticato ai dati validati
        $data['user_id'] = Auth::id();
        // Creazione del nuovo appartamento

        $new_apartment = new Apartment;
        // Gestisco l'immagine
        if ($request->hasFile('cover_img')) {
            $img_path = $request->file('cover_img')->store('uploads/cover', 'public');
            $new_apartment->cover_img = $img_path;
        }
        

        if(isset($data['visible'])){
            $data['visible'] = 1;
        } else {
            $data['visible'] = 0;
        }

        $new_apartment->slug = Str::slug($data['name']);
        
        $new_apartment->fill($data);
        
        $new_apartment->save();

        if ($request->has('services')) {
            $new_apartment->services()->attach($request->input('services'));
        }

        //  img multiple
        if ($request->hasFile('apartment_images')) {
            foreach ($request->file('apartment_images') as $image) {
                $path = $image->store('uploads/apartment_images', 'public');
                ApartmentImage::create([
                    'apartment_id' => $new_apartment->id,
                    'url' => $path
                ]);
                
            }
        }

        // Reindirizzamento all'elenco degli appartamenti con un messaggio di successo
        return redirect()->route("admin.apartments.show", $new_apartment)->with('success', 'Appartamento creato con successo.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     */
    public function show(Apartment $apartment)
    {   
        $services = $apartment->services;
        $apartment_images = $apartment->apartmentImages;
        $apartment->cover_img = !empty($apartment->cover_img) ? asset('/storage/' . $apartment->cover_img) : null;
        // $apartment->apartment_images = !empty($apartment->apartment_images) ? asset('/storage/' . $apartment->apartment_images) : null;
        return view('admin.apartments.show', compact('apartment','services','apartment_images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     */
    public function edit(Apartment $apartment)
    {   
        // $userId=auth()->id();a

        // tab apartment img
        $apartment_images = $apartment->apartmentImages;

        // url imgs
        $apartment_images->url = !empty($apartment_images->url) ? asset('/storage/' . $apartment_images->url) : null;

        $services = Service::all();
        return view('admin.apartments.edit', compact('apartment','services', 'apartment_images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
     */
    public function update(Request $request, Apartment $apartment, ApartmentImage $apartmentImage)
    {
        $data = $request->all();
        //creo slug dal nome 
        $apartment->slug = Str::slug($data['name']);
         // Riassegno l'essere visibile o meno
         $data['visible'] = Arr::exists($data, 'visible');

        // recupero l'img
        if ($request->hasFile('cover_img')) {
            $img_path = $request->file('cover_img')->store('uploads/cover', 'public');
            $apartment->cover_img = $img_path;  
        }
        if ($request->has('services')) {
            $apartment->services()->sync($request->input('services'));
        } else {
            $apartment->services()->detach();
        }

        // update imgs
        if ($request->hasFile('apartment_images')) {
            foreach ($request->file('apartment_images') as $image) {
                $path = $image->store('uploads/apartment_images', 'public');
                ApartmentImage::create([
                    'apartment_id' => $apartment->id,
                    'url' => $path
                ]);
            }
        }
        
        $apartment->update($data);
        return redirect()->route('admin.apartments.show' ,compact('apartment', 'apartmentImage'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('admin.apartments.index')->with('message', "$apartment->name eliminato con successo");

    }
}
