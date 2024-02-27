@extends('layouts.app')
@section('content')
<div class="flex justify-center">
    <div class="w-4/12 bg-white p-6 rounded-lg mb-4">
        <h1> Dshboard</h1>

    </div>

</div>
<div class="flex justify-center">
    <form action="{{route('addCategory')}}" method="post" class="mb-4">
        @csrf
        <div class="mb-4">
            <label for="name" class="sr-only">Category Name</label>
            <input type="text" name="name" id="name" placeholder="Category name"
                class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror "
                value="{{ old('name') }}">

            @error('name')
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Create
                Category</button>
        </div>
    </form>
</div>



<div class="flex justify-center">
    <div class="w-4/12 bg-white p-6 rounded-lg mb-4">
        <form action="{{route('products')}}" method="post" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="mb-4">
                <label for="name" class="sr-only">Product Name</label>
                <input type="text" name="name" id="name" placeholder="Product name" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name')
                border-red-500
                @enderror         
                 " value="{{old('name')}}">

                @error('name')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="code" class="sr-only">Product Code</label>
                <input type="text" name="code" id="code" placeholder="code" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('code')
                border-red-500
                @enderror
                " value="{{old('code')}}">
                @error('code')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category" class="sr-only">Category</label>
                <select name="category_id" id="category" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                    <option value="" disabled selected>Select a category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="sr-only">price</label>
                <input type="text" name="price" id="price" placeholder="price" class="bg-gray-100 border-2 w-full p-4 rounded-lg  @error('price')
                border-red-500
                @enderror       
                " value="{{old('price')}}">
                @error('price')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
           
            <div class="mb-4">
                <label for="image_url" class="sr-only">Product Image</label>
                <input type="file" name="image_url" id="image_url"
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('image_url') border-red-500 @enderror">
                <label for="image_url_input" class="sr-only">Product Image URL</label>
                <input type="text" name="image_url_input" id="image_url_input" placeholder=" or you can enter Image URL"
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('image_url_input') border-red-500 @enderror">
                @error('image_url')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
                @error('image_url_input')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="sr-only">Product Description url</label>
                <textarea type="description" name="description" id="description" placeholder="description" class="bg-gray-100 border-2 w-full p-4 rounded-lg  @error('description')
                border-red-500
                @enderror       
                " value="{{ old('description') }}">
                @error('description')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
                </textarea>
            </div>
            <div class="mb-4">
                <label for="tags" class="sr-only">Tags</label>
                <input type="text" name="tags" id="tags" placeholder="Tag1, Tag2, Tag3" class="bg-gray-100 border-2 w-full p-4 rounded-lg  @error('tags')
                border-red-500
                @enderror       
                " value="{{ old('tags') }}">
                @error('tags')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full" value="">Add
                    Product
                </button>
            </div>

        </form>
    </div>
</div>
@endsection