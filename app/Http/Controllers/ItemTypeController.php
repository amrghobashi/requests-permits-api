<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    public function index()
    {
        $item_type = ItemType::where('active', 1)->get();
        return response()->json($item_type, 200);
    }
}
