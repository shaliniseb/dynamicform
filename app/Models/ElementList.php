<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementList extends Model
{
    use HasFactory;
    public $fillable = ['element_type', 'label_name', 'form_id', 'default_values'];
}
