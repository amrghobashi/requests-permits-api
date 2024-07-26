<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    public static $wrap = null;
    public function toArray($request)
    {
        $array = [
            'request_id' => $this->request_id,
            'request_status_id' => (int)$this->request_status_id,
            'response_id' => (int)$this->response_id,
            'gate_id' => (int)$this->gate_id,
            'r_notes' => $this->r_notes,
            'subject' => $this->subject,
            'address' => $this->address,
            'company_msg' => $this->company_msg,
            'request_date' => $this->request_date,
            'to_excel' => $this->to_excel,
            'internet_flag' => $this->internet_flag,
            'company_name'=>$this->company->company_name,
            'request_status_name'=>$this->status->request_status_name,
            'gate_name'=>$this->gate->gate_name,
        ];
        if(isset($this->response_id))
            $array['response_name'] = $this->response->responce_name;
        else
            $array['response_name'] = '';
        return $array;
    }
}
