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

    // company search method
    public static function companySearch($name)
    {
        // Kijken welke name $name in companies 
        return Company::where("name", 'LIKE', "%$name%")->get();
    }
}
