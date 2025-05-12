<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'category_id'=>['required','array'],
            'description'=>['nullable','string'],
            'price'=>['nullable','numeric'],
            'image'=>['nullable','mimes:jpeg,png,jpg,gif,svg,ico,pdf','max:2048'],
            'status'=>['required',new Enum(ProductStatus::class)],
            'alt_text'=>['nullable','string'],
            'keywords' => ['nullable', 'string'],
        ];
    }

    protected function passedValidation()
    {
        if ($this->hasFile('image')) {
            $image_name = rand(0, 99999) . time() . '.' . $this->image->extension();
            $this->image->move(storage_path('app/public/products'), $image_name);
            $this['image']->file_name = $image_name;
        }
    }

}
