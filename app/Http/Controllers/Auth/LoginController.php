<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware("guest");
    }
    public function index()
    {
        $products = Product::paginate(9);
        $categories = Category::all();


        return view('auth.login',[
            "products" => $products,
            "categories"=> $categories,
        ]);

    }

    public function store(Request $request)
    {
        // dd("ok");
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($request->only('email', 'password'),$request->remember)) {


            return back()->with('status', 'invalid login');
        }

        // dd(Auth::user());
        else {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }


    }
}
