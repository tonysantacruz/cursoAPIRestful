<?php

namespace App\Http\Controllers\Seller;

use App\Product;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;

        return $this->showAll($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function create(Seller $seller)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Seller $seller)
    {
        $data = $request->validate([
            'name' => 'required | max:255',
            'description' => 'required | max:255',
            'quantity' => 'required | min:1',

        ]);

        $data['status'] = Product::NOT_AVAILABLE;
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);

        return $this->showOne($product, 201);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Seller  $seller
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Seller $seller, Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
        $data = $request->validate([
           'name' => 'max:255',
           'description' => 'max:1000',
           'quantity' => 'integer|min:1',
           'status' => 'in:' . Product::AVAILABLE . ',' . Product::NOT_AVAILABLE,
        ]);

        $this->checkSeller($seller , $product);

        $product->fill($data);

        $product->status = $request->status;
        if($product->status === Product::AVAILABLE && $product->categories()->count()=== 0)
        {
            return $this->errorResponse('An active product must have at least one category', 409);
        }


        if($product->isClean())
        {
            return $this->errorResponse('Please specify at least one new value to update.', 409);
        }

        $product->save();

        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);

        $product->delete();

        return $this->showOne($product);
    }

    /**
     * Checks if the specified seller is the same as the product seller.
     *
     * @param  \App\Seller  $seller
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    function checkSeller(Seller $seller , Product $product)
    {
        if($seller->id != $product->seller_id)
        {
            throw new HttpException(403, 'The specified seller is not the actual seller of this product');
        }
    }
}
