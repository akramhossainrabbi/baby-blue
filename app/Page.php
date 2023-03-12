<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = [
        'id', 'menu_title', 'page_title', 'page_subtitle', 'banner_title','banner_subtitle', 'banner_image', 'content','slug','template', 'views', 'seo_title', 'meta_key','meta_description', 'created_by', 'modified_by','status', 'created_at','updated_at'
    ];
}
