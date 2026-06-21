<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MediaLibraryController extends Controller
{
    /**
     * Display a listing of the media files.
     */
    public function index()
    {
        $media = MediaLibrary::orderBy('created_at', 'desc')->paginate(24);
        return view('admin.media', compact('media'));
    }

    /**
     * Get list of media files in JSON format for the modal picker.
     */
    public function apiIndex(Request $request)
    {
        $query = MediaLibrary::orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where('file_name', 'like', '%' . $request->search . '%');
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created media file in storage and database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240', // 10MB Max
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Clean filename to prevent special characters issues
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanName = Str::slug($originalName);
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . $cleanName . '.' . $extension;

            // Ensure destination directory exists in public/uploads/media
            $destinationPath = public_path('uploads/media');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            // Move the file
            $file->move($destinationPath, $fileName);
            $fullFilePath = $destinationPath . '/' . $fileName;

            // Create record
            $media = MediaLibrary::create([
                'file_name' => $fileName,
                'file_path' => 'uploads/media/' . $fileName,
                'file_size' => File::exists($fullFilePath) ? File::size($fullFilePath) : 0,
                'file_type' => File::exists($fullFilePath) ? File::mimeType($fullFilePath) : $file->getClientMimeType(),
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'media' => $media,
                ]);
            }

            return back()->with('success', 'File uploaded successfully!');
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'No file uploaded.'
            ], 400);
        }

        return back()->with('error', 'No file was uploaded.');
    }

    /**
     * Remove the specified media file from storage and database.
     */
    public function destroy($id)
    {
        $media = MediaLibrary::findOrFail($id);

        // Delete physical file
        $filePath = public_path($media->file_path);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $media->delete();

        return back()->with('success', 'File deleted successfully!');
    }

    /**
     * Remove multiple media files from storage and database.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer',
        ]);

        $ids = $request->input('ids');
        $deletedCount = 0;

        foreach ($ids as $id) {
            $media = MediaLibrary::find($id);
            if ($media) {
                $filePath = public_path($media->file_path);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
                $media->delete();
                $deletedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => $deletedCount . ' files deleted successfully!',
        ]);
    }
}
