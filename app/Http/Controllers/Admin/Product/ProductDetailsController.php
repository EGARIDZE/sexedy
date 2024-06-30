<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductDetailsController extends BaseController
{
    public function __construct()
    {
        $this->model = ProductDetails::class;
    }
}