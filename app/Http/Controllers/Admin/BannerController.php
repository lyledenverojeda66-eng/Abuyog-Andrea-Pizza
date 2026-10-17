<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderByDesc('id')->get();

        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

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
            'image_position' => ['nullable', 'string', 'max:50'],
        ]);

        $destination = public_path('image/banners');

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $imageName = time() . '_' . uniqid() . '.'
            . $request->file('image')->extension();

        $request->file('image')->move($destination, $imageName);

        $nextSortOrder = (Banner::max('sort_order') ?? 0) + 1;

        // Only one uploaded banner should control the homepage hero.
        Banner::query()->update(['status' => false]);

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
            ->with('success', 'Banner uploaded and activated successfully!');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

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
            'image_position' => ['nullable', 'string', 'max:50'],
        ]);

        $destination = public_path('image/banners');
        $imageName = $banner->image;
        $oldImage = null;

        if ($request->hasFile('image')) {
            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            $newImageName = time() . '_' . uniqid() . '.'
                . $request->file('image')->extension();

            $request->file('image')->move($destination, $newImageName);

            $oldImage = $destination . DIRECTORY_SEPARATOR . $banner->image;
            $imageName = $newImageName;
        }

        $banner->title = $validated['title'] ?? null;
        $banner->description = $validated['description'] ?? null;
        $banner->button_text = $validated['button_text'] ?? null;
        $banner->button_link = $validated['button_link'] ?? null;
        $banner->sort_order = $validated['sort_order'] ?? $banner->sort_order;
        $banner->image = $imageName;
        $banner->image_position = $validated['image_position']
            ?? $banner->image_position
            ?? '50% 50%';

        // Saving a banner activates it unless the form explicitly deactivates it.
        $shouldActivate = !$request->has('status')
            || $request->boolean('status')
            || $request->hasFile('image');

        if ($shouldActivate) {
            Banner::where('id', '!=', $banner->id)
                ->update(['status' => false]);

            $banner->status = true;
        } else {
            $banner->status = false;
        }

        $banner->save();

        if ($oldImage && File::exists($oldImage)) {
            File::delete($oldImage);
        }

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        $image = public_path('image/banners/' . $banner->image);

        $banner->delete();

        if (File::exists($image)) {
            File::delete($image);
        }

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully!');
    }

    public function toggle(Banner $banner)
    {
        if ($banner->status) {
            $banner->status = false;
            $banner->save();

            return back()->with(
                'success',
                'Banner deactivated. The default hero banner will be displayed.'
            );
        }

        Banner::where('id', '!=', $banner->id)
            ->update(['status' => false]);

        $banner->status = true;
        $banner->save();

        return back()->with('success', 'Banner activated successfully!');
    }
}