<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SponsorshipStoreRequest extends FormRequest
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
            'apartment_id' => 'exists:apartments,id',
            'sponsorship_id' => 'exists:sponsorships,id',
        ];
    }

    public function messages()
    {
        return [
            'apartment_id.exists' => "L'appartmento selezionato non esiste",
            'sponsorship_id.exists' => "La sponsorship selezionata non esiste",
        ];
    }
}
