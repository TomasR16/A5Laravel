<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Model Company 
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
}
