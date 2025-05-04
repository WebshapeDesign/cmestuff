<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePreferencesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'theme' => ['required', 'string', 'in:light,dark,system'],
            'notifications' => ['nullable', 'array'],
            'notifications.*' => ['string', 'in:email,sms,push'],
        ];
    }
} 