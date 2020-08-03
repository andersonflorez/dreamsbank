<?php

namespace App\Http\Controllers;

use App\Product;
use App\Transaction;
use Illuminate\Http\Request;
use App\Vuetable\Facades\Vuetable;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transaction = Transaction::productId($request->product_id)->with('product');

        $data = Vuetable::of($transaction)
            ->addColumn('product_text', function ($transaction) {
                return $transaction->product->name . " - "  . $transaction->product->number;
            })
            ->make();
        return $this->respondWithData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Transaction($request->all());

        if (!$product->save()) {
            return $this->respondHttp500();
        }

        return $this->respondHttp200([
            'message' => 'Se realizo la transacción'
        ]);
    }
}
