@extends('layouts.app')
@section('content')
<div class="flex justify-center">
    <div class="w-8/12 bg-white p-6 rounded-lg mb-6">
        <h1> products </h1>
    </div>

</div>

<div classs="flex justify-center">
    <div
        class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">
        @if ($products->count())
        @foreach ($products as $product )
        <div class="">
            <div
                class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="#">
                    <!-- <img class="rounded-t-lg" src="{{$product->image_url}}" alt="" /> -->
                    <img class="rounded-t-lg" src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" />

                    
                </a>
                <div class="p-5">
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{$product->name}}</h5>
                    </a>
                    <div class="ml-auto flex space-x-0.5">
                        @if ($product->tags)
                        @foreach ( $product->tags as $tag)
                        <div class="flex ">
                            <a href="{{ route('productsTag', ['tag' => $tag]) }}"
                            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 "  >
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
                        <div class="ml-auto"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" class="bi bi-bag-plus" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z" />
                                <path
                                    d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                            </svg></div>
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
        @endif
        {{$products->links()}}
    </div>
</div>

@endsection