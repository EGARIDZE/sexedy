<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductFabric;
use Illuminate\Http\Request;

class ProductFabricsController extends BaseController
{
    public function __construct()
    {
        $this->model = ProductFabric::class;
    }
}