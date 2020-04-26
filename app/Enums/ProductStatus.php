<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ProductStatus extends Enum
{
    const AVAILABLE = 'available';
    const UNAVAILABLE = 'unavailable';
}
