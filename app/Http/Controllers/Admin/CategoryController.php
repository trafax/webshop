<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = \App\Models\Category::orderBy('sort');

        if ($request->get('search')) {
            $categories->where(function($query) use ($request) {
                return $query->orWhere('title', 'LIKE', '%'.$request->get('search').'%');
            });
        } else {
            $categories->where('parent_id', 0);
        }

        return view('admin.categories.index')->with('categories', $categories->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
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

        $category = new Category();
        $category->fill($request->all());
        $category->save();

        return redirect()->route('category.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $request->request->set('slug', Str::slug($request->get('title')));

        $category->fill($request->all());
        $category->save();

        // $translation = new Translation();
        // $translation->translate('category', $category->id, ['title'], $request);

        return redirect()->route('category.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::destroy($id);

        return route('category.index');
    }

    public function delete(Request $request)
    {
        Category::destroy($request->get('ids'));

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
            $category = Category::find($id);
            $category->sort = $key;
            $category->save();
        }

        return true;
    }
}
