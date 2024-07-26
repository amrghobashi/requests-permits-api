<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemListCollection;
use App\Http\Resources\ItemTypeCollection;
use App\Http\Resources\ItemUnitCollection;
use App\Models\RequestItem;
use App\Models\CompanyUser;
use Carbon\Carbon;
use App\Http\Resources\GateCollection;
use App\Http\Resources\RequestCollection;
use App\Http\Resources\RequestResource;
use App\Models\Gate;
use App\Models\ItemType;
use App\Models\Item;
use App\Models\ItemUnit;
use App\Models\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{

    public function index()
    {
        $company_id = auth()->user()->company_id;
        $requests = Requests::where('company_id', $company_id)->orderBy('request_id', 'desc')->get();
        return new RequestCollection($requests);
    }

    public function pending()
    {
        $company_id = auth()->user()->company_id;
        $requests = Requests::where('company_id', '=', $company_id)->whereIn('request_status_id', [2, 3])
            ->orderBy('request_id', 'desc')->get();
        return new RequestCollection($requests);
    }

    public function completed()
    {
        $company_id = auth()->user()->company_id;
        $requests = Requests::where('company_id', '=', $company_id)->whereIn('request_status_id', [4])
            ->orderBy('request_id', 'desc')->get();
        return new RequestCollection($requests);
    }

    public function not_completed()
    {
        $company_id = auth()->user()->company_id;
        $requests = Requests::where('company_id', '=', $company_id)->where('request_status_id', '=', 1)
            ->orderBy('request_date', 'desc')->get()->first();
        return $requests;
    }

    public function get_count()
    {
        $company_id = auth()->user()->company_id;
        $count = DB::select("select count(request_permitS.REQUEST_ID) tot, request_permitS_STATUS.REQUEST_STATUS_ID
            from request_permitS, request_permitS_STATUS
            where request_permitS.COMPANY_ID(+) = ?
                and request_permitS.REQUEST_STATUS_ID(+) = request_permitS_STATUS.REQUEST_STATUS_ID
              group by request_permitS.REQUEST_STATUS_ID, request_permitS_STATUS.REQUEST_STATUS_ID
              ORDER BY REQUEST_STATUS_ID ASC", [$company_id]);
        $pending_count = $count[1]->tot + $count[2]->tot;
        $completed_count = (int)$count[3]->tot;
        $new_count = (int)$count[0]->tot;
        return array(
            'pending' => $pending_count,
            'completed' => $completed_count,
            'new' => $new_count
        );
    }

    public function store(Request $request)
    {
        $company_id = auth()->user()->company_id;
        $today = Carbon::now();
        $new_req = Requests::create([
            'subject' => $request->subject,
            'address' => $request->address,
            'gate_id' => $request->gate_id,
            'company_id' => $company_id,
            'request_date' => $today,
            'request_status_id' => 1,
        ]);
        return new RequestResource($new_req);
    }

    public function show(Requests $request)
    {
        return new RequestResource($request);
    }

    public function update(Request $req, Requests $request)
    {
        $request->update($req->all());
        $request->save();
        return new RequestResource($request);
    }

    public function send_request(Request $req)
    {
        DB::table('request_permits')->where('request_id', $req->request_id)->update(['REQUEST_STATUS_ID' => 2]);
    }

    public function get_gates()
    {
        $requests = Gate::where('gate_type_id', '=', 7)->get();
        return new GateCollection($requests);
    }

    public function get_item_type()
    {
        $requests = ItemType::where('active', '=', 1)->get();
        return new ItemTypeCollection($requests);
    }

    public function get_item_parent($id)
    {
        $requests = Item::where('item_type_id', '=', $id)->get();
        return new ItemListCollection($requests);
    }

    public function get_unit()
    {
        $requests = ItemUnit::orderBy('item_unit_name', 'asc')->get();
        return new ItemUnitCollection($requests);
    }

    public function inquiry(Request $request)
    {
        $search = Requests::where('request_id', $request->request_id)->get()->first();
        if ($search)
            return $data = 1;
        else return $data = 0;
    }

    public function check_request($id)
    {
        $itemsCount = RequestItem::where('request_id', $id)->count();
        $company_id = auth()->user()->company_id;
        $firstLogin = CompanyUser::where('company_id', $company_id)->get('first_login');
        $checkRequest = [
            'items_count' => $itemsCount,
            'first_login' => +$firstLogin[0]->first_login
        ];
        return [$checkRequest];
    }
}
