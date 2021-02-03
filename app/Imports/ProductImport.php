<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public $rows = 0;
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->rows++;

        /**
         * De regels uitlezen
         */

        $fields = [];
        $filters = [];
        $category_ids = [];

        foreach ($row as $field => $value) {

            if ($field == null || $field == '') continue;

            // // Vat veld omzetten
            // if ($field == 'vat') {
            //     $vat = Vat::where('vat', $value)->first();
            //     $field = 'vat_id';
            //     $value = $vat->id;
            // }

            // Slug voor product maken
            // Vat veld omzetten
            if ($field == 'title') {
                $fields['slug'] = Str::slug($value);
            }

            if ($field == 'price') {
                // Prijs notatie controleren
                if(substr_count($value, '.') == 0 && substr_count($value, ',') == 1) { // als de eerste een komma is
                    $value = str_replace(',','.',$value);
                }
            }

            if(Schema::hasColumn('products', $field) == true) {
                $json_value = json_decode($value);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $fields[$field] = $json_value;
                } else {
                    $fields[$field] = $value;
                }
            } else {

                if ($field == 'category') {

                    if ($this->request->get('categories')) {
                        foreach ($this->request->get('categories') as $category) {
                            $category_ids[] = $category;
                        }
                    }

                    if ($this->request->get('category_import')) {

                            $category_ids[] = $this->request->get('category_import');

                            $category = Category::firstOrCreate(
                                ['title' => $value],
                                [
                                    'parent_id' => $this->request->get('category_import'),
                                    'slug' => Str::slug($value)
                                ],
                            );

                            $category_ids[] = $category->id;
                    } else {

                        $category = Category::firstOrCreate(
                            ['title->'.Config::get('app.locale') => $value],
                            [
                                'title' => $value,
                                'slug' => Str::slug($value)
                            ],
                        );

                        $category_ids[] = $category->id;
                    }

                } else {
                    $filters[$field] = $value;
                }
            }
        }

        $row['sku'] = $row['sku'] ?? '';
        $row['price'] = $row['price'] ?? 0;
        $row['title'] = $row['title'] ?? '';

        // Select filters
        //$filters = array_slice($row, 4, count($row)-1, true);

        $product = Product::updateOrCreate(
            ['sku' => $row['sku']], $fields
        );

        if (is_array($category_ids)) {
            $product->categories()->sync($category_ids);
        }

        $product->filters()->detach();

        if (is_array($filters)) {
            foreach ($filters as $filter_title => $options) {
                if (empty($filter_title)) continue;
                $filterObj = Filter::firstOrCreate(
                    ['title->'.Config::get('app.locale') => ucfirst($filter_title)],
                    [
                        'title' => ucfirst($filter_title),
                        'slug' => Str::slug($filter_title)
                    ]
                );

                if(json_decode($options, TRUE) == false) {
                    $options = str_replace(['{','}'],['[',']'],$options);
                    foreach ((json_decode($options) ?? (array) $options) as $option) {
                        $product->filters()->attach($filterObj->id, [
                            'title' => $option ?? '',
                            'price' => 0,
                            'slug' => Str::slug($option ?? '')
                        ]);
                    }
                } else {
                    if (json_decode($options)) {
                        foreach (json_decode($options, TRUE) as $option => $price) {
                            // Prijsnotatie controleren een aanpassen
                            if(substr_count($price, '.') == 0 && substr_count($price, ',') == 1) { // als de eerste een komma is
                                $price = str_replace(',','.',$price);
                            }
                            $product->filters()->attach($filterObj->id, [
                                'title' => $option ?? '',
                                'price' => (float) $price ?? 0,
                                'slug' => Str::slug($option ?? '')
                            ]);
                        }
                    }
                }
            }
        }

        return $product;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
