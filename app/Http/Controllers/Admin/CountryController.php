<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = \App\Models\Country::orderBy('sort');

        if ($request->get('search')) {
            $countries->where(function($query) use ($request) {
                return $query->orWhere('title', 'LIKE', '%'.$request->get('search').'%')
                    ->orWhere('iso', 'LIKE', '%'.$request->get('search').'%');
            });
        }

        return view('admin.countries.index')->with('countries', $countries->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.countries.create');
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
            'iso' => 'required',
        ]);

        $request->request->set('eu', ($request->get('eu') ? 1 : 0));

        $country = new Country();
        $country->fill($request->all());
        $country->save();

        return redirect()->route('country.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('admin.countries.edit')->with('country', $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'title' => 'required',
            'iso' => 'unique:countries,iso,' . $country->id
        ]);

        $request->request->set('eu', ($request->get('eu') ? 1 : 0));

        $country->fill($request->all());
        $country->save();

        return redirect()->route('country.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Country::destroy($id);

        return route('country.index');
    }

    public function delete(Request $request)
    {
        Country::destroy($request->get('ids'));

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
            $country = Country::find($id);
            $country->sort = $key;
            $country->save();
        }

        return true;
    }
}
