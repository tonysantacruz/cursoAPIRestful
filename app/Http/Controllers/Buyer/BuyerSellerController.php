<?php

namespace App\Http\Controllers\Buyer;

use App\Seller;
use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $sellers = $buyer->transactions()
            ->with('product.seller') //Va a la relación de producto con seller
            ->get() //Obtiene datos
            ->pluck('product.seller') //Selecciona lo que quieres de la lista
            ->unique('id') //Evita las repeticiones
            ->values();


        return $this->showAll($sellers);
    }


}
