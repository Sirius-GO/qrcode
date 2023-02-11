<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qr_codes extends Model
{
    use HasFactory;

        //Table Name
        protected $table = 'qr_codes';
        //Primary Key
        public $primaryKey = 'id';
        //Timestamps
        public $timestamps = true;
}
