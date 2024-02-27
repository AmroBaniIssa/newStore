<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Category;
class RegisterController extends Controller
{
    public function __construct(){
        $this->middleware("guest");
    }
    public function index()
    {
        $products = Product::paginate(9);
        $categories = Category::all();
        return view('auth.register',[
            "products" => $products,
            "categories"=> $categories,
        ]);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|confirmed',
        ]);
        
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);
        
       auth()->attempt($request->only('email', 'password'));
        
        // dd($request ->only('email'));
        return redirect()->route('dashboard');
    }
}
