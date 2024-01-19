<?php

namespace Infra\Helpers;

class UrlHelper
{
    public function url(string $path): string
    {
        return url($path);
    }
}
