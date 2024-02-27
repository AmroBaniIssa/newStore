<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categories = Category::all();

        if ($search) {
            return redirect()->route('bySearch', ['search' => $search]);
        }
        // If there's no search query, render the view with all products
        $products = Product::paginate(9);

        return view("products.index", [
            "products" => $products,
            "categories" => $categories,
            "search" => $search ?? "",
        ]);
    }
    public function home()
    {
        // dd('Controller method called');
        $products = Product::paginate(9);
        $categories = Category::all();

        return view("products.index", [
            "products" => $products,
            "categories" => $categories,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // dd('the product added');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categories = Category::all();

        $this->validate($request, [
            'name' => 'required|max:255',
            'code' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|max:255',
            // 'image_url' => 'image|mimes:jpeg,png,jpg,gif',
            'description' => 'required',
            'tags' => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_url')) {
            // dd($request->file('image_url')); 
            $imagePath = $request->file('image_url')->storeAs('image_urls', uniqid() . '_' . $request->file('image_url')->getClientOriginalName(), 'public');
            $imageUrl = 'storage/' . $imagePath;

        } else {
            $imageUrl = $request->input('image_url_input');
        }

        $tags = explode(', ', $request->input('tags'));

        $request->user()->products()->create([
            'name' => $request->name,
            'code' => $request->code,
            'category_id' => $request->input('category_id'),
            'price' => $request->price,
            'image_url' => $imageUrl,
            'tags' => $tags,
            'description' => $request->description,
        ]);

        $products = Product::paginate(9);
        // dd($products);
        return view("products.index", [
            "products" => $products,
            "categories" => $categories,
        ]);
    }




    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        // $products = Product::all();
        // dd($products-> );
        // dd($product);
        $categories = Category::all();

        return view('products.oneProduct', compact('product', 'categories'));

        // return view("products.oneProduct", [
        //     "products"=> $products,
        // ]);
    }

    public function productsByCategory(Category $category)
    {
        $products = Product::where('category_id', $category->id)->paginate(10);
        $categories = Category::all();

        // dd($products);
        return view('products.byCategory', compact('products', 'categories'));
    }

    public function productsTag($tag)
    {
        $tag = urldecode($tag);
        $categories = Category::all();

        $products = Product::where('tags', 'like', '%' . $tag . '%')->paginate(10);
        return view('products.byTag', compact('products', 'tag', 'categories'));
    }

    public function bySearch($search)
    {

        // $search = $search->input('search');

        // Use the $search variable to filter your products
        $products = Product::where('name', 'like', "%$search%")
            ->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->orWhere(function ($query) use ($search) {
                $query->whereJsonContains('tags', $search);
            })
            ->paginate(9);

        $categories = Category::all();

        return view("products.bySearch", [
            "products" => $products,
            "categories" => $categories,
            "search" => $search,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        //
    }
}
