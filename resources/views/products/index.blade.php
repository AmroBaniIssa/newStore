@extends('layouts.app')
@section('content')
<!-- <div class="flex justify-center">
    <div class="w-8/12 bg-white p-6 rounded-lg mb-6">
        <h1> products</h1>
    </div>

</div> -->
<div class="flex flex-col gap-4 justify-center items-center p-4 my-6 ">


    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold">
        products </h1>
    <div class="relative p-3 border border-gray-200 rounded-lg w-full max-w-lg">

        <form action="{{ route('products', ['search' => $search ?? '']) }}" method="get" enctype="multipart/form-data"
            class="mb-4">

            <input type="text" name="search" class="rounded-md p-3 w-full"
                placeholder="Search product Name | Category | Tag" value="{{ request('search') }}">
            <button type="submit" class="absolute right-6 top-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </button>
        </form>


    </div>

</div>
<!-- 
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif -->

<!-- @if (session('success'))
    <div id="successMessage" class="fixed top-0 right-0 m-8 bg-green-500 text-white py-2 px-4 rounded">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000); // Hide after 3 seconds
    </script>
@endif -->


<div classs="flex justify-center">
    <div
        class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">
        @foreach ($products as $product )
        <div class="">
            <div
                class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="#">
                    <!-- <img class="rounded-t-lg" src="{{$product->image_url}}" alt="" /> -->
                    <img class="rounded-t-lg w-100 h-100 object-cover" src="{{ asset($product->image_url) }}"
                        alt="{{ $product->name }}" />


                </a>
                <div class="p-5">
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{$product->name}}</h5>
                    </a>
                    <div class="ml-auto flex space-x-0.5">
                        @if (is_array($product->tags))
                        @foreach ($product->tags as $tag)
                        <div class="flex">
                            <a href="{{ route('productsTag', ['tag' => $tag]) }}"
                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                {{ $tag }}
                            </a>
                        </div>
                        @endforeach
                        @endif
                    </div>

                    <!-- <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$product->description}}</p> -->
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        {{ strlen($product->description) > 80 ? substr($product->description, 0, 100) . '...' :
                        $product->description }}
                    </p>
                    <div class="flex items-center">
                        <p class="text-lg font-semibold text-black cursor-auto my-3">{{$product->price}}</p>
                        <del>
                            <p class="text-sm text-gray-600 cursor-auto ml-2">{{$product->price*1.3}}</p>
                        </del>
                        <div class="ml-auto mt-4">
                            <!-- <form action="{{route('register')}}" method="post"> -->

                            <form action="{{ route('add.to.cart', ['product' => $product]) }}" method="post">
                            @csrf

                            <button type="submit" class="{{ session('addedToCart') == $product->id ? 'bg-red-500 hover:bg-red-700' : 'bg-white-500 hover:bg-red-700' }} text-black; font-bold py-2 px-3 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-bag-plus" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z" />
                                        <path
                                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                    </svg>
                                </button>

                            </form>
 
                            
                        </div>
                        <!-- 
                        <div class="ml-auto">
                            <form action="{{ route('add.to.cart', ['product' => $product]) }}" method="post">
                                @csrf
                                <button type="submit" class="btn-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-bag-plus" viewBox="0 0 16 16">
                                    </svg>
                                </button>
                            </form>
                        </div> -->

                        <a href="{{route('oneProduct', ['product' => $product])}}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-black  rounded-lg ml-4">
                            more
                            <!-- <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg> -->
                        </a>
                    </div>

                    <!-- <h6 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{$product->user->name}}</h6> -->

                </div>
            </div>
        </div>
        @endforeach
        {{$products->links()}}
    </div>
</div>

@endsection




<!-- 


<script>
    function updateQuantity(productId, change) {
        quantityElement = document.getElementById('quantity' + productId);

        // Make an AJAX request to update the quantity
        fetch('{{ route("updateQuantity") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                productId: productId,
                change: change,
                note: $('#note' + productId).val(),
            }),
        })
            .then(response => response.json())
            .then(data => {
                //he quantity displayed on the page
                quantityElement.innerText = data.quantity;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script> -->