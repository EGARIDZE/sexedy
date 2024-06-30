<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Attribute;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::all();
        return $attributes;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:attributes,name',
        ]);
        if ($validator->fails()) {
            return $this->getResponseAnswer(false, 'Enter correct parameters', $validator->errors(), 422);
        }

        $validatedData = $validator->validated();
        $newAttribute = Attribute::create($validatedData);
        return $this->getResponseAnswer(true, 'Attribute create succsesfuly', $newAttribute, 200);
    }


    public function destroy($attribute_id)
    {
        $attribute  = Attribute::find($attribute_id);
        if (!$attribute) {
            return $this->getResponseAnswer(false, 'Attribute not found', null, 404);
        }

        $attribute->delete();
        return $this->getResponseAnswer(true, 'Attribute was deleted', null, 200);
    }
}