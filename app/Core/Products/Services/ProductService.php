<?php

namespace App\Core\Products\Services;

use App\Http\Controller;
use App\Models\Product;

class ProductService extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::all();
        return $data;
    }
}
