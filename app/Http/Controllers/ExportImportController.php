<?php

namespace App\Http\Controllers;

use App\Imports\companyUsersImport;
use App\Imports\requestItemsImport;
use App\Imports\showRequestsImport;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Item;
use App\Models\RequestItem;
use Illuminate\Http\Request;
use App\Models\Requests;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportImportController extends Controller
{
    public function get_export_count()
    {
        return $count = Requests::where('request_status_id', '=', 2)
            ->where([['internet_flag', '=', 'N'], ['to_excel', '=', null], ['company_id', '!=', '0']])
            ->orderBy('request_id', 'desc')->count();
    }

    public function export_requests()
    {
        DB::statement('call update_to_excel()');
        return $select = Requests::where([
            ['request_status_id', '2'], ['internet_flag', 'N'], ['to_excel', '1'],
            ['company_id', '!=', '0']
        ])
            ->get(['request_id', 'company_id', 'request_date', 'gate_id', 'r_notes', 'subject', 'address']);
    }

    public function confirm_export()
    {
        DB::statement('call update_internet_flag()');
    }

    public function export_request_items()
    {
        return $select = DB::table('request_permits')->where([
            ['request_status_id', '2'], ['internet_flag', 'N'],
            ['to_excel', '1'], ['company_id', '!=', '0']
        ])
            ->join('request_items', 'request_permits.request_id', '=', 'request_items.request_id')
            ->get([
                'item_id', 'item_name', 'quantity', 'other_details', 'request_permits.request_id',
                'item_unit_id', 'item_parent_id'
            ]);
    }

    public function import_requests(Request $request)
    {
        $file = $request->file('file');
        if ($file->extension() == "xlsx") {
            $data = Excel::toArray(new showRequestsImport, $file);
            collect(head($data))->each(function ($row) {
                $requests = Requests::where('request_id', '=', $row['request_id'])->get();
                if (count($requests) == 1) {
                    $request = Requests::find($row['request_id']);
                    $request->company_msg = $row['company_msg'];
                    $request->response_id = $row['response_id'];
                    $request->request_status_id = 4;
                    $request->save();
                }
            });
            return response()->json([
                "success" => true,
                "message" => "file uploaded successfully",
                "count" => count($data[0])
            ]);
        } elseif ($file->extension() !== "xlsx") {
            return response()->json([
                "success" => false,
                "message" => "NOTEXCEL"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "ERROR"
            ]);
        }
    }

    public function import_items()
    {
        $data =  Excel::toArray(new requestItemsImport, request()->file('file'));
        collect(head($data))->each(
            function ($row) {
                $items = item::where('item_parent_id', '=', $row['item_parent_id'])->get();
                if ($row['internet_flag'] == 'N' || count($items) == 0) {
                    $items_n = item::where('item_parent_id', '=', $row['item_parent_id'])->get();
                    if (count($items_n) == 0) {
                        $rowArray = array('item_parent_id' => $row['item_parent_id'], 'item_parent_name'
                        => $row['item_parent_name'], 'item_type_id' => $row['item_type_id']);
                        item::insert($rowArray);
                    }
                }
                $request_item = requestItem::find($row['item_id']);
                $itemRowArray = array('ceo_response' => $row['ceo_response']);
                if (is_null($request_item['item_parent_id']))
                    $itemRowArray += ['item_parent_id' => $row['item_parent_id']];
                $request_item->update($itemRowArray);
            }
        );
        return response()->json([
            "success" => true,
            "message" => "file uploaded successfully",
            "count" => count($data[0])
        ]);
    }

    public function import_users()
    {
        $data =  Excel::toArray(new companyUsersImport, request()->file('file'));
        collect(head($data))->each(
            function ($row) {
                $company = company::where('company_id', '=', $row['company_id'])->get();
                if (count($company) == 0) {
                    $companyArray = array('company_id' => $row['company_id'], 'company_name' => $row['company_name']);
                    company::insert($companyArray);

                    $userArray = array('company_id' => $row['company_id'], 'user_name' =>
                    $row['user_name'], 'user_pass' => $row['user_pass']);
                    companyUser::insert($userArray);
                } else {
                    companyUser::where('company_id', '=', $row['company_id'])
                        ->update(['user_name' => $row['user_name'], 'user_pass' => $row['user_pass']]);
                }
            }
        );
        return response()->json([
            "success" => true,
            "message" => "file uploaded successfully",
            "count" => count($data[0])
        ]);
    }
}
