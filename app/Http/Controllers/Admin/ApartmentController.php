<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApartmentStoreRequest;
use App\Http\Requests\ApartmentUpdateRequest;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\ApartmentImage;
use App\Models\Sponsorship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
        $apartments = Apartment::where('user_id', $userId)->orderBy('created_at', 'desc')->with('sponsorships')->withCount('visits')->paginate(8);

        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $apartment = new Apartment();

        // recuperare i servizi dal db
        $services = Service::orderBy('name', 'asc')->get();

        // recuperare gli apartment images
        $apartment_images = ApartmentImage::all();

        return view('admin.apartments.create', compact('apartment', 'services', 'apartment_images'));
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

        // cambio valore di visibilità
        if (isset($data['visible'])) {
            $data['visible'] = 1;
        } else {
            $data['visible'] = 0;
        }

        // creazione slug
        $new_apartment->slug = $this->generateUniqueSlug($data['slug']);



        // fill dei data in new apartment
        $new_apartment->fill($data);

        // salvare i dati in db
        $new_apartment->save();

        // se ci sono presenti dei servizi aggiungili alla tabella pivot
        if ($request->has('services')) {
            $new_apartment->services()->attach($request->input('services'));
        }

        //  img multiple
        if ($request->hasFile('apartment_images')) {
            foreach ($request->file('apartment_images') as $image) {
                // aggiungere file a store
                $path = $image->store('uploads/apartment_images/', 'public');
                // recupero solo il nome del file
                $path = explode('/', $path)[3];

                // aggiunta al database relazione tra immagini e appartamenti
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

        // recuperare tutte le sponsor
        $sponsor = $apartment->sponsorships;
        // recuperare tutti i servizi
        $services = $apartment->services;
        // recuperare tutte le apartment_images
        $apartment_images = $apartment->apartmentImages;

        // CHART

        $date = Carbon::parse('2018-03-16')->locale('it');
        $todayDate = Carbon::now();

        //Create a months array
        $totalArray = [];
        $label_to_print = [];

        //Get start and end of all months
        for ($i = 0; $i <= 12; $i++) {
            $startDate = Carbon::now()->subYear();
            $totalArray[] = $startDate->addMonths($i)->firstOfMonth()->format('Y-m-d');
            $totalArray[] = $startDate->endOfMonth()->format('Y-m-d');
            $month_base = $startDate->format('F');
            $month_translated = ucfirst(Carbon::translateTimeString($month_base, 'en', 'it'));
            $label_to_print[] = $month_translated;
        }

        $date_of_start_char = $totalArray[0];


        // Array dei messaggi
        $result_1 = DB::table('messages')
            ->selectRaw('year(created_at) year, month(created_at) month, count(*) data')
            ->where('messages.apartment_id', '=', $apartment->id)
            ->whereBetween('messages.created_at', [date($date_of_start_char), date($todayDate)])
            ->groupBy('year', 'month')
            ->orderBy('year', 'ASC')
            ->orderBy('month', 'ASC')
            ->get()->toArray();


        foreach ($result_1 as $result) {
            $month_name = date("F", mktime(0, 0, 0, $result->month, 10));
            $result->month = ucfirst(Carbon::translateTimeString($month_name, 'en', 'it'));
        }

        $result_messages = [];

        $var = 0;
        for ($i = 0; $i <= count($label_to_print); $i++) {
            for ($j = $var; $j < count($result_1); $j++) {
                if ($label_to_print[$i] == $result_1[$j]->month) {
                    $result_messages[] = $result_1[$j]->data;
                    $var = $j + 1;
                    break;
                }
                if ($j == count($result_1) - 1) {
                    $result_messages[] = 0;
                }
            }
        }

        while (count($result_messages) < count($label_to_print)) {
            $result_messages[] = 0;
        }


        // Visualizzazioni totali per mese

        $result_2 = DB::table('visits')
            ->selectRaw('year(created_at) year, month(created_at) month, count(*) data')
            ->where('visits.apartment_id', '=', $apartment->id)
            ->whereBetween('visits.created_at', [date($date_of_start_char), date($todayDate)])
            ->groupBy('year', 'month')
            ->orderBy('year', 'ASC')
            ->orderBy('month', 'ASC')
            ->get()->toArray();

        foreach ($result_2 as $result) {
            $month_name = date("F", mktime(0, 0, 0, $result->month, 10));
            $result->month = ucfirst(Carbon::translateTimeString($month_name, 'en', 'it'));
        }

        $result_views = [];

        $var_2 = 0;
        for ($i = 0; $i < count($label_to_print); $i++) {
            for ($j = $var_2; $j < count($result_2); $j++) {
                if ($label_to_print[$i] == $result_2[$j]->month) {
                    $result_views[] = $result_2[$j]->data;
                    $var_2 = $j + 1;
                    break;
                }
                if ($j == count($result_2) - 1) {
                    $result_views[] = 0;
                }
            }
        }

        while (count($result_views) < count($label_to_print)) {
            $result_views[] = 0;
        }

        $data = [
            'labels' => $label_to_print,
            'messages' => $result_messages,
            'views' => $result_views,
        ];

        // RETURN
        return view('admin.apartments.show', compact('apartment', 'services', 'apartment_images', 'data'));
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

        // recupero servizi
        $services = Service::orderBy('name', 'asc')->get();

        return view('admin.apartments.edit', compact('apartment', 'services', 'apartment_images'));
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

        // validazione request
        $request->validated();

        $data = $request->all();


        //creo slug dal nome 
        $apartment->slug = Str::slug($data['name']);


        $slug_found = false;
        $slug_index = 0;

        $apartment->slug = $this->generateUniqueSlug($data['slug']);

        // Riassegno l'essere visibile o meno
        $data['visible'] = Arr::exists($data, 'visible');

        // recupero l'img
        if ($request->hasFile('cover_img')) {
            // aggiunta file nello store
            $img_path = $request->file('cover_img')->store('uploads/cover/', 'public');
            // considero solo il nome del file
            $img_path = explode('/', $img_path)[3];
            // assegno il nome file alla cover img
            $apartment->cover_img = $img_path;
        }

        // aggiungere servizio alla pivot se inserito
        if ($request->has('services')) {
            $apartment->services()->sync($request->input('services'));
        } else {
            $apartment->services()->detach();
        }

        // update imgs
        if ($request->hasFile('apartment_images')) {
            foreach ($request->file('apartment_images') as $image) {
                // aggiunta file nello store
                $path = $image->store('uploads/apartment_images/', 'public');
                // considero solo il nome del file
                $path = explode('/', $path)[3];
                // assegno il nome file alla cover img
                ApartmentImage::create([
                    'apartment_id' => $apartment->id,
                    'url' => $path
                ]);
            }
        }

        // aggiorno i dati del database
        $apartment->update($data);

        // RETURN REDIRECT
        return redirect()->route('admin.apartments.show', compact('apartment', 'apartmentImage'))->with('message-status', 'alert-success')->with('message-text', 'Appartamento modificato con successo');
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

        // eliminare appartamento
        $apartment->delete();

        // RETURN con messaggi di sessioni
        return redirect()->route('admin.apartments.index')->with('message-status', 'alert-danger')->with('message-text', 'Appartamento eliminato con successo');
    }

    // funzione che cambia il valore 
    public function switch_visible(Request $request, Apartment $apartment)
    {

        //protezione rotte
        if (Auth::id() != $apartment->user_id && Auth::user()->role != 'admin')
            abort(403);

        // recuperare la visibilità
        $data = $request->only('visible');

        // se la variabile è presente nel form rendere l'appartamento visibile
        if (!empty($data)) {
            $apartment->visible = 1;
        } else {
            $apartment->visible = 0;
        }

        // salvare il nuovo dato
        $apartment->save();

        // RETURN con messaggi di sessione di operazione riuscita
        return redirect()->route('admin.apartments.index')->with('message-status', 'alert-success')->with('message-text', 'Visibilità modificata con successo');
    }


    public function generateUniqueSlug($string)
    {
        $slug = Str::slug($string);

        $slug_already_exist = Apartment::where('slug', $slug)->count() ? true : false;

        if (!$slug_already_exist) return $slug;

        $counter = 1;

        do {
            $slug = $slug . $counter;

            $slug_already_exist = Apartment::where('slug', $slug)->count() ? true : false;

            if ($slug_already_exist) return $slug;

            $counter++;
        } while ($slug_already_exist);
    }
}
