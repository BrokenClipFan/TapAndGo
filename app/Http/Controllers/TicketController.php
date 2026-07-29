<?php

namespace App\Http\Controllers;

use App\Models\Order;

class TicketController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order)
    {
        return view('ticket', compact('order'));
    }
}
