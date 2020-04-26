<?php

namespace App\Enums\User;

use BenSampo\Enum\Enum;

final class Status extends Enum
{
    const VERIFIED = '1';
    const UNVERIFIED = '0';
}
