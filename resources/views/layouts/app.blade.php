<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-200">

    <nav class="p-6 bg-gray-100 flex justify-between mb-6">
        <ul class=" flex items-center ">
            <li class="">
                <a href="{{ route('products') }}" class="p-3">Home</a>
            </li>
            <li>
                <a href="{{route('dashboard')}}" class="p-3">dashboard</a>
            </li>

            <!-- <li>
                <a href="{{route('products')}}" class="p-3 ">products</a>

            </li> -->
            <li class="relative group">
                <a href="#" class="p-3 group-hover:bg-gray-200">Categories</a>
                <ul class="absolute hidden bg-white border rounded-lg mt-2 group-hover:block">
                    @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('products.byCategory', $category) }}" class="block px-4 py-2">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
        </ul>
        <ul class=" flex items-center ">
            @if (auth()->user())
            <li class="">
                <a href="" class="p-3">{{auth()->user()->name}}</a>
            </li>
            <li class="">
                <a href="{{ route('orderspage') }}" class="p-3">Your Orders</a>
            </li>

            <li>
                <form action="{{route('logout')}}" method="post" class="p-3 inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </li>
            @else
            <li>
                <a href="{{route('login')}}" class="p-3">Login</a>
            </li>
            <li>
                <a href="{{route('register')}}" class="p-3 ">Register</a>

            </li>
            @endif

            <li class="relative group">
                <a href="{{ route('cart') }}">
                    <img src="{{ asset('storage/image_urls/shopping-cart.png') }}" alt="Cart Icon"
                        class="w-6 h-6 mr-6 ml-2">

                </a>
            </li>

        </ul>



    </nav>

    @yield('content')
</body>

</html>