<?php

namespace App\Http\Controllers\Seller;

use App\Transaction;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $transactions = $seller->products()
            ->whereHas('transactions') //para asegurarnos que los productos tengan transacciones
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();

        return $this->showAll($transactions);
    }

}
