<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $languages = \App\Models\Language::orderBy('sort');

        if ($request->get('search')) {
            $languages->where(function($query) use ($request) {
                return $query->orWhere('title', 'LIKE', '%'.$request->get('search').'%')
                    ->orWhere('iso', 'LIKE', '%'.$request->get('search').'%');
            });
        }

        return view('admin.languages.index')->with('languages', $languages->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.languages.create');
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
            'iso' => 'required|unique:languages',
            'default' => 'unique:languages'
        ]);

        $request->request->set('default', ($request->get('default') ? 1 : NULL));

        $language = new Language();
        $language->fill($request->all());
        $language->save();

        return redirect()->route('language.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        return view('admin.languages.edit')->with('language', $language);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        $request->validate([
            'title' => 'required',
            'iso' => 'required|unique:languages,iso,' . $language->id,
            'default' => 'unique:languages,default,'. $language->id
        ]);

        $request->request->set('default', ($request->get('default') ? 1 : NULL));

        $language->fill($request->all());
        $language->save();

        return redirect()->route('language.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Language::destroy($id);

        return route('language.index');
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
            $language = Language::find($id);
            $language->sort = $key;
            $language->save();
        }

        return true;
    }

    public function delete(Request $request)
    {
        Language::destroy($request->get('ids'));

        return true;
    }

    /**
     * Set language
     */
    public function setLanguage(Language $language)
    {
        Config::set('app.locale', $language->iso);

        // De URL in segmenten verdelen
        $previous_path_segments = explode('/', ltrim(parse_url(url()->previous())['path'], '/'));
        // Als het eerste segment een taal is, dan kan deze eruit gehaald worden
        if (strlen($previous_path_segments[0]) == 2) {
            array_shift($previous_path_segments);
        }

        // Als de nieuwe iso waarde niet de standaard taal is kan deze toegevoegd worden in de URL
        if ($language->default != 1) {
            array_unshift($previous_path_segments, $language->iso);
        }

        return redirect()->to(implode('/', $previous_path_segments));
    }
}
