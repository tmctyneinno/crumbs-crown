<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactEnquiry extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'enquiry_type',
        'message',
    ];
}