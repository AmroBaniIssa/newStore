<?php

namespace App\Http\Controllers\Auth;
use App\Models\Product;
use App\Models\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function store(Request $request)
    {
        $products = Product::paginate(9);
        $categories = Category::all();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
          auth()->logout();
        //   return redirect()->route('home',[
        //     "products" => $products,
        //     "categories" => $categories,
        // ]);
        return view("products.index", [
            "products" => $products,
            "categories" => $categories,
        ]);
          
     
    }
}
