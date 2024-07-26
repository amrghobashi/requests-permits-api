<?php

namespace App\Exports;

use App\Models\Requests;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class showRequestsImport implements FromCollection,WithHeadings
{
    public function collection()
    {
        $select = Requests::where([['request_status_id','2'],['internet_flag','N'],['to_excel','1']])
            ->get(['request_id','company_id','request_date','gate_id','r_notes','subject','address']);
        return $select ;
    }

    public function headings(): array {
        return['request_id','company_id','request_date','gate_id','r_notes','subject','address'];
    }
}
