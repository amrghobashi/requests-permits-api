<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestItemsResource extends JsonResource
{
    public static $wrap = null;
    public function toArray($request)
    {
        $array = [
            'item_id' => $request->item_id,
            'quantity' => (int)$request->quantity,
            'other_details' => $request->other_details,
            'item_name' => $request->item_name,
            'item_parent_id' => $request->item_parent_id,
            'item_unit_id' => $request->item_unit_id,
            'ceo_response' => (int)$request->ceo_response,
        ];
        return $array;
    }
}
