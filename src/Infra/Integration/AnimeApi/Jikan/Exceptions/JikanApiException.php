<?php

namespace Infra\Integration\AnimeApi\Jikan\Exceptions;

use Exception;
use Illuminate\Support\Facades\Lang;
use Throwable;

class JikanApiException extends Exception
{
    private const CODE = 500;

    public function __construct(Throwable $previous)
    {
        parent::__construct(Lang::get('exceptions.api.jikan.request_failed'), self::CODE, $previous);
    }
}
