<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Controller untuk upload gambar dari rich text editor
 */
class UploadController extends Controller
{
    /**
     * Handle image upload from Summernote editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048'
        ]);

        try {
            $file = $request->file('image');
            
            // Generate unique filename
            $filename = 'editor_' . date('Ymd_His') . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            
            // Store in public/uploads/editor folder
            $path = $file->storeAs('uploads/editor', $filename, 'public');
            
            // Return success response
            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $path),
                'filename' => $filename
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload gambar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete uploaded image (optional cleanup)
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'url' => 'required|string'
        ]);

        try {
            // Extract filename from URL
            $url = $request->input('url');
            $path = str_replace(asset('storage/'), '', $url);
            
            // Only delete if it's in the editor uploads folder
            if (str_starts_with($path, 'uploads/editor/')) {
                Storage::disk('public')->delete($path);
            }
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus gambar'
            ], 500);
        }
    }
}
