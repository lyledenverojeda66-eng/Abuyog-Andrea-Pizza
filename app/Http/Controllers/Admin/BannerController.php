<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * Display all banners.
     */
    public function index()
    {
        $banners = Banner::orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the create banner form.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a new banner.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'image_position' => [
                'nullable',
                'string',
                'max:50',
            ],
        ]);

        $destination = public_path('image/banners');

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $imageName = time()
            . '_'
            . uniqid()
            . '.'
            . $request->file('image')->extension();

        $request->file('image')->move(
            $destination,
            $imageName
        );

        $nextSortOrder = (Banner::max('sort_order') ?? 0) + 1;

        Banner::create([
            'title' => $validated['title'] ?? null,
            'description' => null,
            'image' => $imageName,
            'image_position' => $validated['image_position'] ?? '50% 50%',
            'button_text' => null,
            'button_link' => null,
            'sort_order' => $nextSortOrder,
            'status' => true,
        ]);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner uploaded successfully!');
    }

    /**
     * Show the edit banner form.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update an existing banner.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'boolean'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'image_position' => [
                'nullable',
                'string',
                'max:50',
            ],
        ]);

        $imageName = $banner->image;

        if ($request->hasFile('image')) {
            $destination = public_path('image/banners');

            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            $newImageName = time()
                . '_'
                . uniqid()
                . '.'
                . $request->file('image')->extension();

            $request->file('image')->move(
                $destination,
                $newImageName
            );

            $oldImage = $destination . DIRECTORY_SEPARATOR . $banner->image;

            $imageName = $newImageName;

            if (File::exists($oldImage)) {
                File::delete($oldImage);
            }
        }

        $banner->title = $validated['title'] ?? null;
        $banner->description = $validated['description']
            ?? $banner->description;
        $banner->button_text = $validated['button_text']
            ?? $banner->button_text;
        $banner->button_link = $validated['button_link']
            ?? $banner->button_link;
        $banner->sort_order = $validated['sort_order']
            ?? $banner->sort_order;
        $banner->image = $imageName;
        $banner->image_position = $validated['image_position']
            ?? $banner->image_position
            ?? '50% 50%';

        if ($request->has('status')) {
            $banner->status = $request->boolean('status');
        }

        $banner->save();

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner updated successfully!');
    }

    /**
     * Delete a banner.
     */
    public function destroy(Banner $banner)
    {
        $image = public_path(
            'image/banners/' . $banner->image
        );

        if (File::exists($image)) {
            File::delete($image);
        }

        $banner->delete();

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully!');
    }

    /**
     * Activate or deactivate a banner.
     */
    public function toggle(Banner $banner)
    {
        $banner->status = !$banner->status;
        $banner->save();

        return back()->with(
            'success',
            $banner->status
                ? 'Banner activated!'
                : 'Banner deactivated!'
        );
    }
}
