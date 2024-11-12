<?php

// app/Http/Controllers/FileController.php
namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048',
        ]);

        $path = $request->file('file')->store('uploads');
        $file = new File();
        $file->filename = $request->file('file')->getClientOriginalName();
        $file->path = $path;
        $file->user_id = Auth::id();
        $file->save();

        return response()->json(['success' => 'File uploaded successfully.']);
    }

    public function index()
    {
        if (Auth::user()->role_id !== 2) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $files = File::all();
        return response()->json($files);
    }

    public function download($id)
    {
        $file = File::findOrFail($id);
        return Storage::download($file->path);
    }
}

