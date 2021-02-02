<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = \App\Models\Filter::orderBy('sort');

        if ($request->get('search')) {
            $filters->where(function($query) use ($request) {
                return $query->orWhere('title', 'LIKE', '%'.$request->get('search').'%');
            });
        }

        return view('admin.filters.index')->with('filters', $filters->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.filters.create');
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
            'title' => 'required'
        ]);

        $request->request->set('slug', Str::slug($request->get('title')));
        $request->request->set('selectable', ($request->get('selectable') ? 1 : 0));
        $request->request->set('required', ($request->get('required') ? 1 : 0));
        $request->request->set('multiple', ($request->get('multiple') ? 1 : 0));

        $filter = new Filter();
        $filter->fill($request->all());
        $filter->save();

        return redirect()->route('filter.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Filter $filter)
    {
        return view('admin.filters.edit')->with('filter', $filter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Filter $filter)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $request->request->set('slug', Str::slug($request->get('title')));
        $request->request->set('selectable', ($request->get('selectable') ? 1 : 0));
        $request->request->set('required', ($request->get('required') ? 1 : 0));
        $request->request->set('multiple', ($request->get('multiple') ? 1 : 0));

        $filter->fill($request->all());
        $filter->save();

        return redirect()->route('filter.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Filter::destroy($id);

        return route('filter.index');
    }

    public function delete(Request $request)
    {
        Filter::destroy($request->get('ids'));

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
            $filter = Filter::find($id);
            $filter->sort = $key;
            $filter->save();
        }

        return true;
    }
}
