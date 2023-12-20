<?php

namespace Infra\Storage\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Throwable;

class FailFetchImageException extends Exception {
    public function __construct(Throwable $previous) {
        parent::__construct(Lang::get('exceptions.storage.failed_to_fetch_image'), Response::HTTP_INTERNAL_SERVER_ERROR, $previous);
    }
}
