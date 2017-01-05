<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\IssueManagerFormRequest;
use App\Models\Company;
use App\Models\IssueManager;
use App\Models\CompanyIssueManager;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IssueManagerController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','data')):
            $issueManager = IssueManager::all();
            return view('admin.issueManager.index')->with('issueManagers', $issueManager);
        else:
            return redirect()->route('403');
        endif;
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            return view('admin.issueManager.create');
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(IssueManagerFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $input = $request->all();
            $iManager = new IssueManager();
            $iManager->name = $input['name'];
            $iManager->address = $input['address'];
            $iManager->phone = $input['phone'];
            $iManager->email = $input['email'];
            $iManager->web = $input['web'];
            $iManager->company = $input['company'];
            $iManager->save();

            $issueManager = IssueManager::all();
            return redirect()->route('admin.issueManager.index')->with('issueManagers', $issueManager)
                ->with('success',"Issue manager {$input['name']} has been created.");
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $issueManager = IssueManager::find($id);
            return view('admin.issueManager.edit')->with('issueManager',$issueManager);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update(IssueManagerFormRequest $request, $id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $input = $this->request->all();
            $iManager = IssueManager::find($id);
            $iManager->name = $input['name'];
            $iManager->address = $input['address'];
            $iManager->phone = $input['phone'];
            $iManager->email = $input['email'];
            $iManager->web = $input['web'];
            $iManager->company = $input['company'];
            $iManager->save();

            $issueManager = IssueManager::all();
            return redirect()->route('admin.issueManager.index')->with('issueManagers', $issueManager)
                ->with('success',"Issue manager has been updated.");
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $iManager = IssueManager::find($id);

            if(is_null($iManager)){
                return redirect()->back()->with('danger','Invalid Request');
            }

            if($iManager->countIssue() == 0 && $iManager->countCompany() == 0):
                $iManager->delete();
            else:
                return redirect()->back()->with('warning','Invalid request. Delete related announcement and company before deleting this item.');
            endif;        

            return redirect()->route('admin.issueManager.index')
                ->with('success',"Issue manager have been removed.");
        else:
            return redirect()->route('403');
        endif;
    }
}
