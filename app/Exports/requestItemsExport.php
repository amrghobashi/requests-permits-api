<?php

namespace App\Exports;


use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class requestItemsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $select = DB::table('request_permits')->where([['request_status_id','2'],['internet_flag','N'],['to_excel','1']])
            ->join('request_items','request_permits.request_id','=','request_items.request_id')
            ->get(['item_id','item_name','quantity','other_details','request_permits.request_id','item_unit_id','item_parent_id']);
        return $select ;
    }
    public function headings(): array {
        return['item_id','item_name','quantity','other_details','request_id','item_unit_id','item_parent_id'];
    }
}
