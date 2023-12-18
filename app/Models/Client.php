<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'company_name',
        'phone',
        'email',
        'tax_id',
        'driver_license_image',
        'payment_information',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
    

}