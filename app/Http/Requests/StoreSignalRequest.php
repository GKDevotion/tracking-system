<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSignalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'pair'      => 'required|string|max:20',
            'direction' => 'required|in:BUY,SELL',
            'entry_min' => 'required|numeric',
            'entry_max' => 'nullable|numeric',
            'sl'        => 'required|numeric',
            'tp1'       => 'nullable|numeric',
            'tp2'       => 'nullable|numeric',
            'tp3'       => 'nullable|numeric',
            'channel'   => 'in:public,vip',
        ];
    }
}
