<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class MessageStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'apartment_id' => 'required|exists:apartments,id|integer',
            'name' => 'required|string|max:50',
            'content' => 'required|string|max:65535',
            'customer_email' => 'required|email|max:255',
        ];
    }

    public function messages()
    {
        return[
            'apartment_id.required' => 'Appartamento non valido',
            'apartment_id.integer' => 'Appartamento non valido',
            'apartment_id.exists' => 'Appartamento non valido',

            'name.required' => 'Questo campo non deve essere vuoto',
            'name.string' => 'Inserisci un nome',
            'name.max' => 'Hai superato il limite massimo di caratteri',

            'content.required' => 'Questo campo non deve essere vuoto',
            'content.max' => 'Il tuo messaggio è troppo lungo',
            'content.string' => 'Inserisci del testo',

            'customer_email.required' => 'Questo campo non deve essere vuoto',
            'customer_email.max' => 'Inserisci un indirizzo email valido',
            'customer_email.email' => 'Inserisci un indirizzo email valido'
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Se è un numero, aggiungo un errore di validazione
            if ($this->nameIsNumeric($this->input('name'))) {
                $validator->errors()->add('name', 'Il nome non può essere un numero.');
            }
        });
    }

    protected function nameIsNumeric($name)
    {
        // Controllo se è un numero
        return is_numeric($name);

    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message'=> 'Validation Error',
            'data' => $validator->errors()
        ]));
    }
}
