<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormList extends Model
{
    use HasFactory;
    public $fillable = ['form_name'];

}
