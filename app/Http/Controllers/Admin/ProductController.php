<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Pivots\FilterProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = \App\Models\Product::orderBy('sort');

        if ($request->get('search')) {
            $products->where(function($query) use ($request) {
                return $query->orWhere('title', 'LIKE', '%'.$request->get('search').'%')
                    ->orWhere('sku', 'LIKE', '%'.$request->get('search').'%');
            });
        }

        return view('admin.products.index')->with('products', $products->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $request->request->set('slug', Str::slug($request->get('title')));

        $product = new Product();
        $product->fill($request->all());
        $product->save();

        $product->categories()->attach($request->get('category_id'));

        /**
         * Filters koppelen aan het product
         */
        foreach ($request->get('new_filter') as $filter_id => $filters) {
            foreach ($filters as $filter) {
                if (empty($filter['title'])) continue;
                $product->filters()->attach($filter_id, $filter);
            }
        }

        return redirect()->route('product.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $product->fill($request->all());
        $product->save();

        $product->categories()->sync($request->get('category_id'));

        /**
         * Bestaande filters aanpassen in het product
         * Het is op een iets ingewikkelder manier gedaan ivm de vertalingen van spatie/translate
         */
        foreach (($request->get('filter') ?? []) as $filter_id => $filters) {
            foreach ($filters as $id => $filter) {
                if (empty($filter['title'])) {
                    $pivot = FilterProduct::where('id', $id)->delete();
                } else {
                    $pivot = FilterProduct::where('id', $id)->first();
                    $pivot->fill($filter);
                    $pivot->save();
                }
            }
        }
        /**
         * Nieuwe filters koppelen aan het product
         */
        foreach ($request->get('new_filter') as $filter_id => $filters) {
            foreach ($filters as $filter) {
                if (empty($filter['title'])) continue;
                $product->filters()->attach([$filter_id => $filter]);
            }
        }

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);

        return route('product.index');
    }

    public function delete(Request $request)
    {
        Product::destroy($request->get('ids'));

        return true;
    }

    /**
     * Sort resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        foreach ($request->get('items') as $key => $id) {
            $product = Product::find($id);
            $product->sort = $key;
            $product->save();
        }

        return true;
    }
}
