<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApartmentStoreRequest;
use App\Http\Requests\ApartmentUpdateRequest;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\ApartmentImage;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\Cast\String_;


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
        $apartments = Apartment::where('user_id', $userId)->orderBy('created_at', 'desc')->with('sponsorships')->paginate(8);
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $apartment = new Apartment();
        $services = Service::orderBy('name', 'asc')->get();
        $apartment_images = ApartmentImage::all();

        return view('admin.apartments.create', compact('apartment', 'services','apartment_images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(ApartmentStoreRequest $request)
    {

         // Validazione dei dati inviati dal form
        $request->validated();
        
        // Recupro i dati dopo averli validati
        $data = $request->all();
    
        // Aggiungo l'ID dell'utente autenticato ai dati validati
        $data['user_id'] = Auth::id();
        // Creazione del nuovo appartamento

        $new_apartment = new Apartment;
        // Gestisco l'immagine
        if ($request->hasFile('cover_img')) {
            $img_path = $request->file('cover_img')->store('uploads/cover/', 'public');
            $img_path = explode('/', $img_path)[3];
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
                $path = $image->store('uploads/apartment_images/', 'public');
                $path = explode('/', $path)[3];
                ApartmentImage::create([
                    'apartment_id' => $new_apartment->id,
                    'url' => $path
                ]);
                
            }
        }

        // Reindirizzamento all'elenco degli appartamenti con un messaggio di successo
        return redirect()->route("admin.apartments.show", $new_apartment)->with('message-status', 'alert-success')->with('message-text', 'Appartamento creato con successo');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     */
    public function show(Apartment $apartment)
    {   
        //protezione rotte
        if (Auth::id() != $apartment->user_id && Auth::user()->role != 'admin')
            abort(403);
        $services = $apartment->services;
        $apartment_images = $apartment->apartmentImages;
        
        $sponsorship_id = $apartment->sponsorships->pluck('id');
        return view('admin.apartments.show', compact('apartment','services','apartment_images', 'sponsorship_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     */
    public function edit(Apartment $apartment)
    {   
        
        //protezione rotte
        if (Auth::id() != $apartment->user_id)
            abort(403);
        // tab apartment img
        $apartment_images = $apartment->apartmentImages;

        // url imgs
        $apartment_images->url = !empty($apartment_images->url) ? asset('storage/uploads/apartment_images' . $apartment_images->url) : null;

        $services = Service::orderBy('name', 'asc')->get();
        return view('admin.apartments.edit', compact('apartment','services', 'apartment_images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
     */
    public function update(ApartmentUpdateRequest $request, Apartment $apartment, ApartmentImage $apartmentImage)
    {
        //protezione rotte
        if (Auth::id() != $apartment->user_id && Auth::user()->role != 'admin')
            abort(403);

        $request->validated();

        $data = $request->all();
        //creo slug dal nome 
        $apartment->slug = Str::slug($data['name']);
         // Riassegno l'essere visibile o meno
         $data['visible'] = Arr::exists($data, 'visible');

        // recupero l'img
        if ($request->hasFile('cover_img')) {
            $img_path = $request->file('cover_img')->store('uploads/cover/', 'public');
            $img_path = explode('/', $img_path)[3];
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
                $path = $image->store('uploads/apartment_images/', 'public');
                $path = explode('/', $path)[3];
                ApartmentImage::create([
                    'apartment_id' => $apartment->id,
                    'url' => $path
                ]);
            }
        }
        
        $apartment->update($data);
        return redirect()->route('admin.apartments.show' ,compact('apartment', 'apartmentImage'))->with('message-status', 'alert-success')->with('message-text', 'Appartamento modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     */
    public function destroy(Apartment $apartment)
    {   
        //protezione rotte
        if (Auth::id() != $apartment->user_id && Auth::user()->role != 'admin')
            abort(403);
        $apartment->delete();
        return redirect()->route('admin.apartments.index')->with('message-status', 'alert-danger')->with('message-text', 'Appartamento eliminato con successo');;

    }

    public function switch_visible(Request $request, Apartment $apartment){
        //protezione rotte
        if (Auth::id() != $apartment->user_id && Auth::user()->role != 'admin')
            abort(403);

        $data = $request->only('visible'); 
        
        if(!empty($data)){
            $apartment->visible = 1;
        } else {
            $apartment->visible = 0;
        }

        $apartment->save();
        return redirect()->route('admin.apartments.index')->with('message-status', 'alert-success')->with('message-text', 'Visibilità modificata con successo');
    }
}
