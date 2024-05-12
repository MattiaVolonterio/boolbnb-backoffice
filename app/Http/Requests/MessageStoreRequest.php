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
            'apartment_id.required' => 'Appartmaneto non valido',
            'apartment_id.integer' => 'Appartmaneto non valido',
            'apartment_id.exists' => 'Appartmaneto non valido',

            'name.required' => 'Nome non valido',
            'name.string' => 'Nome non valido',
            'name.max' => 'Nome non valido',

            'content.required' => 'Messaggio non valido',
            'content.max' => 'Messaggio non valido',
            'content.string' => 'Messaggio non valido',

            'customer_email.required' => 'Email non valida',
            'customer_email.max' => 'Email non valida',
            'customer_email.email' => 'Email non valida'
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message'=> 'Validation Error',
            'data' => $validator->errors()
        ]));
    }
}
