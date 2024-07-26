<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RequestItemsCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return $this->collection->map(function ($request) {

            $array = [
                'item_id' => $request->item_id,
                'quantity' => (int)$request->quantity,
                'other_details' => $request->other_details,
                'item_name' => $request->item_name,
                'item_parent_id' => $request->item_parent_id,
                'item_unit_id' => $request->item_unit_id,
                'item_unit_name' => $request->item_unit->item_unit_name,
                'ceo_response' => (int)$request->ceo_response
            ];
            if (isset($request->item_parent_id))
                $array['item_parent_name'] = $request->item_parent->item_parent_name;
            else
                $array['item_parent_name'] = $request->item_name;

            if (isset($request->item_parent->item_type->item_type_id)) {
                $array['item_type_name'] = $request->item_parent->item_type->item_type_name;
                $array['item_type_id'] = $request->item_parent->item_type->item_type_id;
            }

            if (isset($request->ceo_response))
                $array['response_name'] = $request->response->responce_name;
            else
                $array['response_name'] = '';
            return $array;
        });
    }
}
