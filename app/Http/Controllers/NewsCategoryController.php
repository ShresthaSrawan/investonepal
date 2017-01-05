<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use App\Http\Requests\NewsCategoryFormRequest;

class NewsCategoryController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            $newsCategory = NewsCategory::all();
            return view('admin.newsCategory.all')
                ->with('newsCategory', $newsCategory);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(NewsCategoryFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','news')):
            $input = $request->all();
            $newsCategory = new NewsCategory();
            $newsCategory->label = $input['label'];
            $newsCategory->save();

            return redirect()->route('admin.newsCategory.index')
            ->with('success', 'New category has been created successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(NewsCategoryFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','news')):
            $input = $request->all();
            $category = NewsCategory::find($id);
            $category->label = $input['label'];
            $category->save();
            
            return redirect()->route('admin.newsCategory.index')
            ->with('success','News category has been updated successfully.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','news')):
            $newscategory = NewsCategory::find($id);

            if(is_null($newscategory)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            if($newscategory->countNews() == 0):
                $newscategory->delete();
            else:
                return redirect()->back()->with('warning','Invalid request. Delete related news items before deleting this category.');
            endif;

            return redirect()->route('admin.newsCategory.index')
            ->with('success','Selected category have been deleted successfully.');
        else:
            return redirect()->route('403');
        endif;
    }
}
