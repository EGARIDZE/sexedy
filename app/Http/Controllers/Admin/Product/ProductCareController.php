<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductCare;
use Illuminate\Http\Request;

class ProductCareController extends BaseController
{
    public function __construct()
    {
        $this->model = ProductCare::class;
    }
}