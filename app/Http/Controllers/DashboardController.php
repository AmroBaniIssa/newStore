<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;
use App\Models\Category;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware(["auth"]);
    }
    public function index()
    {
        $categories = Category::all();

     
            return view('dashboard',compact('categories'));

     
    }

}
