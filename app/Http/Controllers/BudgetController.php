<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\BudgetSource;
use App\Models\BudgetLabel;
use App\Models\BudgetSubLabel;
use App\Models\BudgetSubValue;
use App\Models\BudgetFiscalYear;
use Illuminate\Http\Response;
use Mockery\CountValidator\Exception;

class BudgetController extends Controller
{
    public function index()
    {
    }

    public function create($id, $type)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $fiscalYear = BudgetFiscalYear::find($id);
            if(is_null($fiscalYear)){
                return redirect()->route('admin.budgetFiscalYear.index')->with('errorMessage','Fiscal year not found!');
            }
            if($fiscalYear->hasType($type) ){
                return redirect()->route('admin.budgetFiscalYear.show',$id)->with('errorMessage','Budget has already been created!');
            }

            $budgetLabel = BudgetLabel::where('type',$type)->lists('label','id')->toArray();
            if($type == 0){
                $view = view('admin.budget.createSource');
            }
            else{
                $view = view('admin.budget.createExpense');
            }
            return $view->with(compact(['fiscalYear','budgetLabel','type']));
        else:
            return redirect()->route('403');
        endif;
    }

    public function store($fid, $type, Request $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('create','data')):
            $message = ($type == 0) ? 'Budget Source has been created.' : 'Budget Expense has been created.';
            $errorMessage = ($type == 0) ? 'Budget Source could not be created.' : 'Budget Expense could not be created.';
            $type = 'success';
            try{
                \DB::beginTransaction();
                if($request->has('value')){
                    foreach($request->get('value') as $id => $sub_label_values){
                        $val = ['fiscal_year_id'=>$fid,'label_id'=>$id,'value'=>array_sum($sub_label_values)];
                        $budget = Budget::create($val);
                        foreach($sub_label_values as $sid=>$sub_value){
                            $subVal = ['budget_id'=>$budget->id,'sub_label_id'=>$sid,'value'=>$sub_value];
                            if(!BudgetSubValue::create($subVal)):
                                \DB::rollback();
                                throw new \Exception($errorMessage);
                            endif;
                        }
                    }
                }

                if($request->has('budgetTotal')){
                    foreach($request->get('budgetTotal') as $id => $budgetValue){
                        $val = ['fiscal_year_id'=>$fid,'label_id'=>$id,'value'=>$budgetValue];
                        if(!Budget::create($val)):
                            \DB::rollback();
                            throw new \Exception($errorMessage);
                        endif;
                    }
                }

                \DB::commit();
            }catch(\Exception $e){
                $message = $e->getMessage();
                $type = 'danger';
            }

            return redirect()->route('admin.budgetFiscalYear.show',$fid)->with($type,$message);
        else:
            return redirect()->route('403');
        endif;
    }

    public function edit($fid,Request $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $fiscalYear = BudgetFiscalYear::with('budget.subValue.subLabel')->with('budget.budgetLabel')->find($fid);
            $type = $request->get('type');
            if(is_null($fiscalYear))
                return redirect()->route('admin.budgetFiscalYear.index')->with('danger','Fiscal Year not found!');
            switch($type = $request->get('type')){
                case 0:
                    $view = view('admin.budget.editSource');
                    break;
                case 1:
                    $view = view('admin.budget.editExpense');
                    break;
                default:
                    return redirect()->route('admin.budgetFiscalYear.show',$fid)->with('danger','Invalid type given!');
            }
            $budgetLabel = BudgetLabel::where('type',$type)->lists('label','id')->toArray();
            return $view->with(compact(['fiscalYear','budgetLabel','type']));
        else:
            return redirect()->route('403');
        endif;
    }

    public function update($fid,$type, Request $request)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('update','data')):
            $fiscalYear = BudgetFiscalYear::with('budget.budgetLabel.subLabel')->with('budget.subValue.subLabel')
                ->find($fid);

            if(is_null($fiscalYear) && $fiscalYear->budget->isEmpty()){
                return redirect()->route('admin.budgetFiscalYear.index')->with('errorMessage','Invalid Request!');
            }
			
            $postBudgetIds = array_merge(array_keys($request->has('value') ? $request->get('value') : []),array_keys($request->has('budgetTotal') ? $request->get('budgetTotal') : []));

            foreach($fiscalYear->budget as $budget):
                if($budget->getType() == $type && !in_array($budget->id,$postBudgetIds)):
                    $budget->delete();
                endif;
            endforeach;

            if($request->has('value')):
                $budgetValues = $request->get('value');
                foreach($budgetValues as $id=>$subLabelValues):
                    $budget = Budget::find($id);
                    if(!is_null($budget)):
                        $budget->value = array_sum($subLabelValues);
                        $budget->save();
                        foreach($budget->subValue as $subValue):
                            $subValue->delete();
                        endforeach;
                    else:
                        $prop = ['fiscal_year_id'=>$fid,'label_id'=>$id,'value'=>array_sum($subLabelValues)];
                        $budget = Budget::create($prop);
                    endif;

                    foreach($subLabelValues as $sid=>$total):
                        $prop = ['budget_id'=>$budget->id,'sub_label_id'=>$sid,'value'=>$total];
                        BudgetSubValue::create($prop);
                    endforeach;
                endforeach;
            endif;


            if($request->has('budgetTotal')):
                $budgetValues = $request->get('budgetTotal');
                foreach($budgetValues as $id=>$total):
                    $budget = Budget::find($id);
                    if(!is_null($budget)):
                        $budget->value = $total;
                        $budget->save();
                    else:
                        $prop = ['fiscal_year_id'=>$fid,'label_id'=>$id,'value'=>$total];
                        $budget = Budget::create($prop);
                    endif;
                endforeach;
            endif;

            $message = ($type == 0) ? 'Budget Source has been updated.' : 'Budget Expense has been updated.';

            return redirect()->route('admin.budgetFiscalYear.show',$fid)->with('success',$message);
        else:
            return redirect()->route('403');
        endif;
    }

    public function destroy($fid,$budget)
    {
        if(Auth::check() && Auth::user()->hasRightsTo('delete','data')):
            $budget = Budget::where('id',$budget)->where('fiscal_year_id',$fid)->first();

            if(!is_null($budget)):
                $budget->delete();
                return redirect()->back()->with('success','Budget has been successfully removed.');
            else:
                return redirect()->back()->with('danger','Invalid budget deletion request!');
            endif;
        else:
            return redirect()->route('403');
        endif;
    }
}
