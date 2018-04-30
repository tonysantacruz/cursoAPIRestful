<?php

namespace App;

use App\Scopes\BuyerScope;
use App\User;
use App\Transaction;

class Buyer extends User
{
    /*
     * Método que se va a ejecutar cada vez que cree el modelo.
     * y se va a usar para las restricciones. Hereda de Model.
     * Ponerlo en la primera línea.
     * */

    protected static function boot(){
        parent::boot();

        //Hay que crear el scope a mano
        static::addGlobalScope(new BuyerScope());
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


}
