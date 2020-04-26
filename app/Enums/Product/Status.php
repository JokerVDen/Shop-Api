<?php

namespace App\Enums\Product;

use BenSampo\Enum\Enum;

final class Status extends Enum
{
    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';
}
