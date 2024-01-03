<?php

namespace Interfaces\Http\Api\Auth\Requests;

use Infra\Abstracts\Request;

class LoginRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }
}
