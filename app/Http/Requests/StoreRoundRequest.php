<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoundRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number' => ['nullable', 'integer', 'min:1'],
            'kingdom' => ['nullable', 'string', 'max:255'],
            'contract' => ['nullable', 'string', 'max:255'],
            'bid_team_id' => ['nullable', 'exists:teams,id'],
            'bid_amount' => ['nullable', 'integer'],
            'payload' => ['required', 'array'],
        ];
    }
}
