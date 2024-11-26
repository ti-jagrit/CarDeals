<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    // In PhotoController.php
    public function destroy(Photo $photo)
    {
        Storage::delete('public/' . $photo->path);
        $photo->delete();
        return redirect()->back()->with('success', 'Photo deleted successfully');
    }

}
