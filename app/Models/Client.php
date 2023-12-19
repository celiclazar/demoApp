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
        'document_file',
        'payment_information',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
    
    public function hasCompleteInfo()
    {
        $requiredFields = ['company_name', 'phone', 'email', 'tax_id', 'driver_license_image', 'document_file'];

        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }

        return true;
    }

}
