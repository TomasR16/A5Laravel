<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    
    protected $filltable = ['firstname', 'lastname', 'email', 'city', 
        'country', 'job_Title'];
}
