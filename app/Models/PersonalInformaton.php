<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformaton extends Model
{
    use HasFactory;
    
    protected $table = 'personal_informations';
    protected $primaryKey = 'id';

    public $fillable = [
        'employeeid',
        'first_name',
        'middle_name',
        'last_name',
        'name_extension',
        'years_of_service',
        'name_title',
        'sex',
        'date_of_birth',
        'place_of_birth',
        'civil_status',
        'date_of_marriage',
        'citizenship',
        'country',
        'height',
        'weight',
        'blood_type'
    ];

    public $timestamps = TRUE;  
}
