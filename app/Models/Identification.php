<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identification extends Model
{
    use HasFactory;
    protected $table = 'identification_numbers';
    protected $primaryKey = 'id';

    public $fillable = [
       'gsis_id_no',
       'pag_ibig_id_no',
       'philhealth_id_no',
       'sss_id_no',
       'prc_id_no',
       'tin_id_no',
       'rdo_no',
       'personal_information_id'
    ];

    public $timestamps = TRUE;  
}
