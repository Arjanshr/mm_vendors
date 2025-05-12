<?php
namespace App\Enums;

enum ProductStatus: string {
    case PUBLISH = 'publish';
    case UNPUBLISH = 'unpublish';
}