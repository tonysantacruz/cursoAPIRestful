<?php

namespace App\Http\Controllers\Buyer;

use App\Transaction;
use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $transactions = $buyer->transactions;

        return $this->showAll($transactions);
    }

}
