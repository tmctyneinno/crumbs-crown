<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

    public function shop()
    {
        return view('pages.shop');
    }

    public function cakes()
    {
        return view('pages.cakes');
    }

    public function corporate()
    {
        return view('pages.corporate');
    }

    public function wedding()
    {
        return view('pages.wedding');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}