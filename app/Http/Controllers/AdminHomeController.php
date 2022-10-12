<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminHomeController extends Controller
{
    // 
    public function index()
    {
        $products = Product::all();
        return view('admin.adminHome', compact('products'));
    }



    //Show the forms page for editing a specific product
    public function edit(Product $product)
    {
        return view('admin.adminProductEdit', ['product'=>$product]);
    }



    // Receber requisição para atualizar um produto - PUT
    public function update(Product $product, ProductStoreRequest $request)
    {
        //validate editated product data
        $validatedProduct = $request->validated();

        // validate image
        if (!empty($validatedProduct['cover']) && $validatedProduct['cover']->isValid()){
            //delete old image
            if (!empty($product->cover)) {
                Storage::delete($product->cover);
                $product->cover = null;                
            }

            $file = $validatedProduct['cover'];
            // STORE: Method to store the image in a folder, returns the path of the folder
            $filePath = $file->store('public/products');
            $validatedProduct['cover'] = $filePath;
        } 
        
        // Sending and saving the edited product data in the model
        $product->fill($validatedProduct);
        $product->save();
        
        return redirect()->route('admin.home');
    }



    // Mostrar página de criar
    public function create()
    {
        return view('admin.adminProductCreate');
    }



    //Receber requisição de criar - POST
    public function store(ProductStoreRequest $request)
    {
        //validate product data
        $productDate = $request->validated();

        //save slug in datebase
        $productDate['slug'] = Str::slug($productDate['name'], '-');

        // validate image
        if (!empty($productDate['cover']) && $productDate['cover']->isValid()){
            $file = $productDate['cover'];
            // STORE: Method to store the image in a folder, returns the path of the folder
            $filePath = $file->store('public/products');
            $productDate['cover'] = $filePath;
        } 

        //sending the data to the model
        Product::create($productDate);

        //method to redirect the page
        return redirect()->route('admin.home');
    }


    //Product exclusion method
    public function destroy(Product $product){
        //delete image in directory
            //??: 'senão';
        Storage::delete($product->cover ?? '');
        //delete product in database
        $product->delete();
        return redirect()->route('admin.home');
    }

    //Method for deleting the product image
    public function destroyImage(Product $product){
        if (file_exists(Storage::path($product->cover))){
            Storage::delete($product->cover);
            $product->cover = null;
            $product->save();
        }
        return redirect()->back();
    }



}
