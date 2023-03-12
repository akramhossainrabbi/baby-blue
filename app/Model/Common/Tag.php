<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        "id",
        "title",
        "description",
        "image",
        "slug",
        "views",
        "total_products",
        "seo_title",
        "meta_key",
        "meta_description",
        "created_by",
        "modified_by",
        "status"
    ];
    protected $table = 'tags';

    public function blogs()
    {
        return $this->morphedByMany('App\Model\Common\Blog', 'taggable');
    }

    public function products()
    {
        return $this->morphedByMany('App\Model\Common\Product', 'taggable');
    }
}
