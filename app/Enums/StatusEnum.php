<?php

namespace App\Enums;

enum StatusEnum: string {
    case Pending = 'pending';
    case Approved = 'approved';
    case Ready = 'ready';
    case Completed = 'completed';
    case Cancelled = 'candelled';
    case Declined = 'declined';
}