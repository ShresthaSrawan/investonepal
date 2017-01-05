<?php

namespace App\Http\Controllers;

use DB;
use App\Models\AGM;
use App\Models\AgmFiscal;
use App\Models\Announcement;
use App\Models\AnnouncementSubType;
use App\Models\AnnouncementType;
use App\Models\Auction;
use App\Models\BondDebenture;
use App\Models\BonusDividendDistribution;
use App\Models\Company;
use App\Models\Event;
use App\Models\FinancialHighlight;
use App\Models\FiscalYear;
use App\Models\IMIssue;
use App\Models\Issue;
use App\Models\IssueManager;
use App\Models\Quarter;
use App\Models\TreasuryBill;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AnnouncementFormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            return view('admin.announcement.all');
        else:
            return redirect()->route('403');
        endif;
    }

    public function create()
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','news')):
            $anonTypes = AnnouncementType::lists('label','id');
            $company = Company::orderBy('name','asc')->lists('name','id')->toArray();
            $fiscalYear = FiscalYear::orderBy('id','desc')->lists('label','id')->toArray();
            $issueManager = IssueManager::lists('company','id')->toArray();
            $quarter = Quarter::lists('label','id')->toArray();
            return view('admin.announcement.create')
                ->with('anonTypes',$anonTypes)
                ->with('company',$company)
                ->with('issueManager',$issueManager)
                ->with('quarter',$quarter)
                ->with('fiscalYear',$fiscalYear);
        else:
            return redirect()->route('403');
        endif;
    }

    public function store(AnnouncementFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','news')):
            DB::beginTransaction();
            try{
                $announcement = new Announcement();
                $announcement->user_id = Auth::id();
                $announcement->setAttributes($request);
                if($request->hasFile('featured_image')){
                    $announcement->uploadImage($request);
                }
                $announcement->save();

                if($request->has('agm')){
                    $agm = new AGM();
                    $agm->setAttributes($request,$announcement->id);
                    $agm->save();

                    foreach($request->get('agm_fiscalYear')['fiscal_year_id'] as $afy){
                        $values = ['agm_id'=>$agm->id,'fiscal_year_id'=>$afy];
                        AgmFiscal::create($values);
                    }

                }elseif($request->has('bondDebenture')){
                    $bd = new BondDebenture();
                    $bd->setAttributes($request,$announcement->id);
                    $bd->save();

                }elseif($request->has('bonusDividend')){
                    $bonusDividend = new BonusDividendDistribution();
                    $bonusDividend->setAttributes($request,$announcement->id);
                    $bonusDividend->save();

                }elseif($request->has('treasuryBill')){
                    $treasuryBill = new TreasuryBill();
                    $treasuryBill->setAttributes($request,$announcement->id);
                    $treasuryBill->save();

                }elseif($request->has('financialHighlight')){
                    $financialHighlight = new FinancialHighlight();
                    $financialHighlight->setAttributes($request,$announcement->id);
                    $financialHighlight->save();

                }elseif($request->has('bodApproved')){
                    $bodApproved = new BonusDividendDistribution();
                    $bodApproved->setAttributes($request,$announcement->id);
                    $bodApproved->is_bod_approved = BonusDividendDistribution::BOD_APPROVED;
                    $bodApproved->save();
                }elseif($request->has('issue')){
                    $i = new Issue();
                    $i->setAttributes($request,$announcement->id);
                    $i->save();

                    if($request->has('issue_manager')){
                        foreach($request->get('issue_manager')['im_id'] as $im){
                            $values = ['im_id'=>$im,'issue_id'=>$i->id];
                            IMIssue::create($values);
                        }
                    }

                    if($request->has('auction')){
                        $a = new Auction();
                        $a->setAttributes($request,$i->id);
                        $a->save();
                    }
                }
            }catch (\Exception $e){
                DB::rollback();
                return redirect()->route('admin.announcement.create')->with('danger', $e->getMessage());
            }
            DB::commit();

            return redirect()->route('admin.announcement.show',$announcement->id)->with('message','New Announcement has been created.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function show($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('read','news')):
            $announcement = Announcement::with('issue.fiscalYear','issue.auction','agm','bodApproved','bonusDividend','bondDebenture','treasuryBill','financialHighlight.fiscalYear')->find($id);

            if(is_null($announcement)) return redirect()->route('admin.announcement.index')->with('danger','Invalid Request');

            return view('admin.announcement.show')->with('announcement',$announcement);
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','news')):
            $announcement = Announcement::with('agm')->with('bonusDividend')->with('bodApproved')
                ->with('bondDebenture')->with('treasuryBill')->with('financialHighlight')->find($id);
            if(is_null($announcement)){
                return redirect()->route('admin.announcement.show')->with('errorMessage','Announcement not found');
            }


            $anonTypes = AnnouncementType::lists('label','id');
            $company = Company::lists('name','id')->toArray();
            $fiscalYear = FiscalYear::orderBy('id','desc')->lists('label','id')->toArray();
            $issueManager = IssueManager::lists('name','id')->toArray();
            $quarter = Quarter::lists('label','id')->toArray();

            return view('admin.announcement.edit')
                ->with('anonTypes',$anonTypes)
                ->with('company',$company)
                ->with('issueManager',$issueManager)
                ->with('announcement',$announcement)
                ->with('quarter',$quarter)
                ->with('fiscalYear',$fiscalYear);
        else:
            return redirect()->route('403');
        endif;
    }

    public function update($id, AnnouncementFormRequest $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','news')):
            DB::beginTransaction();
            try{
                $announcement = Announcement::find($id);
                if(is_null($announcement)){
                    return redirect()->route('admin.announcement.index')
                        ->with('errorMessage','Announcement not found.');
                }

                $announcement->setAttributes($request);
                if($request->hasFile('featured_image')){
                    $announcement->removeImage()->uploadImage($request);
                }

                $announcement->save();

                if(!is_null($announcement->issue)){
                    $announcement->issue->delete();
                }elseif(!is_null($announcement->bonusDividend)){
                    $announcement->bonusDividend->delete();
                }elseif(!is_null($announcement->bodApproved)){
                    $announcement->bodApproved->delete();
                }elseif(!is_null($announcement->bondDebenture)){
                    $announcement->bondDebenture->delete();
                }elseif(!is_null($announcement->treasuryBill)){
                    $announcement->treasuryBill->delete();
                }elseif(!is_null($announcement->financialHighlight)){
                    $announcement->financialHighlight->delete();
                }elseif(!is_null($announcement->agm)){
                    $announcement->agm->delete();
                }


                if($request->has('agm')){
                    $agm = new AGM();
                    $agm->setAttributes($request,$announcement->id);
                    $agm->save();

                    foreach($request->get('agm_fiscalYear')['fiscal_year_id'] as $afy){
                        $values = ['agm_id'=>$agm->id,'fiscal_year_id'=>$afy];
                        AgmFiscal::create($values);
                    }

                }elseif($request->has('bondDebenture')){
                    $bd = new BondDebenture();
                    $bd->setAttributes($request,$announcement->id);
                    $bd->save();

                }elseif($request->has('bonusDividend')){
                    $bonusDividend = new BonusDividendDistribution();
                    $bonusDividend->setAttributes($request,$announcement->id);
                    $bonusDividend->save();

                }elseif($request->has('treasuryBill')){
                    $treasuryBill = new TreasuryBill();
                    $treasuryBill->setAttributes($request,$announcement->id);
                    $treasuryBill->save();

                }elseif($request->has('financialHighlight')){
                    $financialHighlight = new FinancialHighlight();
                    $financialHighlight->setAttributes($request,$announcement->id);
                    $financialHighlight->save();

                }elseif($request->has('bodApproved')){
                    $bodApproved = new BonusDividendDistribution();
                    $bodApproved->setAttributes($request,$announcement->id);
                    $bodApproved->is_bod_approved = BonusDividendDistribution::BOD_APPROVED;
                    $bodApproved->save();

                }elseif($request->has('issue')){
                    $i = new Issue();
                    $i->setAttributes($request,$announcement->id);
                    $i->save();

                    if($request->has('issue_manager')){
                        foreach($request->get('issue_manager')['im_id'] as $im){
                            $values = ['im_id'=>$im,'issue_id'=>$i->id];
                            IMIssue::create($values);
                        }
                    }

                    if($request->has('auction')){
                        $a = new Auction();
                        $a->setAttributes($request,$i->id);
                        $a->save();
                    }
                }
            }catch (\Exception $e){
                DB::rollback();
                return redirect()->route('admin.announcement.index')->with('warning','Announcement could not be updated.');
            }
            DB::commit();
            return redirect()->route('admin.announcement.show',$announcement->id)->with('success','Announcement has been updated.');
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($id)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','news')):
            $announcements = Announcement::find($id);
            if(is_null($announcements)){
                return redirect()->route('admin.announcement.index')->with('warning','Invalid announcement deletion request!');
            }
            $announcements->delete();

            return redirect()->route('admin.announcement.index')->with('success','Announcements have been deleted.');
        else:
            return redirect()->route('403');
        endif;
    }
}
