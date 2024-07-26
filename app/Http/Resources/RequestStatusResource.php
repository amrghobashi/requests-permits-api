<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestStatusResource extends JsonResource
{
    public static $wrap = null;
    public function toArray($request)
    {
        $array = [
            'request_status_id' => $this->request_status_id,
            'request_status_name' => $this->request_status_name,
        ];
        return $array;
    }
}
