<?php
namespace App\Enums;

enum AddressType: string {
    case HOME = 'home';
    case OFFICE = 'office';
    case OTHERS = 'others';
}