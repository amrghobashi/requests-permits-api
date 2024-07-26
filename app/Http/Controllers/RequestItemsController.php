<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestItemsCollection;
use App\Http\Resources\RequestItemsResource;
use App\Models\RequestItem;
use App\Models\Requests;
use File;
use Illuminate\Http\Request;

class RequestItemsController extends Controller
{
    public function get_request_items($id)
    {
        $items = RequestItem::where('request_id', $id)->where('item_name', null)->get();
        return new RequestItemsCollection($items);
    }

    public function get_finished_request_items($id)
    {
        $items = RequestItem::where('request_id', $id)->orderBy('ceo_response', 'desc')->get();
        return new RequestItemsCollection($items);
    }

    public function store(Request $request)
    {
        $newItem = RequestItem::create([
            "quantity" => $request->quantity,
            "other_details" => $request->other_details,
            "request_id" => $request->request_id,
            "item_name" => $request->item_name,
            "item_parent_id" => $request->item_parent_id,
            "item_unit_id" => $request->item_unit_id
        ]);
        return new RequestItemsResource($newItem);
    }

    public function update(Request $request, RequestItem $request_item)
    {
        $request_item->update([
            'item_parent_id' => $request->item_parent_id,
            'item_unit_id' => $request->item_unit_id,
            'quantity' => $request->quantity,
            'other_details' => $request->other_details,
        ]);
        $request_item->save();
        return new RequestItemsResource($request_item);
    }

    public function uploadImg(Request $request)
    {
        if ($request->hasFile('request_image')) {
            $request->validate([
                'request_image' => 'image|mimes: jpeg,png,jpg|max:5120',
            ]);
            $request_id = +$request->request_id;
            $img = $request->file('request_image');
            $company_id = auth()->user()->company_id;
            $imgPath = public_path('reqimg/' . $company_id . '/') . $request_id;

            if (!file_exists($imgPath)) {
                mkdir($imgPath, 0777, true);
            }
            $imgname = time() . '.' . $img->extension();
            $img->move($imgPath, $imgname);

            return response()->json([
                "success" => true,
                "message" => "image uploaded successfully"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "image not uploaded"
            ]);
        }
    }

    public function get_images($id)
    {
        $company_id = auth()->user()->company_id;
        $path = public_path('reqimg/' . $company_id . '/' . +$id);
        if (file_exists($path)) {
            $images = File::allFiles($path);
            $arrCount = count($images);
            if ($arrCount == 0) {
                $imagesArr = 0;
            } else {
                for ($i = 0; $i < $arrCount; $i++) {
                    $imagesArr[$i] = [
                        'image_name' => $images[$i]->getFilename()
                    ];
                }
            }
        } else {
            $imagesArr = 0;
        }
        return $imagesArr;
    }

    public function delete_image(Request $request)
    {
        $company_id = auth()->user()->company_id;
        $path = public_path('reqimg/' . $company_id . '/') . $request->path;
        unlink($path);
    }

    public function inquiry(Request $request)
    {
        $search = Requests::where('request_id', $request->request_id)->get();
    }

    public function destroy(RequestItem $request_item)
    {
        $request_item->delete();
    }
}
