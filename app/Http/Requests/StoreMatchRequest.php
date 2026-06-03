<?php

namespace App\Http\Requests;

use App\Enums\GameType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreMatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'game_type' => ['required', new Enum(GameType::class)],
            'settings' => ['nullable', 'array'],
            'teams' => ['required', 'array', 'min:2'],
            'teams.*.name' => ['required', 'string', 'max:255'],
            'teams.*.position' => ['nullable', 'integer', 'min:1'],
            'teams.*.active' => ['nullable', 'string'],
            'teams.*.player_ids' => ['nullable', 'array', 'min:1'],
            'teams.*.player_ids.*' => ['exists:players,id'],
        ];
    }
}
