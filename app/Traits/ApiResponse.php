<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponse
{

    /*
     * Función que devuelve la información correcta
     */
    function successResponse($data, $code = 200)
    {
        return response()->json($data, $code);
    }
    /*
     * Función que devuelve la información de error
     */
    function errorResponse($message, $code)
    {
        return response()->json(['error' =>['message' => $message, 'code' => $code]], $code);
    }
    /*
     * Función que devuelve todos los elementos
     *
     * @param Collection use Illuminate\Support\Collection;
     *
     */
    function showAll(Collection $collection, $code = 200)
    {
        return $this->successResponse(['data' => $collection], $code);
    }

    function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse(['data' => $instance], $code);
    }

    function showMessage($mesage, $code =200)
    {
        return $this->successResponse($mesage, $code);
    }
}