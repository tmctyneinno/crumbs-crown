<?php

namespace App\Http\Controllers;

use App\Models\ContactEnquiry;
use Illuminate\View\View;

class AdminEnquiryController extends Controller
{
    public function index(): View
    {
        return view('admin.enquiries.index', [
            'enquiries' => ContactEnquiry::query()->latest()->paginate(15),
        ]);
    }
}