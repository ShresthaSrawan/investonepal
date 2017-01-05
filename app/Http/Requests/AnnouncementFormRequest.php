<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class AnnouncementFormRequest extends Request
{
    public function authorize()
    {
        if( ! Auth::check() ){
            return false;
        }
        return true;
    }

    public function rules()
    {
        $rules = [
            'type' => 'required|exists:announcement_type,id'
            ,'subtype' => ''
            ,'company' => 'exists:company,id'
            ,'event_date' => 'date'
            ,'pub_date' => 'required|date'
            ,'source' => 'alpha_spaces'
            ,'title' => 'required'
            ,'details' => 'required'
            ,'featured_image' => 'required|mimes:jpeg,jpg,png,gif|max_file_size:3072'
        ];
        if($this->isMethod('put')){
            $rules['featured_image'] = 'mimes:jpeg,jpg,png,gif|max_file_size:3072';
        }

        if($this->get('company') == 0 || $this->get('company') == '' || $this->get('company') == null){
            $rules['company'] = '';
        }

        $addedRule = [];

        if($this->has('agm')){
            $rules['event_date'] = 'required|date';
            $rules['company'] = 'required|exists:company,id';
            $addedRule = [
                'agm.count' => 'required|alpha_num_spaces',
                'agm_fiscalYear.fiscal_year_id' => 'required|exists:fiscal_year,id',
                'agm.venue' => 'address',
                'agm.book_closer_from' => 'date',
                'agm.book_closer_to' => 'date',
                'agm.agenda' => '',
            ];
        }elseif($this->has('bondDebenture')){

            $addedRule = [
                'bondDebenture.title_of_securities' => 'required|alpha_num_spaces_percent',
                'bondDebenture.fiscal_year_id' => 'required|exists:fiscal_year,id',
                'bondDebenture.face_value' => 'numeric',
                'bondDebenture.kitta' => 'numeric',
                'bondDebenture.maturity_period' => 'numeric',
                'bondDebenture.issue_open_date' => 'required|date',
                'bondDebenture.issue_close_date' => 'required|date',
                'bondDebenture.coupon_interest_rate' => 'required|numeric',
                'bondDebenture.interest_payment_method' => 'alpha_num_spaces',
            ];

        }elseif($this->has('bonusDividend')){
            $rules['company'] = 'required|exists:company,id';
            $addedRule = [
                'bonusDividend.fiscal_year_id' => 'required|exists:fiscal_year,id',
                'bonusDividend.bonus_share' => 'required_without:bonusDividend.cash_dividend',
                'bonusDividend.cash_dividend' => 'required_without:bonusDividend.bonus_share',
                'bonusDividend.distribution_date' => 'date'
            ];

        }elseif($this->has('bodApproved')){
            $rules['company'] = 'required|exists:company,id';
            $rules['featured_image'] = 'mimes:jpeg,jpg,png,gif|max_file_size:3072';
            $addedRule = [
                'bodApproved.fiscal_year_id' => 'required|exists:fiscal_year,id',
                'bodApproved.bonus_share' => 'required_without:bodApproved.cash_dividend',
                'bodApproved.cash_dividend' => 'required_without:bodApproved.bonus_share',
                'bodApproved.distribution_date' => 'date'
            ];
        }elseif($this->has('treasuryBill')){
            $rules['company'] = 'required|exists:company,id';
            $addedRule = [
                'treasuryBill.fiscal_year_id' => 'required|exists:fiscal_year,id',
                'treasuryBill.serial_number' => 'alpha_num_spaces',
                'treasuryBill.highest_discount_rate' => 'numeric',
                'treasuryBill.lowest_discount_rate' => 'numeric',
                'treasuryBill.bill_days' => 'required|numeric',
                'treasuryBill.issue_open_date' => 'date',
                'treasuryBill.issue_close_date' => 'date',
                'treasuryBill.weighted_average_rate' => 'numeric',
                'treasuryBill.slr_rate' => 'numeric',
                'treasuryBill.issue_amount' => 'numeric',
            ];

        }elseif($this->has('financialHighlight')){
            $rules['company'] = 'required|exists:company,id';
            $addedRule = [
                'financialHighlight_fiscalYear.fiscal_year_id' => 'required|exists:fiscal_year,id',
                'financialHighlight.paid_up_capital' => 'numeric',
                'financialHighlight.reserve_and_surplus' => 'numeric',
                'financialHighlight.earning_per_share' => 'numeric',
                'financialHighlight.net_worth_per_share' => 'numeric',
                'financialHighlight.book_value_per_share' => 'numeric',
                'financialHighlight.net_profit' => 'numeric',
                'financialHighlight.operating_profit' => 'numeric',
                'financialHighlight.bonus' => 'numeric',
                'financialHighlight.dividend' => 'numeric',
                'financialHighlight.time' => 'date_format:H:i',
            ];
        }elseif($this->has('issue')){
            $rules['company'] = 'required|exists:company,id';
            $addedRule = [
                'issue_manager.im_id' => 'required|exists:issue_manager,id',
                'issue.fiscal_year_id' => 'required|exists:fiscal_year,id',
                'issue.face_value' => 'numeric',
                'issue.issue_date' => 'date',
                'issue.close_date' => 'date',
                'issue.kitta' => 'numeric',
                //'issue.operating_profit' => 'numeric',
            ];
            if($this->has('auction')){
                unset($addedRule['issue.ratio']);
                unset($addedRule['issue.kitta']);
                unset($addedRule['issue.operating_profit']);

                if(array_key_exists('promoter',$this->get('auction'))){
                    $rules['event_date'] = 'required|date';
                    $addedRule['auction.promoter'] = 'required|numeric';
                }

                if(array_key_exists('ordinary',$this->get('auction'))){
                    $rules['event_date'] = 'required|date';
                    $addedRule['auction.ordinary'] = 'required|numeric';
                }
            }
        }

        return array_merge($rules,$addedRule);
    }

    public function messages()
    {
        return [
            /*
             * Issue
             */
            'issue_manager.im_id.required'  => 'The issue manager field is required.',
            'issue.fiscal_year_id.required'  => 'The fiscal year field is required.',
            'issue_manager.im_id.exists'  => 'The selected issue manager is invalid.',
            'issue.fiscal_year_id.exists'  => 'The selected fiscal year is invalid.',
            'issue.face_value.numeric'  => 'The face value must be a number.',
            'issue.kitta.numeric'  => 'The kitta must be a number.',
            'issue.operating_profit.numeric'  => 'The operating profit must be a number.',
            'issue.issue_date.date'  => 'The issue date is not a valid date.',
            'issue.close_date.date'  => 'The close date is not a valid date.',
            'auction.promoter.required'  => 'The promoter field is required.',
            'auction.promoter.numeric'  => 'The promoter must be a number.',
            'auction.ordinary.required'  => 'The ordinary field is required.',
            'auction.ordinary.numeric'  => 'The ordinary must be a number.',

            /*
             * AGM
             */

            'agm.count.required' => 'The count field is required.',
            'agm.count.alpha_num_spaces' => 'The count may only contain letters, numbers and spaces.',
            'agm_fiscalYear.fiscal_year_id.required' => 'The fiscal year field is required.',
            'agm_fiscalYear.fiscal_year_id.exists' => 'The selected fiscal year is invalid.',
            'agm.venue.address' => 'The venue may only contain letters, numbers, ",","-" and spaces.',
            'agm.book_closer_from.date' => 'The book closer from is not a valid date.',
            'agm.book_closer_to.date' => 'The book closer to is not a valid date.',


            /*
             * Bonus Dividend
             * */

            'bondDebenture.title_of_securities.required' => 'The title of securities field is required.',
            'bondDebenture.title_of_securities.alpha_num_spaces_percent' => 'The title of securities may only contain letters, numbers, spaces and "%".',
            'bondDebenture.fiscal_year_id.required' => 'The fiscal year field is required.',
            'bondDebenture.fiscal_year_id.exists' => 'The selected fiscal year is invalid.',
            'bondDebenture.face_value.numeric' => 'The face value must be a number.',
            'bondDebenture.kitta.numeric' => 'The kitta must be a number.',
            'bondDebenture.maturity_period.numeric' => 'The maturity period must be a number.',
            'bondDebenture.issue_open_date.date' => 'The issue open date is not a valid date.',
            'bondDebenture.issue_close_date.date' => 'The issue close date is not a valid date.',
            'bondDebenture.coupon_interest_rate.required' => 'The coupon interest rate of securities field is required.',
            'bondDebenture.coupon_interest_rate.numeric' => 'The title of securities field is required.',
            'bondDebenture.interest_payment_method.alpha_num_spaces' => 'The interest payment method must be a number.',


            /*
             * Treasury Bill
             * */
            'treasuryBill.fiscal_year_id.required' => 'The fiscal year field is required.',
            'treasuryBill.fiscal_year_id.exists' => 'The selected fiscal year is invalid.',
            'treasuryBill.serial_number.alpha_num_spaces' => 'The interest payment method must be a number.',
            'treasuryBill.highest_discount_rate.numeric' => 'The highest discount rate must be a number.',
            'treasuryBill.lowest_discount_rate.numeric' => 'The lowest discount rate must be a number.',
            'treasuryBill.bill_days.required' => 'The bill days field is required.',
            'treasuryBill.bill_days.numeric' => 'The bill days must be a number.',
            'treasuryBill.issue_open_date.date' => 'The issue open date is not a valid date.',
            'treasuryBill.issue_close_date.date' => 'The issue close date is not a valid date.',
            'treasuryBill.weighted_average_rate.numeric' => 'The weighted average rate must be a number.',
            'treasuryBill.slr_rate.numeric' => 'The slr rate must be a number.',
            'treasuryBill.issue_amount.numeric' => 'The issue amount must be a number.',

            /*
             * Bonus Dividend.
             * */

            'bonusDividend.fiscal_year_id.required' => 'The fiscal year field is required.',
            'bonusDividend.fiscal_year_id.exists' => 'The selected fiscal year is invalid.',
            'bonusDividend.cash_dividend.numeric' => 'The cash dividend must be a number.',
            'bonusDividend.cash_dividend.required_without' => 'The bonus bonus cash dividend is required when bonus share field is not present.',
            'bonusDividend.bonus_share.numeric' => 'The bonus share must be a number.',
            'bonusDividend.bonus_share.required_without' => 'The bonus bonus share field is required when bonus cash dividend is not present.',
            'bonusDividend.distribution_date.required' => 'The distribution date field is required.',
            'bonusDividend.distribution_date.date' => 'The distribution date is not a valid date.',

             /*
             *   BOD Approved.
             *
              * */

            'bodApproved.fiscal_year_id.required' => 'The fiscal year field is required.',
            'bodApproved.fiscal_year_id.exists' => 'The selected fiscal year is invalid.',
            'bodApproved.cash_dividend.numeric' => 'The cash dividend must be a number.',
            'bodApproved.cash_dividend.required_without' => 'The bonus bonus cash dividend is required when bonus share field is not present.',
            'bodApproved.bonus_share.numeric' => 'The bonus share must be a number.',
            'bodApproved.bonus_share.required_without' => 'The bonus bonus share field is required when bonus cash dividend is not present.',
            'bodApproved.distribution_date.required' => 'The distribution date field is required.',
            'bodApproved.distribution_date.date' => 'The distribution date is not a valid date.',


            /*
             * Financial Highlight
             * */

            'financialHighlight_fiscalYear.fiscal_year_id.required' => 'The fiscal year field is required.',
            'financialHighlight_quarter.quarter_id.required' => 'The quarter field is required.',
            'financialHighlight.paid_up_capital.required' => 'The paid up capital field is required.',
            'financialHighlight.earning_per_share.required' => 'The earning per share field is required.',
            'financialHighlight_fiscalYear.fiscal_year_id.exixts' => 'The selected fiscal year is invalid.',
            'financialHighlight_quarter.quarter_id.exists' => 'The selected quarter is invalid.',
            'financialHighlight.paid_up_capital.numeric' => 'The paid up capital must be a number.',
            'financialHighlight.reserve_and_surplus.numeric' => 'The reserve and surplus must be a number.',
            'financialHighlight.earning_per_share.numeric' => 'The earning per share must be a number.',
            'financialHighlight.net_worth_per_share.numeric' => 'The net worth per share must be a number.',
            'financialHighlight.book_value_per_share.numeric' => 'The book value per share must be a number.',
            'financialHighlight.net_profit.numeric' => 'The net profit must be a number.',
            'financialHighlight.operating_profit.numeric' => 'The operating profit must be a number.',

        ];
    }
}
