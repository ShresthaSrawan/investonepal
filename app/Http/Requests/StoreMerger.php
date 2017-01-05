<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class StoreMerger extends Request
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'companies'  => 'required',
            'trading' => 'required',
            'type'  => 'required',
            'status' => 'required'
        ];
    }

    public function data()
    {
        $data = [
            'company_id' => $this->get('company_id'),
            'companies' => $this->get('companies'),
            'remarks' => empty($this->get('remarks')) ? null : $this->get('remarks'),
            'loi_date' => empty($this->get('loi_date')) ? null : $this->get('loi_date'),
            'deadline_date' => empty($this->get('deadline_date')) ? null : $this->get('deadline_date'),
            'mou_date' => empty($this->get('mou_date')) ? null : $this->get('mou_date'),
            'application_date' => empty($this->get('application_date')) ? null : $this->get('application_date'),
            'approved_date' => empty($this->get('approved_date')) ? null : $this->get('approved_date'),
            'join_transaction_date' => empty($this->get('join_transaction_date')) ? null : $this->get('join_transaction_date'),
            'swap_ratio' => empty($this->get('swap_ratio')) ? null : $this->get('swap_ratio'),
            'trading' => $this->get('trading'),
            'type' => $this->get('type'),
            'status' => $this->get('status'),
        ];

        return $data;
    }
}
