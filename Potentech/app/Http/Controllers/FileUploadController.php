<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048', // Adjust max size as needed
        ]);

        $user = Auth::user();
        $folderName = str_replace(' ', '_', $user->name); // Replace spaces with underscores for folder name
        $file = $request->file('file');

        // Create the folder if it doesn't exist and store the file
        $path = $file->storeAs("uploads/{$folderName}", $file->getClientOriginalName(), 'public');

        return response()->json(['path' => $path], 201);
    }

    public function getFiles()
    {
        $user = Auth::user();
        $folderName = str_replace(' ', '_', $user->name);
        $files = Storage::disk('public')->files("uploads/{$folderName}");

        return response()->json($files);
    }
}