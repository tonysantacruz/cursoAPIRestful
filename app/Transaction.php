<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //Atributos rellenables
    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id'
    ];
}
