<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller for handling booking-related actions.
 */
class BookingController extends Controller
{
    /**
     * Show the booking check page.
     *
     * @return \Illuminate\View\View
     */
    public function check()
    {
        return view('pages.check-booking');
    }
}
