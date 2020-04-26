<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserStatus extends Enum
{
    const VERIFIED = '1';
    const UNVERIFIED = '0';
}
