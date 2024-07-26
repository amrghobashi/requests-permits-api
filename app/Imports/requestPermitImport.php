<?php

namespace App\Imports;

use App\Models\Requests;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class showRequestsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Requests([
            'request_id'     => $row['request_id'],
            'company_msg' => $row['company_msg'],
            'response_id' => $row['response_id']
        ]);
    }
}
