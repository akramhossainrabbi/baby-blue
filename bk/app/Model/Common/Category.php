<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        "id",
        "parent_id",
        "title",
        "color_code",
        "priority",
        "description",
        "image",
        "fav_icon",
        "catalogue_title",
        "catalogue_description",
        "catalogue_image",
        "catalogue_pdf",
        "image_gallery",
        "slug",
        "views",
        "total_posts",
        "is_featured",
       
        "seo_title",
        "meta_key",
        "meta_description",
        "created_by",
        "modified_by",
        "status"
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    public function scopeIsFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

    public function scopeIsCatalogue($query)
    {
        return $query->where('is_catalogue', 1);
    }

    public function blogs()
    {
        return $this->morphedByMany('App\Model\Common\Blog', 'categoryable');
    }

    public function products()
    {
        return $this->morphedByMany('App\Model\Common\Product', 'categoryable');
    }
}
