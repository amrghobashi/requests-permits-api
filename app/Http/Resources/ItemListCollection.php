<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemListCollection extends ResourceCollection
{
    public static $wrap = null;
    public function toArray($request)
    {
        return $this->collection->map(function($request){
            return
                $array = [
                    'item_parent_id' => $request->item_parent_id,
                    'item_parent_name' => $request->item_parent_name,
                ];
        });
    }
}
