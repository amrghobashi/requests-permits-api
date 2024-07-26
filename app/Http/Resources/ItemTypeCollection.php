<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemTypeCollection extends ResourceCollection
{
    public static $wrap = null;
    public function toArray($request)
    {
        return $this->collection->map(function($request){
            return
                $array = [
                    'item_type_id' => $request->item_type_id,
                    'item_type_name' => $request->item_type_name,
                ];
        });
    }
}
