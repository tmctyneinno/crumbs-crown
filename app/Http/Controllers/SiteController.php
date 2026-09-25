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

    public function customCakes()
    {
        return view('pages.custom-cakes');
    }

    public function pastries()
    {
        return view('pages.pastries');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function connect()
    {
        return view('pages.connect');
    }
}