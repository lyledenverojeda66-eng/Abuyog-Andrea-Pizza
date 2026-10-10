<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BANNER LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $banners = Banner::orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view(
            'admin.banners.index',
            compact('banners')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADD BANNER PAGE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.banners.create');
    }


    /*
    |--------------------------------------------------------------------------
    | SAVE BANNER
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CREATE BANNER FOLDER
        |--------------------------------------------------------------------------
        */

        $destination = public_path(
            'image/banners'
        );


        if (!File::exists($destination)) {

            File::makeDirectory(
                $destination,
                0755,
                true
            );
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE IMAGE NAME
        |--------------------------------------------------------------------------
        */

        $imageName =
            time()
            . '_'
            . uniqid()
            . '.'
            . $request
                ->file('image')
                ->extension();


        /*
        |--------------------------------------------------------------------------
        | MOVE IMAGE
        |--------------------------------------------------------------------------
        */

        $request
            ->file('image')
            ->move(
                $destination,
                $imageName
            );


        /*
        |--------------------------------------------------------------------------
        | AUTOMATIC SORT ORDER
        |--------------------------------------------------------------------------
        */

        $nextSortOrder =
            (Banner::max('sort_order') ?? 0) + 1;


        /*
        |--------------------------------------------------------------------------
        | SAVE BANNER
        |--------------------------------------------------------------------------
        */

        Banner::create([

            'title' =>
                $validated['title']
                ?? null,

            'description' => null,

            'image' =>
                $imageName,

            'button_text' => null,

            'button_link' => null,

            'sort_order' =>
                $nextSortOrder,

            /*
            | Newly uploaded banners are automatically active.
            */

            'status' => true,
        ]);


        return redirect()
            ->route('admin.banners.index')
            ->with(
                'success',
                'Banner uploaded successfully!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT BANNER
    |--------------------------------------------------------------------------
    */

    public function edit(Banner $banner)
    {
        return view(
            'admin.banners.edit',
            compact('banner')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE BANNER
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Banner $banner
    ) {

        $validated = $request->validate([
            'title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        $imageName = $banner->image;


        /*
        |--------------------------------------------------------------------------
        | REPLACE IMAGE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $oldImage = public_path(
                'image/banners/'
                . $banner->image
            );


            if (File::exists($oldImage)) {

                File::delete($oldImage);
            }


            $destination = public_path(
                'image/banners'
            );


            if (!File::exists($destination)) {

                File::makeDirectory(
                    $destination,
                    0755,
                    true
                );
            }


            $imageName =
                time()
                . '_'
                . uniqid()
                . '.'
                . $request
                    ->file('image')
                    ->extension();


            $request
                ->file('image')
                ->move(
                    $destination,
                    $imageName
                );
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $banner->update([

            'title' =>
                $validated['title']
                ?? null,

            'image' =>
                $imageName,
        ]);


        return redirect()
            ->route('admin.banners.index')
            ->with(
                'success',
                'Banner updated successfully!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE BANNER
    |--------------------------------------------------------------------------
    */

    public function destroy(Banner $banner)
    {
        $image = public_path(
            'image/banners/'
            . $banner->image
        );


        if (File::exists($image)) {

            File::delete($image);
        }


        $banner->delete();


        return redirect()
            ->route('admin.banners.index')
            ->with(
                'success',
                'Banner deleted successfully!'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVATE / DEACTIVATE
    |--------------------------------------------------------------------------
    */

    public function toggle(Banner $banner)
    {
        $banner->update([
            'status' => !$banner->status,
        ]);


        return back()->with(
            'success',
            $banner->status
                ? 'Banner activated!'
                : 'Banner deactivated!'
        );
    }
}