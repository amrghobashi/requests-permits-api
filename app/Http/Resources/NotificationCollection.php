<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return $this->collection->map(function($request){

                $array = [
                    'notification_id' => $request->notification_id,
                    'notification_name' => $request->notification_name
                ];
            return $array;
        });
    }
}
