<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /*=============================================
    VISTA DE VENTAS
  =============================================*/
    public function index(){
        return view('sales');
    }
    /*=============================================
    OBTENEMOS TODAS LAS VENTAS
    =============================================*/
    public function getSales(){
        $sales = Order::with('product.category')->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'Get Sales',
            'response' => 'get_sales',
            'data' => $sales
        ], 200);
    }
}
