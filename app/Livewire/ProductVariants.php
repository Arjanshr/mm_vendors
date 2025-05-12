<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Log;

class ProductVariants extends Component
{
    public $product;
    public $variantSpecifications;
    public $specifications = [];
    public $variants = [];

    public function mount($product, $variantSpecifications)
    {
        $this->product = $product;

        // Ensure $variantSpecifications is an array
        $this->variantSpecifications = is_array($variantSpecifications)
            ? $variantSpecifications
            : $variantSpecifications->toArray();
    }


    public function generateVariants()
    {
        $values = array_map(function ($value) {
            return is_string($value) ? explode(',', $value) : (array) $value;
        }, array_filter($this->specifications));
    
        if (empty($values)) {
            $this->variants = [];
            return;
        }
    
        $combinations = $this->generateCombinations($values);
    
        // Correctly format the variant name to include "SpecificationName:Value"
        $this->variants = array_map(function ($combination) use ($values) {
            $formattedName = [];
            foreach ($combination as $index => $value) {
                $specificationName = array_keys($this->specifications)[$index];
                $formattedName[] = "{$specificationName}:{$value}";
            }
    
            return [
                'name' => implode(' / ', $formattedName),
                'price' => null,
                'stock' => null,
            ];
        }, $combinations);
    }
    

    private function generateCombinations($arrays, $prefix = [])
    {
        if (!is_array($arrays)) {
            throw new \InvalidArgumentException('Expected $arrays to be an array.');
        }

        if (!$arrays) {
            return [$prefix];
        }

        $result = [];
        $current = array_shift($arrays);

        if (!is_array($current)) {
            throw new \InvalidArgumentException('Expected $current to be an array.');
        }

        foreach ($current as $value) {
            $result = array_merge($result, $this->generateCombinations($arrays, array_merge($prefix, [$value])));
        }

        return $result;
    }

    public function saveVariants()
    {
        // Validate the price and stock fields for all variants
        $this->validate([
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
        ]);
    
        foreach ($this->variants as $variant) {
            // Generate a unique SKU
            $sku = $this->generateUniqueSku($variant, $this->product);
    
            // Check if the variant already exists, or create a new one
            $newVariant = $this->product->variants()->firstOrCreate(
                ['sku' => $sku], // Search condition
                [ // Default values if not found
                    'price' => 0,
                    'stock_quantity' => 0,
                ]
            );
    
            // Update the variant's price and stock
            $newVariant->update([
                'price' => $variant['price'],
                'stock_quantity' => $variant['stock'],
            ]);
    
            // Process and save variant options
            $options = explode(' / ', $variant['name']);
            // dd($options);
            foreach ($options as $option) {
                // Validate the option format
                if (strpos($option, ':') !== false) {
                    // dd('hi');
                    [$specificationName, $value] = explode(':', $option, 2);
    
                    // Trim to ensure clean inputs
                    $specificationName = trim($specificationName);
                    $value = trim($value);
    
                    // Find the corresponding specification
                    $specification = collect($this->variantSpecifications)
                        ->firstWhere('name', $specificationName);
    
                    if ($specification) {
                        // Update or create the variant option
                        $newVariant->variant_options()->updateOrCreate(
                            [
                                'specification_id' => $specification['id'],
                            ],
                            [
                                'value' => $value,
                            ]
                        );
                    } else {
                        // Log or handle missing specification
                        Log::warning('Specification not found', [
                            'specificationName' => $specificationName,
                            'value' => $value,
                        ]);
                    }
                } else {
                    // Log or handle invalid option format
                    Log::warning('Invalid option format', ['option' => $option]);
                }
            }
        }
        toastr()->success('Variants created successfully.');
        // Flash a success message and clear the variants array
        session()->flash('success', 'Variants saved successfully!');
        $this->variants = []; // Clear the variants array after saving
    }
    


    private function generateUniqueSku($variant_data, $product)
    {
        // Define the specifications that should be included in the SKU
        $sku_parts = [];
        $sku_parts[0] = strtoupper($product->slug);

        // Dynamically loop through the variant data to create SKU
        foreach ($variant_data as $key => $value) {
            // Exclude non-specification fields like price and stock_quantity
            if ($key !== 'price' && $key !== 'stock' && $key !== 'sku') {
                // Format the specification part (e.g., RAM-8GB, ROM-128GB, COLOR-Black)
                $sku_parts[] = strtoupper($key) . '-' . strtoupper($value);
            }
        }

        // If no valid parts are available for SKU, throw an error
        if (empty($sku_parts)) {
            throw new \Exception("Failed to generate SKU. Missing required specifications.");
        }

        // Generate the SKU by joining the parts with a dash
        return implode('-', $sku_parts);
    }

    public function removeVariant($index)
    {
        if (isset($this->variants[$index])) {
            unset($this->variants[$index]);

            // Re-index the array to avoid gaps
            $this->variants = array_values($this->variants);
        }
    }

    public function render()
    {
        return view('admin.livewire.product-variants');
    }
}
