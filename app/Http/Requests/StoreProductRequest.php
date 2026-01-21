<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9-]+$/', 'unique:products,slug'],
            'description'       => ['nullable', 'string', 'max:1000'],
            'price_cents'       => ['required', 'integer', 'min:0'],
            'stock'             => ['required', 'integer', 'min:0'],
            'category_id'       => ['required', 'exists:categories,id'],
            'harvest_batch_id'  => ['nullable', 'exists:harvest_batches,id'],

            'image'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'is_active'         => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Názov produktu je povinný',
            'name.max'              => 'Názov nesmie byť dlhší ako 255 znakov',
            'price_cents.required'  => 'Cena je povinná',
            'price_cents.integer'   => 'Cena musí byť číslo',
            'price_cents.min'       => 'Cena musí byť najmenej 0',
            'category_id.required'  => 'Kategória je povinná',
            'category_id.exists'    => 'Zvolená kategória neexistuje',

            'image.image'           => 'Súbor musí byť obrázok',
            'image.mimes'           => 'Obrázok musí byť vo formáte JPG, PNG alebo WebP',
            'image.max'             => 'Obrázok môže mať max 2MB',
        ];
    }
}
