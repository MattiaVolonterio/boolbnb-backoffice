<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Braintree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // recupero tutte le sponsor
        $sponsorships = Sponsorship::all();

        // selezionare tutti gli appartamenti dell'utente
        $apartments = Apartment::select('id', 'name')->where('user_id', Auth::id())->get();
        
        // RETURN 
        return view('admin.sponsorships.index', compact('sponsorships', 'apartments'));
    }

    /**
     * Show the form for creating a new resources
     */
    public function create(Request $request)
    {

        // inizializzazione variabili data inizio e data fine
        $end_date = null;
        $start_date = null;

        // recupero id di appartamento e sponsor selezionati dall'utente
        $sponsorhip_id = $request->query()['sponsorship_id'];
        $apartment_id = $request->query()['apartment_id'];

        // recupero l'appartamento e la sponsor dal database in base all'id inserito
        $apartment = Apartment::find($apartment_id);
        $sponsor = Sponsorship::find($sponsorhip_id);

        // inizializzazione durata della sponsor
        $duration = $sponsor->duration;

        // controllo se ci sono sponsorizzazioni attive sull'appartmento selezionato
        $apartment_sponsorship = $apartment->sponsorships()->where('end_date', '>', now());
        $array_apsponsor = $apartment_sponsorship->get()->toArray();

        // se l'appartamento ha già una sponsor ne creo una partendo dall'ultima scadenza
        if ($apartment_sponsorship != null) {
            // se esiste solo una sponsor prendo la prima altrimenti prendo l'ultima sponsor
            $apartment_sponsorship = count($array_apsponsor) == 1 ? $apartment_sponsorship->first() : $apartment_sponsorship->orderBy('end_date', 'DESC')->first(); 

            // in caso la data di fine e sia valida
            if ($apartment_sponsorship->pivot->end_date && $apartment_sponsorship->pivot->end_date > now()->format('Y-m-d H:i:s')) {
                // creo la data d'inizio
                $start_date_sec = strtotime($apartment_sponsorship->pivot->end_date);
                $start_date = date("d-m-Y H:i:s", $start_date_sec);
                
                // calcolo il tempo rimanente alla precedente sottoscrizione
                $time_remaining = strtotime($apartment_sponsorship->pivot->end_date) - strtotime(now());
                
                // calcolo la data di fine aggiungendo durata e tempo rimasto
                $end_date = date("d-m-Y H:i:s", strtotime("+" . $duration . ' Hours' . $time_remaining . ' seconds'));
            }
            
            else {
                // creo data iniziale in caso di nessuna sponsor valida
                $start_date = now()->format('d-m-Y H:i:s');
                
                // calcolo la data di fine
                $expiration = strtotime("+" . $duration . ' Hours');
                $end_date = date("d-m-Y H:i:s", $expiration);
            }
        } else {
            // creo data iniziale in caso di nessuna sponsor
            $start_date = now()->format('d-m-Y H:i:s');
            
            // calcolo la data di fine
            $expiration = strtotime("+" . $duration . ' Hours');
            $end_date = date("d-m-Y H:i:s", $expiration);
        }


        // RETURN
        return view('admin.sponsorships.payment_page', compact('apartment', 'sponsor', 'start_date', 'end_date'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        // request dei dati inseriti TODO da eseguire validazione
        $data = $request->all();

        // creo il gateway braintree con le varie chiavi
        $gateway = new Braintree\Gateway([
            'environment' => env('BT_ENVIRONMENT'),
            'merchantId' => env('BT_MERCHANT_ID'),
            'publicKey' => env('BT_PUBLIC_KEY'),
            'privateKey' => env('BT_PRIVATE_KEY')
        ]);

        // recupero la spesa e il metodo di pagamento
        $amount = $data['amount'];
        $nonce = $data['payment_method_nonce'];

        // creo la transazione
        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
                ]
        ]);

        // se la transazione ha successo
        if($result->success || !is_null($result->transaction)){ 
            // recupero l'appartamento selezionato
            $apartment = Apartment::find($data['apartment_id']);

            // creo la data di inizio e la data di fine in base a quella calcolata precedentemente
            $end_date_str = strtotime($data['end_date']);
            $start_date_str = strtotime($data['start_date']);

            $end_date = date("Y-m-d H:i:s", $end_date_str);
            $start_date = date("Y-m-d H:i:s", $start_date_str);
            
            // aggiungo la sponsor appena creata nel database
            $apartment->sponsorships()->attach($data['sponsorship_id'], ['start_date' => $start_date, 'end_date' => $end_date]);

            // RETURN con messaggi di avvenuta sottoscrizione
            return redirect()->route('admin.apartments.show', $apartment->id)->with('message-status', 'alert-success')->with('message-text', 'Sottoscrizione effettuata con successo');
        }
    }
}