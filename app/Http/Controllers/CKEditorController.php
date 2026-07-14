<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|max:5120'
        ]);

        $path = $request->file('upload')->store('ckeditor', 'public');

        return response()->json([
            'url' => Storage::url($path)
        ]);
    }
}
