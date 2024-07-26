<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestItemsCollection;
use App\Http\Resources\RequestItemsResource;
use App\Models\RequestItem;
use Illuminate\Http\Request;

class ExtraItemsController extends Controller
{
    public function get_extra_items($id)
    {
        $items = RequestItem::where('request_id', $id)->where('item_parent_id', null)->get();
        return new RequestItemsCollection($items);
    }

    public function store(Request $request)
    {
        $newItem = RequestItem::create([
            "quantity" => $request->quantity,
            "other_details" => $request->other_details,
            "request_id" => $request->request_id,
            "item_name" => $request->item_name,
            "item_unit_id" => $request->item_unit_id
        ]);
        return new RequestItemsResource($newItem);
    }

    public function transTest(Request $request)
    {
        $newItem = RequestItem::create([
            "quantity" => 1,
            "other_details" => $request['NN']
        ]);
        return new RequestItemsResource($newItem);
    }

    public function update(Request $request, RequestItem $extra_item)
    {
        $extra_item->update([
            'item_name' => $request->item_name,
            'item_unit_id' => $request->item_unit_id,
            'quantity' => $request->quantity,
            'other_details' => $request->other_details,
        ]);
        $extra_item->save();
        return new RequestItemsResource($extra_item);
    }

    public function destroy(RequestItem $extra_item)
    {
        $extra_item->delete();
    }
}
