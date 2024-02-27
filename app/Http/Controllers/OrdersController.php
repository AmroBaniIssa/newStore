<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $user = Auth::user();
        // dd($orders);
        // $orders = Orders::where('user_id', $user->id)->get();
        $cart = session()->get('cart', []);
        // dd($cart);
        // $cart = [];
        // foreach ($orders as $order) {
        //     $product = Product::where('id', $order->product_id)->first();
        //     if ($product) {
        //         $cart[$product->id] = [
        //             'product' => $product,
        //             'order' => $order,
        //         ];
        //     }
        // }
        return view("orders.cart", [
            "cart" => $cart,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function orderspage(Request $request)
    {
        // $user = Auth::user();
        $user = Auth::user();
        $orders = Orders::where('user_id', $user->id)->get();
        // $orders4sale = Product::where('user_id', $user->id)->get();
        // dd($orders4sale);

        $orders4sale = Orders::where('product_id', function ($query) use ($user) {
            $query->select('id')
                ->from('products')
                ->where('user_id', $user->id)
                ->whereColumn('orders.product_id', 'products.id');
        })->get();
        // dd($orders4sale);
        $formattedOrders4Sale = [];
        foreach ($orders4sale as $order) {
            // $product = Product::where('id', $order->product_id)->first();
            $product = Product::where('id', $order->product_id)->first();
            // dd($product);
            if ($product) {

                $formattedOrders4Sale[] = [
                    'product_id' => $product->id,
                    'product_image' => $product->image_url,
                    'product_name' => $product->name,
                    'order_id' => $order->id,
                    'order_quantity' => $order->quantity,
                    'order_note' => $order->note,
                    'order_address' => $order->address,
                    'order_status' => $order->status,
                    'order_price' => $order->price, // Assuming product price is what you want
                    'order_total_price' => $order->total_price,
                ];
            }
        }
        // dd($formattedOrders4Sale);
        $formattedOrders = [];

        foreach ($orders as $order) {
            $product = Product::where('id', $order->product_id)->first();

            if ($product) {
                $formattedOrders[] = [
                    'product_id' => $product->id,
                    'product_image' => $product->image_url,
                    'product_name' => $product->name,
                    'order_id' => $order->id,
                    'order_quantity' => $order->quantity,
                    'order_note' => $order->note,
                    'order_address' => $order->address,
                    'order_status' => $order->status,
                    'order_price' => $product->price, // Assuming product price is what you want
                    'order_total_price' => $order->total_price,
                ];


            }
            // $correspondingProduct = $orders4sale->where('id', $order->product_id)->first();

            // $correspondingProduct = $order->where('product_id', $orders4sale->id)->first();

            // if ($correspondingProduct) {
            //     $formattedOrders4Sale[] = [
            //         'product_id' => $correspondingProduct->id, // Use $correspondingProduct instead of $product
            //         'product_image' => $correspondingProduct->image_url,
            //         'product_name' => $correspondingProduct->name,
            //         'order_id' => $order->id,
            //         'order_quantity' => $order->quantity,
            //         'order_note' => $order->note,
            //         'order_address' => $order->address,
            //         'order_status' => $order->status,
            //         'order_price' => $correspondingProduct->price,
            //         'order_total_price' => $order->total_price,
            //     ];
            // }


        }

        // dd($formattedOrders4Sale);

        // dd($formattedOrders); 
        return view("orders.orderspage", [
            "orders" => $formattedOrders,
            "orders4sale" => $formattedOrders4Sale,
        ]);
    }


    public function create(Request $request)
    {

        $user = Auth::user();
        $product_id = $request->input('product');
        $product = Product::where('id', $product_id)->first();
        $quantity = $request->input('quantity', 1);
        $note = $request->input('note', '');
        $total_price = $product['price'] * $quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += $quantity;
            $cart[$product_id]['note'] = $note;
            $cart[$product_id]['total_price'] = $cart[$product_id]['quantity'] * $product->price;
        } else {
            $cart[$product_id] = [
                'product_id' => $product_id,
                'name' => $product->name,
                'image_url' => $product->image_url,
                'quantity' => $quantity,
                'note' => $note,
                'price' => $product->price,
                'total_price' => $total_price,
            ];
        }

        session()->put('addedToCart', $product->id);
        session()->put('cart', $cart);

        return redirect()->route('products');
        // return response()->json(['message' => 'Product added to cart successfully','redirectUrl' => route('products'),]);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);
        // Loop through cart items
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            if ($product) {
                $quantity = $item['quantity'];
                $note = $item['note'];
                $total_price = $product->price * $quantity;

                // Create order for each item
                Orders::create([
                    'quantity' => $quantity,
                    'total_price' => $total_price,
                    'note' => $note,
                    'address' => $request->input('address', ''),  // Adjust this based on your form fields
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'status' => 'pending',
                ]);
            }
        }

        // Clear the cart after creating orders
        session()->forget('cart');
        session()->forget('addedToCart');


        return redirect()->route('products')->with('success', 'Products added to cart successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(orders $orders)
    {
        //
    }

    public function updateQuantity(Request $request)
    {
        // dd($request->all());

        $productId = $request->input('productId');
        $change = $request->input('change');
        $note = $request->input('note');

        //   dd($productId, $change, $note);
        $cart = Session::get('cart', []);
        // dd($cart);
        if (isset($cart[$productId])) {

            $cart[$productId]['quantity'] += $change;
            $cart[$productId]['quantity'] = max(1, $cart[$productId]['quantity']);

            $cart[$productId]['total_price'] = $cart[$productId]['quantity'] * $cart[$productId]['price'];

            $cart[$productId]['note'] = $note;
            session()->put('cart', $cart);



            return response()->json([
                'success' => true,
                'message' => 'Quantity updated successfully.',
                'quantity' => $cart[$productId]['quantity'],
                'note' => $cart[$productId]['note'],
                'total_price' => $cart[$productId]['quantity'] * $cart[$productId]['price'], // You can add more data
                'redirectUrl' => route('cart'),
            ]);
        }

        return response()->json(['error' => 'Product not found in the cart'], 404);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, orders $orders)
    {
        //
        // $order = Orders::find($orderId); 
        // $order->update(['status' => 'new_status']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(orders $orders)
    {
        //
    }
}
