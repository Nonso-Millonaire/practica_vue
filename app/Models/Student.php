<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    // ¡ESTA ES LA LÍNEA QUE TE FALTA!
    protected $fillable = ['name', 'email'];
}
