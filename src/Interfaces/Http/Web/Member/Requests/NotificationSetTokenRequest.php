<?php

namespace Interfaces\Http\Web\Member\Requests;

use Infra\Abstracts\Request;

class NotificationSetTokenRequest extends Request
{
    public function rules(): array
    {
        return [
            'token' => ['required', 'string', 'max:255'],
        ];
    }
}
