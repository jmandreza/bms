<?php

namespace App\Enums;

enum CivilStatusEnum: string {
    case Single = "single";
    case Married = "married";
    case Widowed = "widowed";
    case Separared = "separated";
}