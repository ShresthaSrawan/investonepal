<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BodPost;
use App\Http\Requests\BODPostFormRequest;

class BodPostController extends Controller
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $bodPost = BodPost::all();

        return view('admin.bodPost.all')
            ->with('bodPosts', $bodPost);
    }

    public function store(BODPostFormRequest $request)
    {
        $input = $request->all();
        if($input['type']=="1"){
            $type = 1;
        }elseif($input['type']=="0"){
            $type = 0;
        }else{
            return redirect()->back()->with('danger', 'Invalid Bod Type');
        }

        $bod = new BodPost();
        $bod->label = $input['label'];
        $bod->type = $type;
        $bod->save();

        return redirect()->back()
            ->with('success', 'BOD post has been successfully created');
    }

    public function update(BODPostFormRequest $request,$id)
    {
        $input = $request->all();
        if($input['type']=="1"){
            $type = 1;
        }elseif($input['type']=="0"){
            $type = 0;
        }else{
            return redirect()->back()->with('danger', 'Invalid Bod Type');
        }
        $bod_post = BodPost::find($id);
        $bod_post->label = $input['label'];
        $bod_post->type = $type;
        $bod_post->save();

        return redirect()->back()
            ->with('success', 'BOD post has been successfully updated');
    }

    public function destroy($id)
    {
        $bodPost = BodPost::where('id',$id)
                            ->first();

        if(is_null($bodPost)){
            return redirect()->back()->with('danger','Invalid Request');
        }

        $bodPost->delete();

        return redirect()->back()
            ->with('success', 'BOD post has been successfully deleted');
    }
}
