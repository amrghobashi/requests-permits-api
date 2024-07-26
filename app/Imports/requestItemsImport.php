<?php

namespace App\Imports;

use App\Models\requestItem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class requestItemsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new requestItem([
            'item_id' => $row['item_id'],
            'request_id' => $row['request_id'],
            'item_parent_id' => $row['item_parent_id'],
            'item_type_id' => $row['item_type_id'],
            'ceo_response' => $row['ceo_response']
        ]);
    }
}
