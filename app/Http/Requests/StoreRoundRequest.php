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
        $rules = [
            'number' => ['nullable', 'integer', 'min:1'],
            'kingdom' => ['nullable', 'string', 'max:255'],
            'contract' => ['nullable', 'string', 'max:255'],
            'bid_team_id' => ['nullable', 'exists:teams,id'],
            'bid_amount' => ['nullable', 'integer'],
            'payload' => ['required', 'array'],
        ];

        $match = $this->route('match');

        if ($match?->game_type?->value === 'tarneeb_41') {
            $rules['payload.bids'] = ['required', 'array'];
            $rules['payload.tricks'] = ['required', 'array'];
            $rules['payload.bids.*'] = ['required', 'integer'];
            $rules['payload.tricks.*'] = ['required', 'integer'];
        }

        return $rules;
    }
}
