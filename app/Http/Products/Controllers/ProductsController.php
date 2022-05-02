<?php

namespace App\Http\Products\Controllers;

use App\Core\Products\Services\ProductService;
use Illuminate\Http\Request;
use App\Http\Controller;

class ProductsController extends Controller
{
    /**
     * Controlador para llamar el servicio de productos para mostrar todos los productos
     * @return \Illuminate\Http\Response
     */
    public function index(ProductService $productService, Request $request)
    {
        return $productService->index($request);
    }
}
