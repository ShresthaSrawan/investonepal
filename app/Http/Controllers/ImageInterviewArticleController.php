<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ImageInterviewArticle;

class ImageInterviewArticleController extends Controller
{
    public function destroy(Request $request, $id)
    {
        $fi = ImageInterviewArticle::find($id);
        $fi->removeImage();
        $fi->delete();

        return redirect()->back()->with('success', 'Image has been removed successfully .');

    }
}
