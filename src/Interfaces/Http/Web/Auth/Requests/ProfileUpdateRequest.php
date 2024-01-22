<?php

namespace Interfaces\Http\Web\Auth\Requests;

use Illuminate\Validation\Rule;
use Infra\Abstracts\Request;
use Infra\Persistente\Eloquent\Models\User;

class ProfileUpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}
