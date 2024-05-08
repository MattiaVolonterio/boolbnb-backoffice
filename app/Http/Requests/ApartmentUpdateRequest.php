<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'n_room' => 'required|integer|min:1',
            'n_bathroom' => 'required|integer|min:1',
            'n_bed' => 'required|integer|min:1',
            'lat' => 'required',
            'lon' => 'required',
            'square_meters' => 'required|integer|min:20',
            'floor' => 'required|integer',
            'address' => 'required|string', 
            'cover_img' => 'nullable|image|mimes:jpeg,png|max:2048',
            'apartment_images' => 'nullable|array|max:9',
            'apartment_images.*' => 'nullable|image|mimes:jpeg,png|max:2048',
            'services' => 'required|min:1|exists:services,id'
        ];
    }

    public function messages(){
        return[
            'name.required' => "Il nome dell'appartamento è obbligatorio",
            'name.string' => "Il Nome dell'appartamento non può essere un numero",

            'lat.required' => "L'indirizzo inserito non è valido selezionare uno tra quelli consigliati",
            'lon.required' => "L'indirizzo inserito non è valido selezionare uno tra quelli consigliati",
            
            'n_bathroom.required' => 'Ci deve essere almeno un bagno', 
            'n_bathroom.min' => 'Ci deve essere almeno un bagno',
            'n_bathroom.integer' => 'Il numero dei bagni deve essere un valore numerico',
            
            'n_bed.required' => 'Ci deve essere almeno un letto', 
            'n_bed.min' => 'Ci deve essere almeno un letto',
            'n_bed.integer' => 'Il numero dei letti deve essere un valore numerico',

            'n_room.required' => 'Ci deve essere almeno una stanza', 
            'n_room.min' => 'Ci deve essere almeno una stanza',
            'n_room.integer' => 'Il numero delle stanze deve essere un valore numerico',

            'square_meters.required' => 'Valore dimensione casa non inserito', 
            'square_meters.min' => "L'appartamento deve essere almeno di 20mq",
            'square_meters.integere' => "La dimensione dell'appartamento deve essere un valore numerico",

            'floor.required' => "Numero piano non inserito",
            'floor.integer' => "Il numero del piano deve essere un valore numerico",
            
            'address.required' => "L'indirizzo inserito non è valido selezionare uno tra quelli consigliati",
            'address.string' => "L'indirizzo non può essere un numero",

            'cover_img.image' => 'Immagine di copertina non valida',
            'cover_img.mimes' => 'Formato immagine non valido',
            'cover_img.max' => 'Immagine troppo grande',

            'apartment_images.*.image' => "Devi inserire un'immagine",
            'apartment_images.*.mimes' => 'Formato immagine non valido',
            'apartment_images.*.max' => 'Immagini troppo grandi',

            'apartment_images.max' => 'Troppe immagini caricate',

            'services.required' => 'Almeno un servizio richiesto',
            'services.min' => 'Almeno un servizio richiesto',
            'services.exists' => 'Servizio inesistente',
        ];
    }
}
