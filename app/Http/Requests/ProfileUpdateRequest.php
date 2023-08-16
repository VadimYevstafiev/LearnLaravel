<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name' => ['required', 'string', 'string', 'max:35'],
            'surname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'string', 'max:255', Rule::unique(User::class)->ignore($userId)],
            'phone' => ['required', 'string', 'max:15', Rule::unique(User::class)->ignore($userId), new Phone],
            'birthdate' => ['date', 'before_or_equal:-18 years'],
        ];
    }
}
