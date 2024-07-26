<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemUnitCollection extends ResourceCollection
{
    public static $wrap = null;
    public function toArray($request)
    {
        return $this->collection->map(function($request){
            return
                $array = [
                    'item_unit_id' => $request->item_unit_id,
                    'item_unit_name' => $request->item_unit_name,
                ];
        });
    }
}
