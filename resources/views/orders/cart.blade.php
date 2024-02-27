<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>cart</title> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


</head>

<div class="bg-gray-100 h-screen py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="md:w-3/4">
                <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="text-left font-semibold">Product</th>
                                <th class="text-left font-semibold">Price</th>
                                <th class="text-left font-semibold">Quantity</th>
                                <th class="text-left font-semibold">note</th>
                                <th class="text-left font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach (session('cart', []) as $item)

                            @if (is_array($item) && isset($item['name']))

                            <tr>
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <img class="h-16 w-16 mr-4" src="{{ $item['image_url'] }}" alt="Product image">
                                        <span class="font-semibold">{{ $item['name'] }}</span>
                                    </div>
                                </td>
                                <td class="py-4">{{ $item['price'] }}</td>



                                <form action="{{ route('updateQuantity') }}" method="POST" class="your-form-class">
                                    @csrf
                                    <input type="hidden" name="productId" id="productId{{$item['product_id'] }}"
                                        value="0">
                                    <input type="hidden" name="change" id="change{{$item['product_id'] }}" value="0">
                                    <input type="hidden" name="note" id="notee{{$item['product_id'] }}" value="">


                                    <td class="py-4">
                                        <div class="flex items-center">

                                            <button type="button" class="border rounded-md py-2 px-4 mr-2"
                                                onclick="updateQuantity({{$item['product_id']}}, -1, '', event)">-</button>

                                            <span id="quantity{{ $item['product_id'] }}" class="text-center w-8">
                                                {{ $item['quantity'] }}
                                            </span>

                                            <button type="button" class="border rounded-md py-2 px-4 ml-2"
                                                onclick="updateQuantity({{$item['product_id']}}, 1, '', event)">+</button>

                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            @if ($item['note'])
                                            <h1 id="note{{ $item['note'] }}" class="text-center mr-4 w-8">
                                                {{ $item['note'] }}
                                            </h1>
                                            @endif
                                            <input type="text" id="note{{ $item['product_id'] }}"
                                                class="border rounded-md py-2 px-4 mr-4 w-full" placeholder="Add note">


                                            <button type="button" class="border rounded-md py-2 px-4 mr-2"
                                                onclick="updateQuantity({{$item['product_id']}}, 0, document.getElementById('note{{$item['product_id']}}').value, event)">add
                                                note</button>

                                        </div>


                                    </td>

                                </form>

                                <td class="py-4">{{ $item['total_price'] }}</td>
                            </tr>
                            @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Summary</h2>
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Taxes</span>
                        <span id="taxes">$0.00</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Shipping</span>
                        <span id="shipping">$0.00</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Total</span>
                        <span class="font-semibold" id="total">$0.00</span>
                    </div>
                    <form id="checkoutForm" action="{{ route('add.to.orders') }}" method="POST" class="your-form-class">
                        @csrf
                        <button type="submit"
                            class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">Checkout</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>











<script>
    function updateQuantity(productId, change, note, event) {
        event.preventDefault();
        var quantityElement = document.getElementById('quantity' + productId);
        var newQuantity = parseInt(quantityElement.innerText) + change;
        quantityElement.innerText = newQuantity;

        var product_id = document.getElementById('productId' + productId);
        product_id.value = productId;

        var newChange = document.getElementById('change' + productId);
        newChange.value = change;

        var newNote = document.getElementById('notee' + productId);
        newNote.value = note || "no note";

        console.log(newNote.value, "note")
        console.log(product_id.value, "product_id")
        console.log(newChange.value, "cahnge")

        fetch('{{ route("updateQuantity") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                productId: product_id.value,
                change: newChange.value,
                note: newNote.value,
            }),

        })
            .then(response => response.json())
            .then(data => {
                //he quantity displayed on the page
                // quantityElement.innerText = data.quantity;
                if (data.success) {
                    window.location.href = data.redirectUrl;
                    console.log('Success:', data);
                } else {
                    // Handle error or show a message
                    console.error('Product not found in the cart');
                }
            })

    }



    function updateSummary() {
        // Get all the elements for subtotal, taxes, shipping, and total
        var subtotalElement = document.getElementById('subtotal');
        var taxesElement = document.getElementById('taxes');
        var shippingElement = document.getElementById('shipping');
        var totalElement = document.getElementById('total');

        // Initialize variables
        var subtotal = 0;
        var taxes = 0.1; // Example tax rate (you can adjust this)
        var shipping = 2.00; // Example shipping cost (you can adjust this)

        // Loop through each item in the cart
        @foreach(session('cart', []) as $item)
        @if (is_array($item) && isset($item['name']))
            var quantity = parseInt(document.getElementById('quantity{{ $item['product_id'] }}').innerText);
        var price = parseFloat('{{ $item['price'] }}');
        subtotal += quantity * price;
        @endif
        @endforeach

        // Calculate taxes and total
        taxes = (subtotal * taxes).toFixed(2);
        total = (subtotal + parseFloat(taxes) + shipping).toFixed(2);

        // Update the HTML elements
        subtotalElement.innerText = '$' + subtotal.toFixed(2);
        taxesElement.innerText = '$' + taxes;
        shippingElement.innerText = '$' + shipping.toFixed(2);
        totalElement.innerText = '$' + total;
    }

    // Call the updateSummary function initially and whenever the quantity changes
    updateSummary();

</script>