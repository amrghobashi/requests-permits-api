<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyUserCollection extends ResourceCollection
{
    public static $wrap = null;

    public function toArray($request)
    {
        return $this->collection->map(function($request){
                $array = [
                    'company_id' => $request->company_id,
                    'user_name' => $request->user_name,
                    'company_name' => $request->company_name,
                    'active' => (int)$request->active,
                    'record_date' => $request->record_date
                ];

            $user_type = auth()->user()->admin_flag;
            if($user_type == 2)
                $array['user_pass']=$request->user_pass;
            else
                $array['user_pass'] = '';
            return $array;
        });
    }
}


