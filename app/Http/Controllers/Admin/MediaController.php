<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MediaAsset;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Requests\Admin\MediaRequest;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::query()->latest();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('file_name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('type') && $request->type !== 'all') {
            if ($request->type === 'image') {
                $query->where('mime_type', 'like', 'image/%');
            } else {
                $query->where('mime_type', 'not like', 'image/%');
            }
        }

        $media = $query->paginate(24)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($media);
        }

        return view('admin.media.index', compact('media'));
    }

    public function store(MediaRequest $request)
    {
        $file = $request->file('file');
        
        // We attach standalone media to a new MediaAsset model instance
        $asset = MediaAsset::create([
            'uploaded_by' => auth()->id()
        ]);

        $media = $asset->addMedia($file)
            ->usingName(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            ->usingFileName(Str::random(10) . '.' . $file->getClientOriginalExtension())
            ->toMediaCollection('default');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'media' => $media,
                'url' => $media->getUrl()
            ]);
        }

        return back()->with('success', 'Media uploaded successfully.');
    }

    public function update(MediaRequest $request, Media $medium)
    {
        $medium->name = $request->name;
        
        $customProperties = $medium->custom_properties;
        $customProperties['alt'] = $request->input('custom_properties.alt');
        $customProperties['caption'] = $request->input('custom_properties.caption');
        $customProperties['description'] = $request->input('custom_properties.description');
        
        $medium->custom_properties = $customProperties;
        $medium->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'media' => $medium
            ]);
        }

        return back()->with('success', 'Media updated successfully.');
    }

    public function destroy(Media $medium)
    {
        $medium->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Media deleted successfully.');
    }
}
