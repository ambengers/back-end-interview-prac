<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('tags')->get();

        return view('products', ['products' => $products]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'unique:products,name'],
                'description' => ['nullable', 'string'],
                'tags' => ['nullable', 'string'],
            ]);
        } catch (ValidationException $exception) {
            return Redirect::route('products.index')->withErrors($exception->errors());
        }

        $product = Product::create($request->only(['name', 'description']));

        if ($request->tags) {
            $tags = collect(explode(',', $request->tags))->map(function ($tag) {
                return Tag::firstOrCreate(['name' => trim($tag)]);
            });

            $product->tags()->sync($tags->pluck('id')->toArray());
        }

        return Redirect::route('products.index')->with('status', 'The product was saved');
    }

    public function destroy(Request $request, Product $id)
    {
        $id->forceDelete();

        return Redirect::route('products.index')->with('status', 'The product was deleted');
    }
}
