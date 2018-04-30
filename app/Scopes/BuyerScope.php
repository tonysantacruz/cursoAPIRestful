<?php


namespace App\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;


class BuyerScope implements Scope
{

    public function apply(Builder $builder, Model $model){

        //Cada vez que ejecute una consulta te traes a los compradores que tengan al menos una transacción

        $builder->has('transactions');
    }
}