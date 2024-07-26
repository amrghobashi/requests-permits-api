<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemsCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return $array = [
            'item_parent_id' => $this->item_parent_id,
            'item_parent_name' => $this->item_parent_name,
            'item_type_name'=>$this->item_type->item_type_name,
        ];
    }
}
