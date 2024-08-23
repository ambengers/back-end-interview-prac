<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Products</title>

    <style>
        .alert-success {
            color: green;
        }

        .alert-danger {
            color: red;
        }

    </style>
</head>
<body>

<h1>Current Products</h1>

@if ($products->count())
    <ul>
        @foreach ($products as $product)
            <li>
                <h3>{{ $product->name }}</h3>
                @if($product->description)
                    <p>Description: {{ $product->description }}</p>
                @endif
                @if($product->tags->isNotEmpty())
                    <p>Tags: {{ $product->tags->implode('name', ', ') }}</p>
                @endif
                <form action='{{ route('products.destroy', ['id' => $product->id]) }}' method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE"/>
                    <button type="submit">delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@else
    <p><em>No products have been created yet.</em></p>
@endif



@if (session('status'))
    <div class="alert-success">
        {{ session('status') }}
    </div>
@elseif($errors->any())
    <div class="alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<hr />

<h2>New product</h2>
<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="name" /><br />
    <textarea name="description" placeholder="description"></textarea><br />
    <input type="text" name="tags" placeholder="tags" /><br />
    <button type="submit">Submit</button>
</form>

</body>
</html>
