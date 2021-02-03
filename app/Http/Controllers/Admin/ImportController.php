<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.import.index');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required']);

        $import = new ProductImport($request);
        Excel::import($import, $request->file('file'));

        //$import->rows

        return redirect()->route('import.index');
    }
}
