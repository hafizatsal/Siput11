<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table= 'desa';
    // gunakan tipe string untuk primary key non-integer agar casting tidak gagal
    protected $keyType= 'string';
}
