<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        return view('products');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'unique:products,name'],
                'description' => ['nullable', 'string'],
            ]);
        } catch (ValidationException $exception) {
            return Redirect::route('products.index')->withErrors($exception->errors());
        }

        Product::create($request->only(['name', 'description']));

        return Redirect::route('products.index')->with('status', 'The product was saved');
    }

    public function destroy(Request $request, Product $id)
    {
        $id->forceDelete();

        return Redirect::route('products.index')->with('status', 'The product was deleted');
    }
}
