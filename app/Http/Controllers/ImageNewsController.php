<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ImageNews;

class ImageNewsController extends Controller
{
    public function destroy($id)
    {
        $fi = ImageNews::find($id);
        $fi->removeImage();
        $fi->delete();

        return redirect()->back()->with('success', 'News image has been successfully removed.');
    }
}
