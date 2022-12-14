<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories(){
        $categories = Category::all();
        return response()->json([
            'success' => true,
            'message' => 'Get Products',
            'response' => 'get_products',
            'data' => $categories
        ], 200);
    }
}
