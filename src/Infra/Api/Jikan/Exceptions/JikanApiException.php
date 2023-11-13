<?php

namespace Infra\Api\Jikan\Exceptions;

use Exception;
use Illuminate\Support\Facades\Lang;
use Throwable;

class JikanApiException extends Exception {
    public function __construct($code = 0, Throwable $previous) {
        parent::__construct(Lang::get('exceptions.api.jikan.request_failed'), $code, $previous);
    }
}
