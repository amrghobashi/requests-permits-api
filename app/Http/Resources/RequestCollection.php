<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RequestCollection extends ResourceCollection
{
    public static $wrap = null;
    public function toArray($request)
    {
        return $this->collection->map(function ($request) {
            $array = [
                'request_id' => $request->request_id,
                'request_status_id' => (int)$request->request_status_id,
                'r_notes' => $request->r_notes,
                'subject' => $request->subject,
                'request_date' => $request->request_date,
                'company_name' => $request->company->company_name,
                'gate_name' => $request->gate->gate_name,
                'response_id' => (int)$request->response_id,
                'company_msg' => $request->company_msg,
                'to_excel' => $request->to_excel,
                'internet_flag' => $request->internet_flag,
            ];
            if (isset($request->response_id))
                $array['response_name'] = $request->response->responce_name;
            else
                $array['response_name'] = '';
            return $array;
        });
    }
}
