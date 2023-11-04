<?php

namespace App\Enums;

enum UserRole: string
{
    case Staff = 'staff';
    case HumanResource = 'hr';
    case Manager = 'manager';
    case Inactive = 'inactive';
}
