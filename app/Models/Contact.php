<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';
    protected $primaryKey = 'id';

    public $fillable = [
       'phone_number',
       'email_address',
       'personal_information_id'
    ];

    public $timestamps = TRUE;  
}
