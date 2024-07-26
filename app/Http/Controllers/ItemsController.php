<?php

namespace App\Http\Controllers;

use App\Models\Item;

class ItemsController extends Controller
{
    public function index()
    {
        $items = Item::get();
        return new RequestCollection($items);
    }
}
