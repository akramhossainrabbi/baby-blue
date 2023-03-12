<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'sliders';

    protected $fillable = [
        'id', 'style', 'title', 'description', 'image','extra', 'status', 'created_at','updated_at', 'created_by', 'modified_by'
    ];
}
