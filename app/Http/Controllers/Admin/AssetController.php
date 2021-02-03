<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');

        /**
         * Als het een enkel bestand is de huidige verwijderen
         */
        if ($request->get('single') == 1) {
            $asset = \App\Models\Asset::where('parent_id', $request->get('parent_id'))->where('module', $request->get('module'))->first();
            if ($asset) {
                $this->destroy($asset);
            }
        }

        if (preg_match('/image/', $file->getMimeType())) {

            $newFileName = $request->get('module') . '_' . Str::random(20) . '.' . $file->getClientOriginalExtension();

            $filePath = Storage::disk('public')->path($newFileName);

            $img = Image::make($file->path());
            $img->resize($request->get('width') ?? 1280, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save($filePath);

            $asset = new Asset();
            $asset->file = $newFileName;
            $asset->parent_id = $request->get('parent_id');
            $asset->module = $request->get('module');
            $asset->file_data = $request->get('file_data');
            $asset->save();

            return $newFileName;
        }
    }

    public function update(Request $request, Asset $asset)
    {
        $asset->file_data = $request->get('file_data');
        $asset->save();

        echo 1;
    }

    public function destroy(Asset $asset)
    {
        Storage::disk('public')->delete($asset->file);

        $asset->delete();
    }

    public function sort(Request $request)
    {
        foreach ($request->get('items') as $key => $id) {
            $asset = Asset::find($id);
            $asset->sort = $key;
            $asset->save();
        }

        echo 1;
    }
}
