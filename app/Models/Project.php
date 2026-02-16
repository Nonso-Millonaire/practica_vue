<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $fillable = ['title', 'description', 'content']; // O los campos que tengas en tu tabla projects
}
