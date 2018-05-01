<?php

namespace App\Http\Controllers\Category;

use App\Transaction;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $transactions = $category->products()
            ->whereHas('transactions') //Busca los productos que tengan transacciones
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();

        return $this->showAll($transactions);
    }

}
