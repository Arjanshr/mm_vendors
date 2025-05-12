<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Feature;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\Specification;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductsImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $brand = null;
            if ($row['brand'] != null) {
                $brand = Brand::firstOrCreate(
                    [
                        'name' => $row['brand']
                    ]
                );
            }
            $category = null;
            if ($row['category'] != null) {
                $category = Category::firstOrCreate(
                    [
                        'name' => $row['category']
                    ]
                );
            }
            $product = Product::firstOrCreate(
                [
                    'name' => str_replace(array("\r", "\n"), '', $row['name'])
                ]
            );
            $product->description = $row['description'];
            $product->brand_id = $brand->id ?? null;
            $product->price = $row['price'] ?? 0;
            $product->status = $row['status'] ? 'publish' : 'unpublish';
            $product->save();
            if ($row['category'] != null&&$category) {
                $category_ids[0] = $category->id;
                $product->categories()->sync($category_ids);
            }

            if (isset($row['images'])) {
                $images = explode('|', $row['images']);
                foreach ($images as $image) {
                    $product_images[] = explode(',', $image);
                }
                foreach ($product_images as $index => $product_image) {
                    foreach ($product_image as $key_value) {
                        $kv = explode(":", $key_value);
                        $img[$index][$kv[0]] = $kv[1];
                    }
                }

                foreach ($img as $i) {
                    if (ProductImage::where('image', $i['product_image'])->get()->count() == 0) {
                        $product_image = new ProductImage();
                        $product_image->image_order = $i['image_order'] != null ? $i['image_order'] : 0;
                        $product_image->image =  $i['product_image'];
                        $product_image->is_primary = $i['image_order'] == 1 ? 1 : 0;
                        $product_image->product_id = $product->id;
                        $product_image->save();
                    }
                }
            }
            if ($row['specifications'] != null) {
                $text = $row['specifications'];
                str_replace(array("\r", "\n"), '', $text);
                $specifications = explode('|', $text);
                foreach ($specifications as $specification) {
                    $specs[] = explode(':', $specification, 2);
                }

                foreach ($specs as $count => $spec) {
                    $key = str_replace(array("\r", "\n"), '', trim(count($spec) == 2 ? $spec[0] : 'Undefined' . $count));
                    if (count($spec) == 1) {
                        $value = $spec[0];
                    } elseif (count($spec) == 2) {
                        $value = $spec[1];
                    }
                    $value = str_replace(array("\r", "\n"), '', trim($value));
                    $s[$key] = $value;
                }

                foreach ($s as $specification_key => $specification_value) {
                    $specification = Specification::firstOrCreate(
                        [
                            'name' =>  $specification_key
                        ]
                    );
                    if ($specification_value || $specification_value != null || $specification_value != '') {
                        $product_specification = ProductSpecification::firstOrCreate(
                            [
                                'product_id' => $product->id,
                                'specification_id' => $specification->id,
                            ]
                        );
                        $product_specification->value = $specification_value;
                        $product_specification->save();
                    }
                }
            }

            if ($row['features'] != null) {
                $features = explode('|', $row['features']);
                foreach ($features as $feature) {
                    $f = new Feature();
                    $f->product_id = $product->id;
                    $f->feature = $feature;
                    $f->save();
                }
            }
        }
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
