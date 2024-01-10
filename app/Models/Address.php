<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';
    protected $primaryKey = 'id';

    public $fillable = [
       'address',
       'zip_code',
       'is_residential_and_permanent',
       'is_residential',
       'telephone_no',
       'personal_information_id'
    ];

    public $timestamps = TRUE;  
}
