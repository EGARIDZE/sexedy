<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Admin\AbstractAPIResponse;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfferController extends AbstractAPIResponse
{
    public function index($id)
    {
        $offers = Offer::where('product_id', $id)->get();
        return $offers;
    }

    public function show($id, $offer_id)
    {

        $offer = Offer::with('attributes')->find($offer_id);
        return response()->json([
            $offer->attributes[1]->pivot->value,
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return $this->findOrFailItem(false, $validator->errors(), null, 422);
        }

        $validateData = $validator->validate();
        $validateData["code"] = Offer::generateUniqueCode();

        $offer = Offer::create($validateData);
        return $this->findOrFailItem(true, 'Offer created succesufy', $offer, 200);
    }

    public function destroy($id, $offer_id)
    {
        $offer = Offer::find($offer_id);
        if (!$offer) {
            return $this->findOrFailItem(false, 'Offer not found', null, 404);
        }

        $offer->delete();
        return $this->findOrFailItem(true, 'Offer was deleted', null, 200);
    }
}