<?php
namespace App\Enums;

enum PaymentType: string {
    case CASH = 'cash';
    case ONLINE = 'online';
    case MIXED = 'mixed';
    case Others = 'Others';
}