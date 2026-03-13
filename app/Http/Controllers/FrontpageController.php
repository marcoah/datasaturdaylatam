<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontpageController extends Controller
{
    public function contact()
    {
        return view('frontpage.contact');
    }

    public function about()
    {
        return view('frontpage.about');
    }

    public function schedule()
    {
        return view('frontpage.schedule');
    }

    public function speakers()
    {
        return view('frontpage.speakers');
    }

    public function venue()
    {
        return view('frontpage.venue');
    }

    public function speakerDetails()
    {
        return view('frontpage.speaker-details');
    }

    public function tickets()
    {
        return view('frontpage.tickets');
    }

    public function buyTickets()
    {
        return view('frontpage.buy-tickets');
    }

    public function gallery()
    {
        return view('frontpage.gallery');
    }

    public function terms()
    {
        return view('frontpage.terms');
    }

    public function privacy()
    {
        return view('frontpage.privacy');
    }

    public function notFound()
    {
        return view('frontpage.404');
    }
}
