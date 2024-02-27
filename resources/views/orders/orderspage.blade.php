<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>cart</title> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


</head>

<div class="bg-gray-100 h-screen py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4"> Orders that you buy </h1>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="md:w-3/4">
                <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                 
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="text-left font-semibold">Image</th>
                                <th class="text-left font-semibold">Order ID</th>
                                <th class="text-left font-semibold">Product ID</th>
                                <th class="text-left font-semibold">Order Name</th>
                                <th class="text-left font-semibold">Quantity</th>
                                <th class="text-left font-semibold">Note</th>
                                <th class="text-left font-semibold">Address</th>
                                <th class="text-left font-semibold">Status</th>
                                <th class="text-left font-semibold">Price</th>
                                <th class="text-left font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $item)
                            <tr>
                                <!-- Adjust the following lines based on your actual array keys -->
                                <td class="py-4"><img src="{{ $item['product_image'] }}" alt="Product image"
                                        class="h-16 w-16 mr-4"></td>
                                <td class="py-4">{{ $item['order_id'] }}</td>
                                <td class="py-4">{{ $item['product_id'] }}</td>

                                <td class="py-4">{{ $item['product_name'] }}</td>
                                <td class="py-4">{{ $item['order_quantity'] }}</td>
                                <td class="py-4">{{ $item['order_note'] }}</td>
                                <td class="py-4">{{ $item['order_address'] }}</td>
                                <td class="py-4">{{ $item['order_status'] }}</td>
                                <td class="py-4">{{ $item['order_price'] }}</td>

                                <td class="py-4">{{ $item['order_total_price'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>

        </div>
    </div>
</div>

<div class="bg-gray-100 h-screen py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4"> Orders 4 sale list</h1>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="md:w-3/4">
                <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                 
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="text-left font-semibold">Image</th>
                                <th class="text-left font-semibold">Order ID</th>
                                <th class="text-left font-semibold">Product ID</th>
                                <th class="text-left font-semibold">Order Name</th>
                                <th class="text-left font-semibold">Quantity</th>
                                <th class="text-left font-semibold">Note</th>
                                <th class="text-left font-semibold">Address</th>
                                <th class="text-left font-semibold">Status</th>
                                <th class="text-left font-semibold">Price</th>
                                <th class="text-left font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders4sale as $item)
                            <tr>
                                <!-- Adjust the following lines based on your actual array keys -->
                                <td class="py-4"><img src="{{ $item['product_image'] }}" alt="Product image"
                                        class="h-16 w-16 mr-4"></td>
                                <td class="py-4">{{ $item['order_id'] }}</td>
                                <td class="py-4">{{ $item['product_id'] }}</td>
                                <td class="py-4">{{ $item['product_name'] }}</td>
                                <td class="py-4">{{ $item['order_quantity'] }}</td>
                                <td class="py-4">{{ $item['order_note'] }}</td>
                                <td class="py-4">{{ $item['order_address'] }}</td>
                                <td class="py-4">{{ $item['order_status'] }}</td>
                                <td class="py-4">{{ $item['order_price'] }}</td>

                                <td class="py-4">{{ $item['order_total_price'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>

        </div>
    </div>
</div>








<!-- 

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

</script> -->