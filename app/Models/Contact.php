<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    // Velden in Contact table van database
    protected $fillable = [
        'first_name', 'last_name', 'company_id', 'email', 'city',
        'country', 'job_title'
    ];

    public function company()
    {
        // Toevoegen van relatie 
        return $this->belongsTo('App\Models\Company', 'company_id');
    }

    public static function contactSearch($name) {
        return Contact::where("first_name", 'LIKE', "%$name%")->orWhere("last_name", 'LIKE', "%$name%")->orWhere("email", "LIKE", "%$name%")->get();
    }
}
