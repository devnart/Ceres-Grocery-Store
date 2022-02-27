<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Order::all();
    }

    public function getOrdersByUserId($id)
    {
        if (! Gate::allows('own-order', Order::findOrFail($id))) {
            abort(403, 'Wow, you almost hacked our system!');
        }

        return Order::where('user_id', $id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Order::create($request->all());
        return response()->json(['success' => 'Order has been placed successfully.']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('own-order', Order::findOrFail($id))) {
            abort(403, 'Wow, you almost hacked our system!');
        }

        return Order::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        // update the order
        $order->update($request->all());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! Gate::allows('own-order', Order::findOrFail($id))) {
            abort(403, 'Wow, you almost hacked our system!');
        }
        
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return $order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('own-order', Order::findOrFail($id))) {
            abort(403, 'Wow, you almost hacked our system!');
        }

        return Order::destroy($id);
    }
}
