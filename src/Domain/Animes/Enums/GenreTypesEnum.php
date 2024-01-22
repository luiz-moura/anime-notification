<?php

namespace Domain\Animes\Enums;

enum GenreTypesEnum: string
{
    case DEMOGRAPHIC = 'demographic';
    case THEME = 'theme';
    case EXPLICIT = 'explicit';
    case COMMON = 'common';
}
