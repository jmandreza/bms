<?php

namespace App\Enums;

enum DocumentEnum: string {
    case CoR = "Certificate of Residency";
    case CoI = "Certificate of Indigency";
    case CFTJS = "Certificate of First-Time Job-Seeker";
    case BCert = "Barangay Certificate";
    case CED = "Cedula";
    case BC = "Barangay Clearance";
    case EN = "Endorsement";
}