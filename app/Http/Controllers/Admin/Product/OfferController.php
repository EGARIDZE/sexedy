<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index($id)
    {
        $offers = Offer::where('product_id', $id)->get();
        return $offers;
    }
}