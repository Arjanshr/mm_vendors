<?php

namespace App\Http\Requests;

use App\Enums\AddressType;
use App\Enums\PaymentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_date' => ['nullable', 'date'],
            'customer_id' => ['nullable', 'numeric', 'exists:users,id'],
            'address_id' => ['nullable', 'numeric', 'exists:addresses,id'],
            'reciever_name' => ['required', 'string'],
            'address_type' => ['required', new Enum(AddressType::class)],
            'province_id' => ['required', 'string'],
            'city_id' => ['required', 'string'],
            'area_id' => ['required', 'numeric', 'exists:areas,id'],
            'location' => ['required', 'string'],
            'email' => ['nullable', 'email'],
            'phone_number' => ['required', 'string'],

            'payment_type' => ['required', new Enum(PaymentType::class)],
            'payment_status' => ['required', 'string'],

            'coupon_code' => ['nullable', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'numeric', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:1'],
            'items.*.variant_id' => ['nullable', 'numeric', 'exists:product_variants,id'],
        ];
    }
}
