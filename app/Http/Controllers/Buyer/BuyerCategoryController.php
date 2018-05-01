<?php

namespace App\Http\Controllers\Buyer;

use App\Category;
use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $categories = $buyer->transactions()
            ->with('product.categories')
            ->get()
            ->pluck('product.categories')
            ->collapse()//Coge el array multidimensional y lo hace unidimensional
            ->unique('id')
            ->values(); //quita los índices de principio de array

        return $this->showAll($categories);
    }
}
