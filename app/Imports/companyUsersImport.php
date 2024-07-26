<?php

namespace App\Imports;

use App\Models\companyUser;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class companyUsersImport implements ToModel,WithHeadingRow
{
    public function model(array $row)
    {
        return new companyUser([
			'company_id' => $row['company_id'],
			'company_name' => $row['company_name'],
            'user_name' => $row['user_name'],
            'user_pass' => $row['user_pass']
        ]);
    }
}
