<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Admin\AbstractAPIResponse;
use App\Models\Offer;
use App\Models\Attribute;
use App\Models\AttributeOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeOptionController extends AbstractAPIResponse
{

    public function index($id, $offer_id)
    {
        $offer = Offer::with('attributes')->find($offer_id);

        if (!$offer) {
            return $this->findOrFailItem(false, 'Offer has no options', null, 404);
        }

        $color = $offer->attributes
            ->where('name', 'Color')
            ->pluck('pivot.value');
        $size = $offer->attributes
            ->where('name', 'Size')
            ->pluck('pivot.value');

        return response()->json([
            'option-color' => $color,
            'option-size' => $size,
        ]);
    }

    public function getAttributesForOptions()
    {
        $attributes = Attribute::all();
        return response()->json($attributes);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attribute_id' => 'required',
            'offer_id' => 'required',
            'value' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->findOrFailItem(false, $validator->errors(), null, 422);
        }

        $validatedData = $validator->validated();
        $option = AttributeOption::create($validatedData);
        return $this->findOrFailItem(true, 'Option created successfully', $option, 201);
    }

    public function destroy($id, $offer_id, $name)
    {
        // Найти предложение с указанным offer_id и загрузить атрибуты
        $offer = Offer::with('attributes')->find($offer_id);

        if (!$offer) {
            return response()->json(['message' => 'Offer not found'], 404);
        }

        // Найти атрибут с указанным значением pivot
        $attribute = $offer->attributes->firstWhere('pivot.value', $name);

        if (!$attribute) {
            return response()->json(['message' => 'Attribute with specified value not found'], 404);
        }

        // Удалить конкретную запись из pivot-таблицы
        DB::table('attribute_options')
            ->where('offer_id', $offer_id)
            ->where('attribute_id', $attribute->id)
            ->where('value', $name)
            ->delete();

        return response()->json(['message' => 'Attribute detached successfully'], 200);
    }
}